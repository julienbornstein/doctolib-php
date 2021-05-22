<?php

declare(strict_types=1);

namespace Doctolib\Test;

use Doctolib\Model\Agenda;
use Doctolib\Model\Appointment;
use Doctolib\Model\Booking;
use Doctolib\Model\Patient;
use Doctolib\Model\Point;
use Doctolib\Model\Profile;
use Doctolib\Model\Speciality;
use Doctolib\Model\VisitMotive;
use Symfony\Component\HttpClient\Response\MockResponse;

class FixtureGenerator
{
    public static function createMockJsonResponse(string $body = '{}'): MockResponse
    {
        return new MockResponse($body, [
            'response_headers' => [
                'content-type' => ['application/json; charset=utf-8'],
            ],
        ]);
    }

    public static function createPatient(): Patient
    {
        return new Patient(
            1,
            'Julien',
            'Foobar',
            'Foo',
            'julien@test.com',
            '+33699999999',
            '75009',
            'Paris',
            '58 rue Pigalle',
            new \DateTimeImmutable('1978-08-13 00:00:00'),
            new \DateTimeImmutable('2000-01-10 15:16:17'),
            new \DateTimeImmutable('2021-05-11 08:09:10'),
            new \DateTimeImmutable('2021-05-16 10:10:10'),
            'main',
            null,
        );
    }

    public static function createProfile(): Profile
    {
        return new Profile(
            123456,
            'Centre Médical et Dentaire Opéra',
            'Paris',
            '/centre-medical-et-dentaire/paris/centre-medical-et-dentaire-opera',
            56698,
            '33 Rue de Caumartin',
            '75009',
            'Centre Médical et Dentaire Opéra',
            new Point(48.8719955, 2.32813490000001),
            null,
            null,
        );
    }

    public static function createSpeciality(): iterable
    {
        yield new Speciality(1, 'Chirurgien dentiste', 'dentiste');

        yield new Speciality(1, 'Médecin généraliste', 'medecin-generaliste');
    }

    public static function createVisitMotive(): VisitMotive
    {
        return new VisitMotive(
            471266,
            'Nouveau patient - Consultation de médecine générale',
            22686,
            new Speciality(1, 'Médecin généraliste', 'medecin-generaliste'),
            true,
            436,
        null
        );
    }

    public static function createAgenda(): Agenda
    {
        return new Agenda(
            78520,
            [
                self::createVisitMotive(),
            ]
        );
    }

    public static function createBooking(): Booking
    {
        return new Booking(
            self::createProfile(),
            [self::createAgenda()],
        );
    }

    public static function createMultiStepBooking(): Booking
    {
        return new Booking(
            self::createProfile(),
            [self::createAgenda()],
        );
    }

    public static function createAppointment(): Appointment
    {
        return new Appointment(
            '123456-azerty',
            new \DateTime('2021-05-21 15:10:00', new \DateTimeZone('Europe/Paris')),
            new \DateTime('2021-05-21 15:10:00', new \DateTimeZone('Europe/Paris')),
            78987,
            false
        );
    }
}
