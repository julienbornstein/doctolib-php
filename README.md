# Doctolib PHP Client

[![Latest Release](https://img.shields.io/github/release/julienbornstein/doctolib-php.svg?style=flat-square)](https://github.com/julienbornstein/doctolib-php/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![GitHub Workflow Status](https://img.shields.io/github/workflow/status/julienbornstein/doctolib-php/Continuous%20Integration?style=flat-square)](https://github.com/julienbornstein/doctolib-php/actions/workflows/continuous-integration.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/julienbornstein/doctolib-php.svg?style=flat-square)](https://packagist.org/packages/julienbornstein/doctolib-php)

**Note:** This is an UNOFFICIAL Doctolib PHP Client.

This is a PHP client for [Doctolib](https://www.doctolib.fr/). It includes the following:

* Helper methods for REST endpoints:
  * Search Profiles (Doctor) by Speciality and Location, and get Booking and Availability informations.
  * Get Patient, Profile, Appointment.
  * Create, Confirm, Delete an Appointment.
  * ~~Authentication.~~ *broken*
* PSR-4 autoloading support.

## Requirements
* PHP 7.4 or later.
* PHP [cURL extension](http://php.net/manual/en/book.curl.php) (Usually included with PHP).


## Installation

Install it using [Composer](https://getcomposer.org/):
```sh
$ composer require julienbornstein/doctolib-php
```

## Usage

```php
$doctolib = new Doctolib\Client(
    new Symfony\Component\HttpClient\HttpClient(), 
    SerializerFactory::create()
);

$searchResults = $doctolib->search('dentiste');
$speciality = $searchResults['specialities'][0];

$profiles = $doctolib->searchProfilesBySpecialityAndLocation('dentiste', '75009-paris');
$profiles = $doctolib->searchProfilesBySpecialityAndLocation('dentiste', '75009-paris', [
    'latitude' => 48.8785328,
    'longitude' => 2.3377854,
]);

$booking = $doctolib->getBooking('cabinet-dentaire-haussmann-saint-lazare');
$agendas = $booking->getAgendas();
$visitMotives = Agenda::getVisitMotivesForAgendas($agendas);

$tomorrow = new DateTime('tomorrow');
$visitMotive = $visitMotives[0];
$availabilities = $doctolib->getAvailabilities($agendas, $tomorrow, $visitMotive->getRefVisitMotiveId());

$firstAvailability = $availabilities[0];
$firstSlot = $firstAvailability->getSlots()[0];

$doctolib->setSessionId('YOUR_SESSION_ID');

$patient = $doctolib->getMasterPatient();

$appointment = $doctolib->createAppointment($booking, $visitMotive, $firstSlot);
$appointment = $doctolib->confirmAppointment($appointment, $patient);

$upcomingAppointments = $doctolib->getUpcomingAppointments();
$appointment = $doctolib->getAppointment('APPOINTMENT_ID');
$doctolib->deleteAppointment('APPOINTMENT_ID');
```

## Framework integrations

### Symfony

Add this block in your `services.yaml` file to register the `Client` as a service.

```yaml
    Doctolib\Client:
      arguments:
        $serializer: '@doctolib.serializer'

    doctolib.serializer:
      class: Symfony\Component\Serializer\SerializerInterface
      factory: ['Doctolib\SerializerFactory', 'create']
```

## Examples

You can find some examples in the [examples](examples) directory.

## Testing

```sh
$ make test
```

## Contributing

Please see [CONTRIBUTING](https://github.com/julienbornstein/doctolib-php/blob/master/CONTRIBUTING.md) for details.

## Credits

- [Julien Bornstein](https://github.com/julienbornstein)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
