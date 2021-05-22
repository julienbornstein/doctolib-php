<?php

declare(strict_types=1);

namespace Doctolib;

use Doctolib\DataDenormalizer\AvailabilityDataDenormalizer;
use Doctolib\DataDenormalizer\BookingDataDenormalizer;
use Doctolib\DataDenormalizer\SearchProfilesDataDenormalizer;
use Doctolib\Exception\DataNotFoundException;
use Doctolib\Exception\UnavailableSlotException;
use Doctolib\Model\Agenda;
use Doctolib\Model\Appointment;
use Doctolib\Model\Availability;
use Doctolib\Model\Booking;
use Doctolib\Model\Patient;
use Doctolib\Model\Profile;
use Doctolib\Model\Slot;
use Doctolib\Model\Speciality;
use Doctolib\Model\Step;
use Doctolib\Model\VisitMotive;
use Doctolib\Test\Utils\QueryStringUtils;
use Doctolib\Utils\ArrayUtils;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Webmozart\Assert\Assert;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Client
{
    use ClientTrait;

    private const BASE_URI = 'https://www.doctolib.fr';

    private const SESSION_COOKIE_KEY = '_doctolib_session';

    private const TEMPORARY_APPOINTMENT_ID_COOKIE_KEY = 'temporary_appointment_id';

    private HttpClientInterface $httpClient;

    private SerializerInterface $serializer;

    private ?string $sessionId = null;

    public function __construct(HttpClientInterface $httpClient, SerializerInterface $serializer = null)
    {
        $this->httpClient = $httpClient;
        $this->serializer = $serializer ?? SerializerFactory::create();
    }

    public function setSessionId(?string $sessionId): void
    {
        $this->sessionId = $sessionId;
    }

    /**
     * Note: Currently not working because Cloudflare.
     * A "valid" browser with javascript support is required.
     *
     * @throws ClientExceptionInterface
     * @throws decodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws ExceptionInterface
     */
    public function auth(string $email, string $password): Patient
    {
        Assert::email($email);

        $response = $this->httpClient->request('POST', '/login.json', [
            'base_uri' => self::BASE_URI,
            'json' => [
                'username' => $email,
                'password' => $password,
                // 'remember' => true,
                // 'remember_username' => true,
                'kind' => 'patient',
            ],
        ]);

        $this->checkJsonResponse($response);
        $this->checkAuth($response);  // todo: see if we can use checkApiError()
        $this->checkApiError($response);

        $sessionIdCookie = $this->getCookieFromResponse($response, self::SESSION_COOKIE_KEY);

        if (!$sessionIdCookie instanceof Cookie) {
            throw new \RuntimeException('Session cookie not found in response.');
        }

        $this->setSessionId($sessionIdCookie->getValue());

        return $this->denormalize($response->toArray(), Patient::class);
    }

    /**
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws ExceptionInterface
     */
    public function getMasterPatient(): Patient
    {
        $this->checkIsAuthenticated();

        $response = $this->httpClient->request('GET', '/account/main_master_patient.json', [
            'base_uri' => self::BASE_URI,
            'headers' => [
                'Cookie' => sprintf('%s=%s', self::SESSION_COOKIE_KEY, $this->sessionId),
            ],
        ]);

        $this->checkJsonResponse($response);
        $this->checkApiError($response);

        return $this->denormalize($response->toArray(), Patient::class);
    }

    /**
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     *
     * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
     */
    public function search(string $query, bool $specialitiesOnly = false): array
    {
        $response = $this->httpClient->request('GET', '/api/searchbar/autocomplete.json', [
            'base_uri' => self::BASE_URI,
            'query' => [
                'search' => $query,
                'specialities_only' => $specialitiesOnly,
            ],
        ]);

        $this->checkJsonResponse($response);

        $data = $response->toArray();
        $data['profiles'] = ArrayUtils::renameKey($data['profiles'], 'value', 'id');
        $data['specialities'] = ArrayUtils::renameKey($data['specialities'], 'value', 'id');

        $profiles = $this->denormalize($data['profiles'], Profile::class.'[]');
        $specialities = $this->denormalize($data['specialities'], Speciality::class.'[]');

        return [
            'profiles' => $profiles,
            'specialities' => $specialities,
            //'organizationStatuses' => $organizationStatuses,
        ];
    }

    /**
     * @param mixed $query
     *
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws ExceptionInterface
     * @throws ClientExceptionInterface
     *
     * @return Profile[]
     */
    public function searchProfilesBySpecialityAndLocation(string $specialitySlug, string $locationSug, $query = []): array
    {
        $resolver = new OptionsResolver();
        $resolver->setDefaults([
            'latitude' => null,
            'longitude' => null,
            'ref_visit_motive_ids' => null,
        ]);
        $resolver->setAllowedTypes('latitude', ['float', 'null']);
        $resolver->setAllowedTypes('longitude', ['float', 'null']);
        $resolver->setAllowedTypes('ref_visit_motive_ids', ['array', 'null']);

        $url = sprintf('%s/%s.json', $specialitySlug, $locationSug);
        $query = $resolver->resolve($query);

        $response = $this->httpClient->request(
            'GET',
            QueryStringUtils::createUrlWithQueryString($url, $query), [
                'base_uri' => self::BASE_URI,
            ]);

        $this->checkJsonResponse($response);

        $content = SearchProfilesDataDenormalizer::denormalize($response->toArray());

        return $this->denormalize($content['data']['doctors'], Profile::class.'[]');
    }

    /**
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws ExceptionInterface
     */
    public function getBooking(string $doctorSlug): Booking
    {
        $response = $this->httpClient->request('GET', sprintf('/booking/%s.json', $doctorSlug), [
            'base_uri' => self::BASE_URI,
        ]);

        if (404 === $response->getStatusCode()) {
            throw new DataNotFoundException(sprintf('Doctor with slug "%s" not found.', $doctorSlug));
        }

        $this->checkJsonResponse($response);

        $content = $response->toArray();
        $content = BookingDataDenormalizer::denormalize($content);

        return $this->denormalize($content['data'], Booking::class);
    }

    /**
     * @param Agenda[] $agendas
     *
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     *
     * @return Availability[]
     */
    public function getAvailabilities(array $agendas, ?\DateTimeInterface $startDate = null, ?int $refVisitMotiveId = null): array
    {
        $startDate = $startDate ?? new \DateTime();

        $visitMotives = Agenda::getVisitMotivesForAgendas($agendas);

        // filter Agenda's VisitMotives where parent is $refVisitMotiveId
        if (null !== $refVisitMotiveId) {
            $visitMotives = array_values(array_filter(
                $visitMotives,
                static fn (VisitMotive $visitMotive) => $visitMotive->getRefVisitMotiveId() === $refVisitMotiveId
            ));
        }

        $visitMotiveIds = array_values(array_unique(array_map(static fn (VisitMotive $visitMotive) => $visitMotive->getId(), $visitMotives)));

        if (0 === \count($visitMotiveIds)) {
            return [];
        }

        // keep only agenda with given VisitMotives (useless but cleaner)
        $agendas = array_values(array_filter($agendas, function (Agenda $agenda) use ($visitMotiveIds) {
            foreach ($agenda->getVisitMotives() as $agendaVisitMotive) {
                if (\in_array($agendaVisitMotive->getId(), $visitMotiveIds, true)) {
                    return true;
                }
            }

            return false;
        }));

        $agendaIds = array_map(static fn (Agenda $agenda) => $agenda->getId(), $agendas);

        $query = [
            'start_date' => $startDate->format('Y-m-d'),
            'visit_motive_ids' => implode('-', $visitMotiveIds),
            'agenda_ids' => implode('-', $agendaIds),
            'limit' => 20,
        ];

        $response = $this->httpClient->request('GET', '/availabilities.json', [
            'base_uri' => self::BASE_URI,
            'query' => $query,
        ]);

        $this->checkJsonResponse($response);

        $content = $response->toArray();

        if (\array_key_exists('next_slot', $content)) {
            return $this->getAvailabilities($agendas, new \DateTimeImmutable($content['next_slot']), $refVisitMotiveId);
        }

        $content = AvailabilityDataDenormalizer::denormalize($content);

        $availabilities = $this->denormalize($content['availabilities'], Availability::class.'[]');

        return array_values(array_filter($availabilities, static fn (Availability $availability) => 0 < \count($availability->getSlots())));
    }

    /**
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws ExceptionInterface
     */
    public function createAppointment(Booking $booking, VisitMotive $visitMotive, Slot $slot): Appointment
    {
        $this->checkIsAuthenticated();

        $profile = $booking->getProfile();
        $agendas = $booking->getAgendas();

        $agendasIds = implode('-', array_unique(array_map(static fn (Agenda $agenda) => $agenda->getId(), $agendas)));

        $body = [
            'appointment' => [
                'source_action' => 'profile', // "profile", "search", ...
                'profile_id' => $profile->getId(),
                'visit_motive_ids' => (string) $visitMotive->getId(), // note: need a string, else 500 server error
                'start_date' => $slot->getStartDate()->format(\DateTimeInterface::RFC3339_EXTENDED),
            ],
            //'speciality_id' => null,
            //'agenda_ids' => $agenda->getId(),
            'agenda_ids' => $agendasIds,
            //
            //'practice_ids' => [],
            // 'reset_visit_motive' => false, // Todo check whats it is ?
            // 'to_finalize_step' => true, // Todo check whats it is ?
            // 'to_finalize_step_without_state' => true, // Todo check whats it is ?
        ];

        $response = $this->httpClient->request('POST', '/appointments.json', [
            'base_uri' => self::BASE_URI,
            'json' => $body,
            'headers' => [
                'Cookie' => sprintf('%s=%s', self::SESSION_COOKIE_KEY, $this->sessionId),
            ],
        ]);

        $this->checkJsonResponse($response);
        $this->checkApiError($response);

        return $this->denormalize($response->toArray(), Appointment::class);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     * @throws UnavailableSlotException
     * @throws ExceptionInterface
     */
    public function createMultiStepAppointment(Booking $booking, Slot $slot): Appointment
    {
        $steps = $slot->getSteps();
        if (0 === \count($steps)) {
            throw new \InvalidArgumentException('The Slot has not Steps.');
        }

        $this->checkIsAuthenticated();

        $profile = $booking->getProfile();

        [$firstStep, $secondStep] = $steps;

        $agendasIds = implode('-', array_unique(array_map(static fn (Step $step) => $step->getAgendaId(), $steps)));

        $body = [
            'appointment' => [
                'source_action' => 'profile', // "profile", "search", ...
                'profile_id' => $profile->getId(),
                'visit_motive_ids' => (string) $firstStep->getVisitMotiveId(), // note: need a string, else 500 server error
                'start_date' => $firstStep->getStartDate()->format(\DateTimeInterface::RFC3339_EXTENDED),
            ],
            //'speciality_id' => null,
            //'agenda_ids' => $agenda->getId(),
            'agenda_ids' => $agendasIds,
            //
            //'practice_ids' => [],
            // 'reset_visit_motive' => false, // Todo check whats it is ?
            // 'to_finalize_step' => true, // Todo check whats it is ?
            // 'to_finalize_step_without_state' => true, // Todo check whats it is ?
        ];

        $response = $this->httpClient->request('POST', '/appointments.json', [
            'base_uri' => self::BASE_URI,
            'json' => $body,
            'headers' => [
                'Cookie' => sprintf('%s=%s', self::SESSION_COOKIE_KEY, $this->sessionId),
            ],
        ]);

        $this->checkJsonResponse($response);
        $this->checkApiError($response);

        /** @var Appointment $appointment */
        $appointment = $this->denormalize($response->toArray(), Appointment::class);

        $temporaryAppointmentIdCookie = $this->getCookieFromResponse($response, self::TEMPORARY_APPOINTMENT_ID_COOKIE_KEY);

        if (!$temporaryAppointmentIdCookie instanceof Cookie) {
            throw new \LogicException(sprintf('Cookie "%s" not found.', self::TEMPORARY_APPOINTMENT_ID_COOKIE_KEY));
        }

        $appointment->setTemporaryAppointmentId($temporaryAppointmentIdCookie->getValue());

        $body['second_slot'] = $secondStep->getStartDate()->format(\DateTimeInterface::RFC3339_EXTENDED);

        $response = $this->httpClient->request('POST', '/appointments.json', [
            'base_uri' => self::BASE_URI,
            'json' => $body,
            'headers' => [
                'Cookie' => sprintf(
                    '%s=%s;%s=%s',
                    self::SESSION_COOKIE_KEY,
                    $this->sessionId,
                    self::TEMPORARY_APPOINTMENT_ID_COOKIE_KEY,
                    $appointment->getTemporaryAppointmentId()
                ),
            ],
        ]);

        $this->checkJsonResponse($response);
        $this->checkApiError($response);

        return $this->denormalize($response->toArray(), Appointment::class);
    }

    /**
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function confirmAppointment(Appointment $appointment, Patient $patient): Appointment
    {
        $this->checkIsAuthenticated();

        if (!$this->serializer instanceof NormalizerInterface) {
            throw new \InvalidArgumentException('Serializer is not a Normalizer.');
        }
        $normalizedPatient = $this->serializer->normalize($patient); // todo: use json_decode() ?

        $body = [
            // 'new_patient' => true,
            // 'bypass_mandatory_relative_contact_info' => false,
            // 'phone_number' => null,
            // 'email' => null,
            'master_patient' => $normalizedPatient,
            //'patient' => null,
            // 'appointment' => [
            //     'qualification_answers' => [],
            //     'new_patient' => true,
            //     'custom_fields_values' => [],
            //     'referrer_id' => null,
            // ],
        ];

        $url = sprintf('/appointments/%s.json', $appointment->getId());
        $response = $this->httpClient->request('PUT', $url, [
            'base_uri' => self::BASE_URI,
            'json' => $body,
            'headers' => [
                'Cookie' => sprintf('%s=%s', self::SESSION_COOKIE_KEY, $this->sessionId),
            ],
        ]);

        $this->checkJsonResponse($response);
        $this->checkApiError($response);

        return $this->denormalize($response->toArray(), Appointment::class);
    }

    public function getUpcomingAppointments(): array
    {
        $this->checkIsAuthenticated();

        // todo: add pagination support
        $response = $this->httpClient->request('GET', '/account/appointments.json', [
            'base_uri' => self::BASE_URI,
            'headers' => [
                'Cookie' => sprintf('%s=%s', self::SESSION_COOKIE_KEY, $this->sessionId),
            ],
        ]);

        $this->checkJsonResponse($response);
        $this->checkApiError($response);

        $data = $response->toArray()['data'];

        return $this->denormalize($data['confirmed'], Appointment::class.'[]');
    }

    public function getAppointment(string $appointmentId): Appointment
    {
        $this->checkIsAuthenticated();

        $url = sprintf('/appointments/%s.json', $appointmentId);

        $response = $this->httpClient->request('GET', $url, [
            'base_uri' => self::BASE_URI,
            'headers' => [
                'Cookie' => sprintf('%s=%s', self::SESSION_COOKIE_KEY, $this->sessionId),
            ],
        ]);

        $this->checkJsonResponse($response);
        $this->checkApiError($response);

        return $this->denormalize($response->toArray(), Appointment::class);
    }

    public function deleteAppointment(Appointment $appointment): void
    {
        $this->checkIsAuthenticated();

        $url = sprintf('/account/appointments/%s.json', $appointment->getId());
        $response = $this->httpClient->request('DELETE', $url, [
            'base_uri' => self::BASE_URI,
            'headers' => [
                'Content-Type' => 'application/json',
                'Cookie' => sprintf('%s=%s', self::SESSION_COOKIE_KEY, $this->sessionId),
            ],
        ]);

        $this->checkJsonResponse($response);
        $this->checkApiError($response);
    }
}
