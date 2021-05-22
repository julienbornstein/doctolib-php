# Doctolib PHP Client

[![Latest Version](https://img.shields.io/github/release/julienbornstein/doctolib-php.svg?style=flat-square)](https://github.com/julienbornstein/doctolib-php/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/julienbornstein/doctolib-php/master.svg?style=flat-square)](https://travis-ci.org/julienbornstein/doctolib-php)
[![Total Downloads](https://img.shields.io/packagist/dt/julienbornstein/doctolib-php.svg?style=flat-square)](https://packagist.org/packages/julienbornstein/doctolib-php)

**Note:** This is an UNOFFICIAL Doctolib PHP Client.

This is a PHP client for [Doctolib](https://www.doctolib.fr/). It includes the following:

* Helper methods for REST endpoints:
  * Search Profiles (Doctor) by Speciality and Location, and get Booking and Availability informations.
  * Get Patient, Profile, Appointment.
  * Create, Confirm, Delete an Appointment.
  * Authentication. *broken*
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
$doctolib = new Doctolib\Client();
$patient = $doctolib->getMasterPatient();
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
