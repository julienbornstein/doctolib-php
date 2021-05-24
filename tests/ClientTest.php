<?php

declare(strict_types=1);

namespace Doctolib\Test;

use Doctolib\Client;
use Doctolib\Exception\AuthenticationException;
use Doctolib\Exception\DataNotFoundException;
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
use Doctolib\SerializerFactory;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

/**
 * @covers \Doctolib\Client
 *
 * @internal
 */
class ClientTest extends TestCase
{
    use ProphecyTrait;

    private SerializerInterface $serializer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->serializer = SerializerFactory::create();
    }

    public function testSearchDoctorsByLocation(): void
    {
        $httpClient = new MockHttpClient([
            ResponseFixtureFactory::createSearchProfiles(),
        ]);

        $client = new Client($httpClient, $this->serializer);

        $results = $client->searchProfilesBySpecialityAndLocation('foo', 'bar', ['latitude' => 10.0, 'longitude' => 5.0]);

        $this->assertContainsOnlyInstancesOf(Profile::class, $results);
        $this->assertCount(10, $results);
        $profile0 = $results[0];

        $this->assertSame(1406598, $profile0->getId());
        $this->assertSame('/centre-de-sante/paris/centre-acces-vision', $profile0->getLink());
        $this->assertSame(97958, $profile0->getProfileId());
        $this->assertSame('47 Rue des Mathurins', $profile0->getAddress());
        $this->assertSame('Paris', $profile0->getCity());
        $this->assertSame('75008', $profile0->getZipcode());
        $this->assertSame('Centres Accès Vision', $profile0->getLastName());
        $this->assertSame('Centres Accès Vision', $profile0->getNameWithTitle());
        $this->assertNull($profile0->getFirstName());
        $this->assertNull($profile0->getSpeciality());

        $profile1 = $results[1];
        $this->assertSame(1473925, $profile1->getId());
        $this->assertSame('/ophtalmologue/paris/john-seed', $profile1->getLink());
        $this->assertSame(58877, $profile1->getProfileId());
        $this->assertSame('90 Rue Saint-Lazare', $profile1->getAddress());
        $this->assertSame('Paris', $profile1->getCity());
        $this->assertSame('75009', $profile1->getZipcode());
        $this->assertSame('SEED', $profile1->getLastName());
        $this->assertSame('Dr John SEED', $profile1->getNameWithTitle());
        $this->assertSame('John', $profile1->getFirstName());
        $speciality = $profile1->getSpeciality();
        $this->assertInstanceOf(Speciality::class, $speciality);
        $this->assertSame(4, $speciality->getId());
        $this->assertSame('Ophtalmologue', $speciality->getName());
        $this->assertSame('ophtalmologue', $speciality->getSlug());
    }

    public function testSearchAutocomplete(): void
    {
        $httpClient = new MockHttpClient([
            ResponseFixtureFactory::createAutocomplete(),
        ]);

        $client = new Client($httpClient, $this->serializer);

        $response = $client->search('foo');

        $this->assertArrayHasKey('profiles', $response);
        $this->assertArrayHasKey('specialities', $response);

        $profiles = $response['profiles'];
        $specialities = $response['specialities'];

        $this->assertContainsOnlyInstancesOf(Profile::class, $profiles);
        $this->assertContainsOnlyInstancesOf(Speciality::class, $specialities);
    }

    public function testGetBookingOk(): void
    {
        $httpClient = new MockHttpClient([
            ResponseFixtureFactory::createBooking(),
        ]);

        $client = new Client($httpClient, $this->serializer);

        $booking = $client->getBooking('docteur-denfer');

        $this->assertInstanceOf(Booking::class, $booking);
        $this->assertSame('Dr Anne MARTIN', $booking->getProfile()->getNameWithTitle());
        $this->assertCount(3, $booking->getAgendas());
    }

    public function testGetBookingProfileNotFoundThrows404(): void
    {
        $responses = [
            new MockResponse('{}', [
                'http_code' => 404,
                'response_headers' => [
                    'content-type' => ['application/json; charset=utf-8'],
                ],
            ]),
        ];

        $httpClient = new MockHttpClient($responses);

        $client = new Client($httpClient, $this->serializer);

        $this->expectException(DataNotFoundException::class);
        $this->expectExceptionMessage('Doctor with slug "foo" not found');

        $client->getBooking('foo');
    }

    public function testGetAvailabilitiesReturnResults(): void
    {
        $httpClient = new MockHttpClient([
            ResponseFixtureFactory::createAvailabilities(),
        ]);

        $client = new Client($httpClient, $this->serializer);

        $agenda = FixtureGenerator::createAgenda(); // $agenda data is not used in this test
        $availabilities = $client->getAvailabilities([$agenda], null, null);

        $this->assertContainsOnlyInstancesOf(Availability::class, $availabilities);
        $this->assertCount(3, $availabilities);
    }

    public function testGetAvailabilitiesIsFilteringByRefVisitMotiveIds(): void
    {
        $testDate = new \DateTime('2021-05-21');
        $response = $this->prophesize(ResponseInterface::class);
        $response->getHeaders(false)->willReturn(['content-type' => ['application/json']]);
        $response->toArray()->willReturn(['availabilities' => []]);

        $httpClient = $this->prophesize(HttpClientInterface::class);
        $httpClient->request('GET', '/availabilities.json', [
            'base_uri' => 'https://www.doctolib.fr',
            'query' => [
                'start_date' => $testDate->format('Y-m-d'),
                'visit_motive_ids' => implode('-', [471266]),
                'agenda_ids' => implode('-', [78520]),
                'limit' => 20,
            ],
        ])->shouldBeCalledOnce()->willReturn($response->reveal());

        $client = new Client($httpClient->reveal(), $this->serializer);

        $agenda = FixtureGenerator::createAgenda();

        $client->getAvailabilities([$agenda], $testDate, 436);
    }

    public function testGetAvailabilitiesWithFilteringByRefVisitMotiveIdsDontReturnResultsShouldNotCallHttpClient(): void
    {
        $testDate = new \DateTime('2021-05-21');
        $response = $this->prophesize(ResponseInterface::class);
        $response->getHeaders(false)->willReturn(['content-type' => ['application/json']]);
        $response->toArray()->willReturn(['availabilities' => []]);

        $httpClient = $this->prophesize(HttpClientInterface::class);
        $httpClient->request('GET', '/availabilities.json', Argument::type('array'))->shouldNotBeCalled();

        $client = new Client($httpClient->reveal(), $this->serializer);

        $agenda = FixtureGenerator::createAgenda();

        $client->getAvailabilities([$agenda], $testDate, 1); // 1 is not valid
    }

    public function testGetAvailabilitiesWillFilterAgendasBeforeCallingHttpClient(): void
    {
        $testDate = new \DateTime('2021-05-21');
        $response = $this->prophesize(ResponseInterface::class);
        $response->getHeaders(false)->willReturn(['content-type' => ['application/json']]);
        $response->toArray()->willReturn(['availabilities' => []]);

        $httpClient = $this->prophesize(HttpClientInterface::class);
        $httpClient->request('GET', '/availabilities.json', [
            'base_uri' => 'https://www.doctolib.fr',
            'query' => [
                'start_date' => $testDate->format('Y-m-d'),
                'visit_motive_ids' => implode('-', [471266]),
                'agenda_ids' => implode('-', [78520]),
                'limit' => 20,
            ],
        ])->shouldBeCalledOnce()->willReturn($response->reveal());

        $client = new Client($httpClient->reveal(), $this->serializer);

        $agendas = [
            FixtureGenerator::createAgenda(),
            new Agenda( // adding an agenda not matching refVisitMotiveId
                78521,
                [
                    new VisitMotive(9999,
                        'Foobar',
                        9998,
                        new Speciality(1, 'Foo Speciality', 'foo'),
                        true,
                        9997,
                        null
                    ),
                ]
            ),
        ];

        $client->getAvailabilities($agendas, $testDate, 436);
    }

    public function testGetAvailabilitiesReturnNextSlotDate(): void
    {
        $testDate = new \DateTime('2021-05-21');
        $response1 = $this->prophesize(ResponseInterface::class);
        $response1->getHeaders(false)->willReturn(['content-type' => ['application/json']]);
        $response1->toArray()->willReturn(['next_slot' => '2021-05-28']);

        $response2 = $this->prophesize(ResponseInterface::class);
        $response2->getHeaders(false)->willReturn(['content-type' => ['application/json']]);
        $response2->toArray()->willReturn(['availabilities' => []]);

        $httpClient = $this->prophesize(HttpClientInterface::class);

        $httpClient->request('GET', '/availabilities.json', [
            'base_uri' => 'https://www.doctolib.fr',
            'query' => [
                'start_date' => $testDate->format('Y-m-d'),
                'visit_motive_ids' => implode('-', [471266]),
                'agenda_ids' => implode('-', [78520]),
                'limit' => 20,
            ],
        ])->shouldBeCalledOnce()->willReturn($response1->reveal());

        $httpClient->request('GET', '/availabilities.json', [
            'base_uri' => 'https://www.doctolib.fr',
            'query' => [
                'start_date' => '2021-05-28',
                'visit_motive_ids' => implode('-', [471266]),
                'agenda_ids' => implode('-', [78520]),
                'limit' => 20,
            ],
        ])->shouldBeCalledOnce()->willReturn($response2->reveal());

        $client = new Client($httpClient->reveal(), $this->serializer);

        $agenda = FixtureGenerator::createAgenda();

        $client->getAvailabilities([$agenda], $testDate, 436);
    }

    public function testGetMasterPatientNeedAuthentication(): void
    {
        $httpClient = new MockHttpClient([
            ResponseFixtureFactory::createMasterPatient(),
        ]);

        $client = new Client($httpClient, $this->serializer);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Not authenticated.');

        $client->getMasterPatient();
    }

    public function testGetMasterPatientReturnPatientIfAuthenticated(): void
    {
        $httpClient = new MockHttpClient([
            ResponseFixtureFactory::createMasterPatient(),
        ]);

        $client = new Client($httpClient, $this->serializer);
        $client->setSessionId('test-session-id');

        $patient = $client->getMasterPatient();

        $this->assertInstanceOf(Patient::class, $patient);
        $this->assertSame('Julien', $patient->getFirstName());
        $this->assertSame('Foobar', $patient->getLastName());
        $this->assertSame('Foobar', $patient->getMaidenName());
        $this->assertSame('julien@foo.com', $patient->getEmail());
        $this->assertSame('+33699999999', $patient->getPhoneNumber());
        $this->assertSame('75009', $patient->getZipcode());
        $this->assertSame('Paris', $patient->getCity());
        $this->assertSame('18 rue Pigalle', $patient->getAddress());
        $this->assertSame('1978-08-13', $patient->getBirthdate()->format('Y-m-d'));
        $this->assertNull($patient->getDeletedAt());
        $this->assertSame('18 rue Pigalle', $patient->getAddress());
        $this->assertSame('2016-06-03 11:14:19', $patient->getCreatedAt()->format('Y-m-d H:i:s'));
        $this->assertSame('2021-05-12 14:51:01', $patient->getUpdatedAt()->format('Y-m-d H:i:s'));
        $this->assertSame('2021-05-12 14:51:01', $patient->getConsentedAt()->format('Y-m-d H:i:s'));
        $this->assertSame('main', $patient->getKind());
    }

    /**
     * @covers \Doctolib\Client::checkAuth
     * @covers \Doctolib\Exception\AuthenticationException
     */
    public function testAuthWithBadCredentialThrowsAuthenticationException(): void
    {
        $responses = [
            new MockResponse('{}', [
                'http_code' => 401,
                'response_headers' => [
                    'content-type' => ['application/json; charset=utf-8'],
                ],
            ]),
        ];

        $httpClient = new MockHttpClient($responses);
        $serializer = $this->prophesize(SerializerInterface::class);

        $client = new Client($httpClient, $serializer->reveal());
        $client->setSessionId('test-session-id');

        $this->expectException(AuthenticationException::class);
        $this->expectExceptionMessage('HTTP 401 returned for "https://www.doctolib.fr/login.json".');

        $client->auth('foo@bar.com', 'invalid-password');
    }

    public function testIfAuthRequestDontReturnCookieSessionItThrowsException(): void
    {
        $responses = [
            new MockResponse('{}', [
                'response_headers' => [
                    'content-type' => ['application/json; charset=utf-8'],
                    'set-cookie' => [
                        '__cfwaitingroom=foobar; Path=/; Expires=Sun, 16 May 2021 20:23:00 GMT; HttpOnly; Secure',
                        '__cf_bm=foobaz; path=/; expires=Sun, 16-May-21 20:23:02 GMT; domain=.doctolib.fr; HttpOnly; Secure; SameSite=None',
                    ],
                ],
            ]),
        ];

        $httpClient = new MockHttpClient($responses);
        $serializer = $this->prophesize(SerializerInterface::class);

        $client = new Client($httpClient, $serializer->reveal());
        $client->setSessionId('test-session-id');

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Session cookie not found in response.');

        $client->auth('foo@bar.com', 'P@s$wØrd');
    }

    public function testAuthRequestShouldReturnCookieSession(): void
    {
        $responses = [
            new MockResponse('{}', [
                'response_headers' => [
                    'content-type' => ['application/json; charset=utf-8'],
                    'set-cookie' => [
                        '__cfwaitingroom=foobar; Path=/; Expires=Sun, 16 May 2021 20:23:00 GMT; HttpOnly; Secure',
                        '__cf_bm=foobaz; path=/; expires=Sun, 16-May-21 20:23:02 GMT; domain=.doctolib.fr; HttpOnly; Secure; SameSite=None',
                        '_doctolib_session=foobarbaz; path=/; expires=Sun, 16-May-21 20:23:02 GMT; domain=.doctolib.fr; HttpOnly; Secure; SameSite=None',
                    ],
                ],
            ]),
        ];
        $httpClient = new MockHttpClient($responses);

        $serializer = $this->prophesize(SerializerInterface::class);
        $serializer->willImplement(DenormalizerInterface::class);
        $serializer
            ->denormalize([], Patient::class, 'json')
            ->shouldBeCalledOnce()
            ->willReturn(FixtureGenerator::createPatient());

        $client = new Client($httpClient, $serializer->reveal());

        $client->auth('foo@bar.com', 'P@s$wØrd');
    }

    public function testCreateAppointment(): void
    {
        $response = $this->prophesize(ResponseInterface::class);
        $response->getHeaders(false)->willReturn(['content-type' => ['application/json']]);
        $response->toArray()->willReturn([
            'id' => '123456-azerty',
            'start_date' => '2021-05-21T15:10:00.000+02:00',
            'end_date' => '2021-05-21T15:30:00.000+02:00',
            'agenda_id' => 1,
            'visit_motive_id' => 471266,
            'redirection' => '/account/new',
            'final_step' => false,
        ]);

        $httpClient = $this->prophesize(HttpClientInterface::class);
        $httpClient->request('POST', '/appointments.json', [
            'base_uri' => 'https://www.doctolib.fr',
            'json' => [
                'appointment' => [
                    'source_action' => 'profile',
                    'profile_id' => 123456,
                    'visit_motive_ids' => '471266',
                    'start_date' => '2021-05-21T15:10:00.000+02:00',
                ],
                'agenda_ids' => '78520',
            ],
            'headers' => [
                'Cookie' => '_doctolib_session=test-session-id',
            ],
        ])->shouldBeCalledOnce()->willReturn($response->reveal());

        $client = new Client($httpClient->reveal(), $this->serializer);
        $client->setSessionId('test-session-id');

        $booking = FixtureGenerator::createBooking();
        $visitMotive = FixtureGenerator::createVisitMotive();
        $slot = new Slot(new \DateTime('2021-05-21 15:10:00', new \DateTimeZone('Europe/Paris')));

        $client->createAppointment($booking, $visitMotive, $slot);
    }

    public function testCreateMultiStepAppointment(): void
    {
        $response = $this->prophesize(ResponseInterface::class);
        $response->getHeaders(false)->willReturn([
            'content-type' => ['application/json'],
            'set-cookie' => ['temporary_appointment_id=foo-bar-id'],
        ]);
        $response->toArray()->willReturn([
            'id' => '123456-azerty',
            'start_date' => '2021-05-21T15:10:00.000+02:00',
            'end_date' => '2021-05-21T15:30:00.000+02:00',
            'agenda_id' => 1,
            'visit_motive_id' => 471266,
            'redirection' => '/account/new',
            'final_step' => false,
        ]);

        $httpClient = $this->prophesize(HttpClientInterface::class);
        $httpClient->request('POST', '/appointments.json', [
            'base_uri' => 'https://www.doctolib.fr',
            'json' => [
                'appointment' => [
                    'source_action' => 'profile',
                    'profile_id' => 123456,
                    'visit_motive_ids' => '471266',
                    'start_date' => '2021-05-21T15:10:00.000+02:00',
                ],
                'agenda_ids' => '78520',
            ],
            'headers' => [
                'Cookie' => '_doctolib_session=test-session-id',
            ],
        ])->shouldBeCalledOnce()->willReturn($response->reveal());

        $httpClient->request('POST', '/appointments.json', [
            'base_uri' => 'https://www.doctolib.fr',
            'json' => [
                'appointment' => [
                    'source_action' => 'profile',
                    'profile_id' => 123456,
                    'visit_motive_ids' => '471266',
                    'start_date' => '2021-05-21T15:10:00.000+02:00',
                ],
                'agenda_ids' => '78520',
                'second_slot' => '2021-06-21T16:30:00.000+02:00',
            ],
            'headers' => [
                'Cookie' => '_doctolib_session=test-session-id;temporary_appointment_id=foo-bar-id',
            ],
        ])->shouldBeCalledOnce()->willReturn($response->reveal());

        $client = new Client($httpClient->reveal(), $this->serializer);
        $client->setSessionId('test-session-id');

        $booking = FixtureGenerator::createBooking();
        $slot = new Slot(
            new \DateTime('2021-05-21 15:10:00', new \DateTimeZone('Europe/Paris')),
            new \DateTime('2021-05-21 15:30:00', new \DateTimeZone('Europe/Paris')),
            [
                new Step(
                    new \DateTime('2021-05-21 15:10:00', new \DateTimeZone('Europe/Paris')),
                    new \DateTime('2021-05-21 15:30:00', new \DateTimeZone('Europe/Paris')),
                    471266,
                    78520,
                ),
                new Step(
                    new \DateTime('2021-06-21 16:30:00', new \DateTimeZone('Europe/Paris')),
                    new \DateTime('2021-06-21 16:50:00', new \DateTimeZone('Europe/Paris')),
                    471266,
                    78520,
                ),
            ],
            78520
        );

        $client->createMultiStepAppointment($booking, $slot);
    }

    public function testCreateMultiStepAppointmentWithoutSteps(): void
    {
        $httpClient = $this->prophesize(HttpClientInterface::class);
        $client = new Client($httpClient->reveal(), $this->serializer);

        $booking = FixtureGenerator::createBooking();
        $slot = new Slot(
            new \DateTime('2021-05-21 15:10:00', new \DateTimeZone('Europe/Paris')),
        );

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The Slot has not Steps.');

        $client->createMultiStepAppointment($booking, $slot);
    }

    public function testCreateMultiStepAppointmentDontReturnTempCookie(): void
    {
        $response = $this->prophesize(ResponseInterface::class);
        $response->getHeaders(false)->willReturn([
            'content-type' => ['application/json'],
        ]);
        $response->toArray()->willReturn([
            'id' => '123456-azerty',
            'start_date' => '2021-05-21T15:10:00.000+02:00',
            'end_date' => '2021-05-21T15:30:00.000+02:00',
            'agenda_id' => 1,
            'visit_motive_id' => 471266,
            'redirection' => '/account/new',
            'final_step' => false,
        ]);

        $httpClient = $this->prophesize(HttpClientInterface::class);
        $httpClient->request('POST', '/appointments.json', [
            'base_uri' => 'https://www.doctolib.fr',
            'json' => [
                'appointment' => [
                    'source_action' => 'profile',
                    'profile_id' => 123456,
                    'visit_motive_ids' => '471266',
                    'start_date' => '2021-05-21T15:10:00.000+02:00',
                ],
                'agenda_ids' => '78520',
            ],
            'headers' => [
                'Cookie' => '_doctolib_session=test-session-id',
            ],
        ])->shouldBeCalledOnce()->willReturn($response->reveal());

        $client = new Client($httpClient->reveal(), $this->serializer);
        $client->setSessionId('test-session-id');

        $booking = FixtureGenerator::createBooking();
        $slot = new Slot(
            new \DateTime('2021-05-21 15:10:00', new \DateTimeZone('Europe/Paris')),
            new \DateTime('2021-05-21 15:30:00', new \DateTimeZone('Europe/Paris')),
            [
                new Step(
                    new \DateTime('2021-05-21 15:10:00', new \DateTimeZone('Europe/Paris')),
                    new \DateTime('2021-05-21 15:30:00', new \DateTimeZone('Europe/Paris')),
                    471266,
                    78520,
                ),
                new Step(
                    new \DateTime('2021-06-21 16:30:00', new \DateTimeZone('Europe/Paris')),
                    new \DateTime('2021-06-21 16:50:00', new \DateTimeZone('Europe/Paris')),
                    471266,
                    78520,
                ),
            ],
            78520
        );

        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Cookie "temporary_appointment_id" not found.');

        $client->createMultiStepAppointment($booking, $slot);
    }

    public function testConfirmAppointmentSendCorrectRequest(): void
    {
        $response = $this->prophesize(ResponseInterface::class);
        $response->getHeaders(false)->willReturn([
            'content-type' => ['application/json'],
        ]);
        $response->toArray()->willReturn([
            'id' => '123456-azerty',
            'start_date' => '2021-05-21T15:10:00.000+02:00',
            'end_date' => '2021-05-21T15:30:00.000+02:00',
            'agenda_id' => 1,
            'visit_motive_id' => 471266,
            'redirection' => '/account/new',
            'final_step' => false,
        ]);

        $httpClient = $this->prophesize(HttpClientInterface::class);
        $httpClient->request('PUT', '/appointments/123456-azerty.json', [
            'base_uri' => 'https://www.doctolib.fr',
            'json' => [
                'master_patient' => [
                    'id' => 1,
                    'first_name' => 'Julien',
                    'last_name' => 'Foobar',
                    'maiden_name' => 'Foo',
                    'email' => 'julien@test.com',
                    'phone_number' => '+33699999999',
                    'zipcode' => '75009',
                    'city' => 'Paris',
                    'address' => '58 rue Pigalle',
                    'birthdate' => '1978-08-13T00:00:00+00:00',
                    'created_at' => '2000-01-10T15:16:17+00:00',
                    'updated_at' => '2021-05-11T08:09:10+00:00',
                    'consented_at' => '2021-05-16T10:10:10+00:00',
                    'kind' => 'main',
                    'deleted_at' => null,
                ],
            ],
            'headers' => [
                'Cookie' => '_doctolib_session=test-session-id',
            ],
        ])->shouldBeCalledOnce()->willReturn($response->reveal());

        $client = new Client($httpClient->reveal(), $this->serializer);
        $client->setSessionId('test-session-id');

        $appointment = FixtureGenerator::createAppointment();
        $patient = FixtureGenerator::createPatient();

        $client->confirmAppointment($appointment, $patient);
    }

    public function testConfirmAppointmentWithoutNormalizerThrowsException(): void
    {
        $httpClient = $this->prophesize(HttpClientInterface::class);
        $serializer = $this->prophesize(SerializerInterface::class);
        $client = new Client($httpClient->reveal(), $serializer->reveal());
        $client->setSessionId('test-session-id');

        $appointment = FixtureGenerator::createAppointment();
        $patient = FixtureGenerator::createPatient();

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Serializer is not a Normalizer.');

        $client->confirmAppointment($appointment, $patient);
    }

    public function testGetUpcomingAppointments(): void
    {
        $httpClient = new MockHttpClient([
            ResponseFixtureFactory::createPatientAppointments(),
        ]);

        $client = new Client($httpClient, $this->serializer);
        $client->setSessionId('test-session-id');

        $results = $client->getUpcomingAppointments();

        $this->assertContainsOnlyInstancesOf(Appointment::class, $results);
        $this->assertCount(1, $results);
        /** @var Appointment $appointment */
        $appointment = $results[0];

        $this->assertSame('2393464-foobarfoobarfoobarfoobarfoobarfoobarfoobarfoobarfoobarfoobarfoobarfoobarfoobarfoobarfoobarfoobar=--fa9387e2592cf242c4851e3b31b7f41eb211606f', $appointment->getId());
        $this->assertSame('2021-07-10T11:40:00.000+02:00', $appointment->getStartDate()->format(\DateTimeInterface::RFC3339_EXTENDED));
        $this->assertSame('2021-07-10T12:00:00.000+02:00', $appointment->getEndDate()->format(\DateTimeInterface::RFC3339_EXTENDED));
        $this->assertSame(145530, $appointment->getAgendaId());
    }

    public function testGetAppointment(): void
    {
        $httpClient = new MockHttpClient([
            ResponseFixtureFactory::createAppointment(),
        ]);

        $client = new Client($httpClient, $this->serializer);
        $client->setSessionId('test-session-id');

        $appointment = $client->getAppointment('2393464-foobarfoobarfoobarfoobarfoobarfoobarfoobarfoobarfoobarfoobarfoobarfoobarfoobarfoobarfoobarfoobar=--fa9387e2592cf242c4851e3b31b7f41eb211606f');

        $this->assertInstanceOf(Appointment::class, $appointment);

        $this->assertSame('2393464-foobarfoobarfoobarfoobarfoobarfoobarfoobarfoobarfoobarfoobarfoobarfoobarfoobarfoobarfoobarfoobar=--fa9387e2592cf242c4851e3b31b7f41eb211606f', $appointment->getId());
        $this->assertSame('2021-07-10T11:40:00.000+02:00', $appointment->getStartDate()->format(\DateTimeInterface::RFC3339_EXTENDED));
        $this->assertSame('2021-07-10T12:00:00.000+02:00', $appointment->getEndDate()->format(\DateTimeInterface::RFC3339_EXTENDED));
        $this->assertSame(145530, $appointment->getAgendaId());
    }

    public function testDeleteAppointment(): void
    {
        $response = $this->prophesize(ResponseInterface::class);
        $response->getHeaders(false)->willReturn([
            'content-type' => ['application/json'],
        ]);
        $response->toArray()->willReturn([/* we dont care */]);

        $httpClient = $this->prophesize(HttpClientInterface::class);
        $httpClient->request('DELETE', '/account/appointments/123456-azerty.json', [
            'base_uri' => 'https://www.doctolib.fr',
            'headers' => [
                'Content-Type' => 'application/json',
                'Cookie' => '_doctolib_session=test-session-id',
            ],
        ])->shouldBeCalledOnce()->willReturn($response->reveal());

        $client = new Client($httpClient->reveal(), $this->serializer);
        $client->setSessionId('test-session-id');

        $appointment = FixtureGenerator::createAppointment();

        $client->deleteAppointment($appointment);
    }
}
