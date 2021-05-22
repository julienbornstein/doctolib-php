<?php

declare(strict_types=1);

namespace Doctolib\Test;

use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Contracts\HttpClient\ResponseInterface;

class ResponseFixtureFactory
{
    private static function createMockJsonResponse(string $body): MockResponse
    {
        return new MockResponse($body, [
            'response_headers' => [
                'content-type' => ['application/json; charset=utf-8'],
            ],
        ]);
    }

    public static function createMasterPatient(): ResponseInterface
    {
        $json = <<<'JSON'
{
  "id": 123456,
  "first_name": "Julien",
  "last_name": "Foobar",
  "maiden_name": "Foobar",
  "email": "julien@foo.com",
  "phone_number": "+33699999999",
  "zipcode": "75009",
  "city": "Paris",
  "address": "18 rue Pigalle",
  "gender": false,
  "birthdate": "1978-08-13",
  "deleted_at": null,
  "created_at": "2016-06-03T11:14:19.299+02:00",
  "updated_at": "2021-05-12T14:51:01.359+02:00",
  "insurance_sector": null,
  "consented_at": "2021-05-12T14:51:01.350+02:00",
  "city_of_birth_id": null,
  "country_of_birth_id": null,
  "place_of_birth_unknown": null,
  "kind": "main"
}
JSON;

        return self::createMockJsonResponse($json);
    }

    public static function createSearchProfiles(): ResponseInterface
    {
        $json = <<<'JSON'
{
   "data":{
      "speciality":{
         "id":4,
         "name":"Ophtalmologue",
         "slug":"ophtalmologue",
         "search_results_priority":false,
         "telehealth_core":false,
         "vaccination":false,
         "covid_vaccination_hcp_speciality":false
      },
      "doctors":[
         {
            "id":1406598,
            "is_directory":false,
            "address":"47 Rue des Mathurins",
            "city":"Paris",
            "zipcode":"75008",
            "link":"/centre-de-sante/paris/centre-acces-vision",
            "cloudinary_public_id":"coyfqqthltw7g9pthuft",
            "profile_id":97958,
            "exact_match":true,
            "priority_speciality":false,
            "first_name":null,
            "last_name":"Centres Accès Vision",
            "name_with_title":"Centres Accès Vision",
            "speciality":null,
            "organization_status":"Centre de santé",
            "top_specialities":[
               "2 ophtalmologues"
            ],
            "position":{
               "lat":48.8732993,
               "lng":2.32298519999995
            },
            "place_id":"practice-115431",
            "telehealth":false
         },
         {
            "id":1473925,
            "is_directory":false,
            "address":"90 Rue Saint-Lazare",
            "city":"Paris",
            "zipcode":"75009",
            "link":"/ophtalmologue/paris/john-seed",
            "cloudinary_public_id":"wgpxcgahto4uosccx6xu",
            "profile_id":58877,
            "exact_match":null,
            "priority_speciality":false,
            "first_name":"John",
            "last_name":"SEED",
            "name_with_title":"Dr John SEED",
            "speciality":"Ophtalmologue",
            "organization_status":null,
            "position":{
               "lat":48.8759179,
               "lng":2.32835920000002
            },
            "place_id":null,
            "telehealth":false
         },
         {
            "id":1015059,
            "is_directory":false,
            "address":"90 Rue Saint-Lazare",
            "city":"Paris",
            "zipcode":"75009",
            "link":"/ophtalmologue/paris/lea-acasa",
            "cloudinary_public_id":"fa6by5jacyuspztkmanr",
            "profile_id":116434,
            "exact_match":null,
            "priority_speciality":false,
            "first_name":"LEA",
            "last_name":"ACASA",
            "name_with_title":"Dr Lea ACASA",
            "speciality":"Ophtalmologue",
            "organization_status":null,
            "position":{
               "lat":48.8759465,
               "lng":2.32829670000001
            },
            "place_id":null,
            "telehealth":false
         },
         {
            "id":1129717,
            "is_directory":false,
            "address":"11 Boulevard de la Madeleine",
            "city":"Paris",
            "zipcode":"75001",
            "link":"/cabinet-medical/paris/point-vision-madeleine-paris",
            "cloudinary_public_id":"c1zf1xyjokcpahsny3ha",
            "profile_id":72886,
            "exact_match":null,
            "priority_speciality":false,
            "first_name":null,
            "last_name":"Point Vision Paris Madeleine",
            "name_with_title":"Point Vision Paris Madeleine",
            "speciality":null,
            "organization_status":"Cabinet médical",
            "position":{
               "lat":48.8694029,
               "lng":2.32627550000007
            },
            "place_id":null,
            "telehealth":false
         },
         {
            "id":1392173,
            "is_directory":false,
            "address":"59 Boulevard Malesherbes",
            "city":"Paris",
            "zipcode":"75008",
            "link":"/ophtalmologue/paris/marie-narbo",
            "cloudinary_public_id":"zj3wwumxrtsxki4wojee",
            "profile_id":3247,
            "exact_match":null,
            "priority_speciality":false,
            "first_name":"Marie",
            "last_name":"NARBO",
            "name_with_title":"Dr Marie NARBO",
            "speciality":"Ophtalmologue",
            "organization_status":null,
            "position":{
               "lat":48.8761941,
               "lng":2.31777039999997
            },
            "place_id":null,
            "telehealth":false
         },
         {
            "id":1303728,
            "is_directory":false,
            "address":"4 Rue de Penthièvre",
            "city":"Paris",
            "zipcode":"75008",
            "link":"/ophtalmologue/paris/yassi-boneval",
            "cloudinary_public_id":"rdmlvwxe2pbb5lspc53w",
            "profile_id":17093,
            "exact_match":null,
            "priority_speciality":false,
            "first_name":"Yassi",
            "last_name":"Boneval",
            "name_with_title":"Dr Yassi Boneval",
            "speciality":"Ophtalmologue",
            "organization_status":null,
            "position":{
               "lat":48.8734852,
               "lng":2.31764329999999
            },
            "place_id":null,
            "telehealth":false
         },
         {
            "id":1440980,
            "is_directory":false,
            "address":"4 Rue de Penthièvre",
            "city":"Paris",
            "zipcode":"75008",
            "link":"/ophtalmologue/paris/pierre-soula",
            "cloudinary_public_id":"uwb4ncmingqtixdh8der",
            "profile_id":142987,
            "exact_match":null,
            "priority_speciality":false,
            "first_name":"PIERRE",
            "last_name":"SOULA",
            "name_with_title":"Dr Pierre SOULA",
            "speciality":"Ophtalmologue",
            "organization_status":null,
            "position":{
               "lat":48.8734852,
               "lng":2.31764329999999
            },
            "place_id":null,
            "telehealth":true
         },
         {
            "id":1450091,
            "is_directory":false,
            "address":"31 Rue de Caumartin",
            "city":"Paris",
            "zipcode":"75009",
            "link":"/centre-medical-et-dentaire/paris/centre-medical-et-dentaire-opera",
            "cloudinary_public_id":"qiusrypdpuh8rghic7yf",
            "profile_id":56698,
            "exact_match":null,
            "priority_speciality":false,
            "first_name":null,
            "last_name":"Centre Médical et Dentaire Opéra  ",
            "name_with_title":"Centre Médical et Dentaire Opéra",
            "speciality":null,
            "organization_status":"Centre médical et dentaire",
            "top_specialities":[
               "1 ophtalmologue"
            ],
            "position":{
               "lat":48.8719955,
               "lng":2.32813490000001
            },
            "place_id":null,
            "telehealth":true
         },
         {
            "id":835667,
            "is_directory":false,
            "address":"33 Rue de la Chaussée d'Antin",
            "city":"Paris",
            "zipcode":"75009",
            "link":"/centre-de-sante/paris/dentylis-centre-dentaire-et-ophtalmologie-chaussee-d-antin",
            "cloudinary_public_id":"yldvomboftwejlx9n2fl",
            "profile_id":265763,
            "exact_match":null,
            "priority_speciality":false,
            "first_name":null,
            "last_name":"Dentylis - Centre Dentaire et Ophtalmologie Chaussée d'Antin",
            "name_with_title":"Dentylis - Centre Dentaire et Ophtalmologie Chaussée d'Antin",
            "speciality":null,
            "organization_status":"Centre de santé",
            "top_specialities":[
               "1 ophtalmologue"
            ],
            "position":{
               "lat":48.8745561,
               "lng":2.3325198
            },
            "place_id":null,
            "telehealth":false
         },
         {
            "id":1454653,
            "is_directory":false,
            "address":"25 Rue La Boétie",
            "city":"Paris",
            "zipcode":"75008",
            "link":"/ophtalmologue/paris/jean-cocci-paris",
            "cloudinary_public_id":"fpmpvl1otrjxwklofz52",
            "profile_id":57312,
            "exact_match":null,
            "priority_speciality":false,
            "first_name":"Jean",
            "last_name":"COCCI",
            "name_with_title":"Dr Jean COCCI",
            "speciality":"Ophtalmologue",
            "organization_status":null,
            "position":{
               "lat":48.8737525,
               "lng":2.31608440000002
            },
            "place_id":null,
            "telehealth":false
         }
      ],
      "directory_doctors":[

      ],
      "search_filters_context":[
         {
            "label":"Disponibilités",
            "param_name":"availabilities",
            "items":[
               {
                  "name":"Aujourd'hui",
                  "id":1
               },
               {
                  "name":"Dans les trois prochains jours",
                  "id":3
               }
            ],
            "value":null
         },
         {
            "label":"Honoraires",
            "param_name":"regulation_sector",
            "items":[
               {
                  "name":"Sans dépassements d'honoraires",
                  "id":"without_extra"
               },
               {
                  "name":"Dépassements d'honoraires modérés",
                  "id":"with_extra"
               }
            ],
            "value":null
         },
         {
            "label":"Motif de consultation",
            "param_name":"ref_visit_motive_id",
            "items":[
               {
                  "name":"Première consultation d'ophtalmologie",
                  "id":268
               },
               {
                  "name":"Consultation d'ophtalmologie",
                  "id":716
               },
               {
                  "name":"Urgence",
                  "id":166
               },
               {
                  "name":"Bilan de la vue",
                  "id":271
               }
            ],
            "value":null
         },
         {
            "label":"Langues parlées",
            "param_name":"language",
            "items":[
               {
                  "name":"Allemand",
                  "id":5
               },
               {
                  "name":"Anglais",
                  "id":2
               },
               {
                  "name":"Arabe",
                  "id":9
               },
               {
                  "name":"Espagnol",
                  "id":3
               },
               {
                  "name":"Italien",
                  "id":4
               },
               {
                  "name":"Langue des signes",
                  "id":74
               },
               {
                  "name":"Polonais",
                  "id":15
               },
               {
                  "name":"Portugais",
                  "id":6
               },
               {
                  "name":"Roumain",
                  "id":14
               },
               {
                  "name":"Russe",
                  "id":16
               },
               {
                  "name":"Turc",
                  "id":29
               }
            ],
            "value":null
         }
      ],
      "place":{
         "id":566509,
         "name":"Boulevard Haussmann",
         "slug":"paris-boulevard-haussmann-9ccb02fd-270c-41a7-84f2-426ec71d305f",
         "place_id":"Eig3NTAxMSBCb3VsZXZhcmQgSGF1c3NtYW5uLCBQYXJpcywgRnJhbmNlIi4qLAoUChIJeY1zJctv5kcRmQRo7bqo_9wSFAoSCQ-34gYfbuZHEWCUjGjDggsE",
         "position":{
            "lat":48.87397,
            "lng":2.32312
         }
      },
      "telehealth_new_patient":false,
      "directory_title":"D'autres ophtalmologues consultent autour de vous",
      "doctor_title":"Trouvez autour de vous un ophtalmologue (ou un professionnel pratiquant des actes de ophtalmologie) proposant la prise de rendez-vous en ligne",
      "secondary_doctor_title":"D'autres ophtalmologues (ou professionnels pratiquant des actes de ophtalmologie) proposent la prise de rendez-vous en ligne dans les environs de Boulevard Haussmann",
      "prior_nearby_location_title":"D'autres ophtalmologues proposent la prise de rendez-vous en ligne dans les environs de Boulevard Haussmann",
      "non_prior_at_location_title":"D'autres professionnels pratiquant des actes de ophtalmologie proposent la prise de rendez-vous en ligne autour de vous",
      "non_prior_nearby_location_title":"D'autres professionnels pratiquant des actes de ophtalmologie proposent la prise de rendez-vous en ligne dans les environs de Boulevard Haussmann",
      "has_more":true,
      "search_scope":"speciality",
      "is_hub":false,
      "total_search_results":999
   }
}
JSON;

        return self::createMockJsonResponse($json);
    }

    public static function createAutocomplete(): ResponseInterface
    {
        $json = <<<'JSON'
{
  "profiles": [
    {
      "city": "Paris",
      "owner_type": "Organization",
      "value": 121632,
      "name": "Dentylis - Centre Dentaire Lafayette Poissonnière",
      "name_with_title": "Dentylis - Centre Dentaire Lafayette Poissonnière",
      "main_name": "Dentylis - Centre Dentaire Lafayette Poissonnière ",
      "cloudinary_public_id": "y3lby6o3zcxby63xvvux",
      "kind": "Centre dentaire",
      "link": "/centre-dentaire/paris/centre-dentaire-litz-lafayette-dentylis"
    },
    {
      "city": "Juvisy-sur-Orge",
      "owner_type": "Organization",
      "value": 238898,
      "name": "DentalNext - Centre dentaire de Juvisy",
      "name_with_title": "DentalNext - Centre dentaire de Juvisy",
      "main_name": "DentalNext - Centre dentaire de Juvisy",
      "cloudinary_public_id": "b6rhss1nwghf5jn8bfo5",
      "kind": "Centre dentaire",
      "link": "/centre-dentaire/juvisy-sur-orge/dentalnext-centre-dentaire-de-juvisy"
    },
    {
      "city": "Sèvres",
      "owner_type": "Organization",
      "value": 162623,
      "name": "Centre dentaire Dentimad - Sèvres",
      "name_with_title": "Centre dentaire Dentimad - Sèvres",
      "main_name": "Centre dentaire Dentimad - Sèvres",
      "cloudinary_public_id": "onnsrcqmezwaxh8uzr0b",
      "kind": "Centre dentaire",
      "link": "/centre-dentaire/sevres/centre-dentaire-dentimad-sevres"
    },
    {
      "city": "Paris",
      "owner_type": "Organization",
      "value": 78880,
      "name": "Centre dentaire Pereire Batignolles - Dentelia",
      "name_with_title": "Centre dentaire Pereire Batignolles - Dentelia",
      "main_name": "Centre dentaire Pereire Batignolles - Dentelia",
      "cloudinary_public_id": "uezmho12segidyt0bgfn",
      "kind": "Centre dentaire",
      "link": "/centre-dentaire/paris/centre-dentaire-pereire-batignolles-dentelia"
    },
    {
      "city": "Montpellier",
      "owner_type": "Organization",
      "value": 101517,
      "name": "Centre dentaire Dentifree - Montpellier",
      "name_with_title": "Centre dentaire Dentifree - Montpellier",
      "main_name": "Centre dentaire Dentifree - Montpellier",
      "cloudinary_public_id": "mvisfu9claqop46nkyur",
      "kind": "Centre dentaire",
      "link": "/centre-dentaire/montpellier/dentifree-montpellier"
    },
    {
      "city": "Bussy-Saint-Georges",
      "owner_type": "Organization",
      "value": 228575,
      "name": "Centre dentaire - Bussy-Saint-Georges - Dentalign",
      "name_with_title": "Centre dentaire - Bussy-Saint-Georges - Dentalign",
      "main_name": "Centre dentaire - Bussy-Saint-Georges - Dentalign",
      "cloudinary_public_id": "acpxe7om8flctbmrmkhn",
      "kind": "Centre dentaire",
      "link": "/centre-dentaire/bussy-saint-georges/centre-dentaire-bussy-saint-georges-dentalign"
    },
    {
      "city": "Asnières-sur-Seine",
      "owner_type": "Organization",
      "value": 58442,
      "name": "Centre dentaire et médical Dental Santé Asnières",
      "name_with_title": "Centre dentaire et médical Dental Santé Asnières",
      "main_name": "Centre dentaire et médical Dental Santé Asnières",
      "cloudinary_public_id": "lsmgpyjl7klwmusedhjl",
      "kind": "Centre médical et dentaire",
      "link": "/centre-medical-et-dentaire/asnieres-sur-seine/dental-sante-asnieres-champigny-et-ivry"
    },
    {
      "city": "Chartres",
      "owner_type": "Organization",
      "value": 134400,
      "name": "Centre dentaire Chartres - Dentego",
      "name_with_title": "Centre dentaire Chartres - Dentego",
      "main_name": "Centre dentaire Chartres - Dentego ",
      "cloudinary_public_id": "m4uoj46731sywwzrl0jj",
      "kind": "Centre dentaire",
      "link": "/centre-dentaire/chartres/centre-dentaire-chartres-dentego"
    },
    {
      "city": "Lambersart",
      "owner_type": "Organization",
      "value": 133217,
      "name": "Centre dentaire Dentifree - Lille",
      "name_with_title": "Centre dentaire Dentifree - Lille",
      "main_name": "Centre dentaire Dentifree - Lille ",
      "cloudinary_public_id": "xg1lpqtkvfjmtyrkuhfq",
      "kind": "Centre dentaire",
      "link": "/centre-dentaire/lambersart/dentifree-lille"
    },
    {
      "city": "Melun",
      "owner_type": "Organization",
      "value": 261591,
      "name": "Centre Dentaire Dentexelans - Melun",
      "name_with_title": "Centre Dentaire Dentexelans - Melun",
      "main_name": "Centre Dentaire Dentexelans - Melun",
      "cloudinary_public_id": "xpcv7xsssvnokmh1xpki",
      "kind": "Centre dentaire",
      "link": "/centre-dentaire/melun/centre-dentaire-dentexelans-melun"
    },
    {
      "city": "Reims",
      "owner_type": "Organization",
      "value": 199686,
      "name": "Centre dentaire Reims - Dentego",
      "name_with_title": "Centre dentaire Reims - Dentego",
      "main_name": "Centre dentaire Reims - Dentego",
      "cloudinary_public_id": "dfpibxdhcrjhqqyidr95",
      "kind": "Centre dentaire",
      "link": "/centre-dentaire/reims/centre-dentaire-reims-dentego"
    },
    {
      "city": "Beauvais",
      "owner_type": "Organization",
      "value": 153133,
      "name": "Centre dentaire et ophtalmologique - Dentexelans Beauvais",
      "name_with_title": "Centre dentaire et ophtalmologique - Dentexelans Beauvais",
      "main_name": "Centre dentaire et ophtalmologique - Dentexelans Beauvais",
      "cloudinary_public_id": "upwerdqafylifuszfsxg",
      "kind": "Cabinet médical et dentaire",
      "link": "/cabinet-medical-et-dentaire/beauvais/dentexelans-le-carrousel-beauvais"
    },
    {
      "city": "Évry",
      "owner_type": "Organization",
      "value": 38077,
      "name": "Centre Dentaire Dentinov - Evry",
      "name_with_title": "Centre Dentaire Dentinov - Evry",
      "main_name": " Centre Dentaire Dentinov - Evry",
      "cloudinary_public_id": "bnevsjqehd4zchwt1lhu",
      "kind": "Centre dentaire",
      "link": "/centre-dentaire/evry/centre-dentaire-blaise-pascal"
    },
    {
      "city": "Arceau ",
      "owner_type": "Account",
      "value": 221741,
      "name": "Mme Aurélie Dentz-Albandea",
      "name_with_title": "Mme Aurélie Dentz-Albandea",
      "main_name": "Dentz-Albandea",
      "cloudinary_public_id": "vhuz4juhmpfjvunxrrur",
      "kind": "Sage-femme",
      "link": "/sage-femme/arceau/aurelie-dentz-albandea"
    },
    {
      "city": "Chambly",
      "owner_type": "Organization",
      "value": 7303,
      "name": "Dentiste implantologue parodontologue - docteurs Boukobza et Tibi",
      "name_with_title": "Dentiste implantologue parodontologue - docteurs Boukobza et Tibi",
      "main_name": "Dentiste implantologue parodontologue - docteurs Boukobza et Tibi",
      "cloudinary_public_id": "default_organization_avatar",
      "kind": "Cabinet dentaire",
      "link": "/cabinet-dentaire/chambly/cabinet-des-docteurs-boukobza-serge-et-tibi-samantha"
    },
    {
      "city": "Pommiers",
      "owner_type": "Organization",
      "value": 228587,
      "name": "Dentilis - Pommiers",
      "name_with_title": "Dentilis - Pommiers",
      "main_name": "Dentilis - Pommiers",
      "cloudinary_public_id": "g8lppghzaszmrctqmenn",
      "kind": "Cabinet dentaire",
      "link": "/cabinet-dentaire/pommiers/dentilis"
    },
    {
      "city": "Bordeaux",
      "owner_type": "Organization",
      "value": 53686,
      "name": "Centres dentaires de la CPAM de Bordeaux",
      "name_with_title": "Centres dentaires de la CPAM de Bordeaux",
      "main_name": "Centres dentaires de la CPAM de Bordeaux",
      "cloudinary_public_id": "agvguqcpmopcvoldzvrz",
      "kind": "Centre dentaire",
      "link": "/centre-dentaire/bordeaux/centres-dentaires-de-la-cpam-de-bordeaux"
    },
    {
      "city": "Paris",
      "owner_type": "Organization",
      "value": 37659,
      "name": "Cabinet d'Implantologie et d'esthétique dentaires Carré Bavoux",
      "name_with_title": "Cabinet d'Implantologie et d'esthétique dentaires Carré Bavoux",
      "main_name": "Cabinet d'Implantologie et d'esthétique dentaires Carré Bavoux",
      "cloudinary_public_id": "bpuuoinylyhzhggolxyx",
      "kind": "Cabinet dentaire",
      "link": "/cabinet-dentaire/paris/cabinet-d-implantologie-et-d-esthetique-dentaires-des-docteurs-carre-et-bavoux"
    },
    {
      "city": "Gennevilliers",
      "owner_type": "Organization",
      "value": 45358,
      "name": "Centre médico-dentaire de France - Centre  médico-dentaire Gennevilliers",
      "name_with_title": "Centre médico-dentaire de France - Centre  médico-dentaire Gennevilliers",
      "main_name": "Centre médico-dentaire de France - Centre  médico-dentaire Gennevilliers",
      "cloudinary_public_id": "tfv2bm5dkiuesejkqzug",
      "kind": "Centre dentaire",
      "link": "/centre-dentaire/gennevilliers/centre-dentaire-val-de-france-gennevilliers"
    },
    {
      "city": "Saint-Maur-des-Fossés",
      "owner_type": "Organization",
      "value": 30032,
      "name": "Centre dentaire Saint-Maur Créteil",
      "name_with_title": "Centre dentaire Saint-Maur Créteil",
      "main_name": "Centre dentaire Saint-Maur Créteil ",
      "cloudinary_public_id": "a3prupenbzk8byiiijau",
      "kind": "Cabinet dentaire",
      "link": "/cabinet-dentaire/saint-maur-des-fosses/centre-dentaire-pont-de-creteil"
    },
    {
      "city": "Viry-Châtillon",
      "owner_type": "Organization",
      "value": 90142,
      "name": "Centre dentaire de Viry-Châtillon",
      "name_with_title": "Centre dentaire de Viry-Châtillon",
      "main_name": "Centre dentaire de Viry-Châtillon",
      "cloudinary_public_id": "wdjesazuucuna6reqzub",
      "kind": "Cabinet dentaire",
      "link": "/cabinet-dentaire/viry-chatillon/centre-dentaire-de-viry-chatillon"
    },
    {
      "city": "Montpellier",
      "owner_type": "Organization",
      "value": 75697,
      "name": "Centre dentaire de Tournezy",
      "name_with_title": "Centre dentaire de Tournezy",
      "main_name": "Centre dentaire de Tournezy",
      "cloudinary_public_id": "ntlfvxjfe9swfhl0c6sa",
      "kind": "Centre dentaire",
      "link": "/centre-dentaire/montpellier/centre-dentaire-de-tournezy"
    },
    {
      "city": "Champforgeuil",
      "owner_type": "Organization",
      "value": 273418,
      "name": "Centre dentaire du Chalonnais",
      "name_with_title": "Centre dentaire du Chalonnais",
      "main_name": "Centre dentaire du Chalonnais ",
      "cloudinary_public_id": "default_organization_avatar",
      "kind": "Centre dentaire",
      "link": "/centre-dentaire/champforgeuil/centre-dentaire-du-chalonnais"
    },
    {
      "city": "Paris",
      "owner_type": "Organization",
      "value": 157760,
      "name": "Centre dentaire du château",
      "name_with_title": "Centre dentaire du château",
      "main_name": "Centre dentaire du château",
      "cloudinary_public_id": "nvxv3cbkmy6ctz5qhciw",
      "kind": "Centre dentaire",
      "link": "/centre-dentaire/paris/centre-dentaire-du-chateau-34"
    },
    {
      "city": "Cormeilles-en-Parisis",
      "owner_type": "Organization",
      "value": 115065,
      "name": "Centre dentaire Ortodontix - Cormeilles en Parisis",
      "name_with_title": "Centre dentaire Ortodontix - Cormeilles en Parisis",
      "main_name": "Centre dentaire Ortodontix - Cormeilles en Parisis",
      "cloudinary_public_id": "btd83kvpepnzt2asefns",
      "kind": "Centre dentaire",
      "link": "/centre-dentaire/cormeilles-en-parisis/centre-dentaire-ortodontix-cormeilles-en-parisis"
    },
    {
      "city": "Lyon",
      "owner_type": "Organization",
      "value": 18489,
      "name": "Centre dentaire Labelia",
      "name_with_title": "Centre dentaire Labelia",
      "main_name": "Centre dentaire Labelia",
      "cloudinary_public_id": "mv8os1rj8slptbnsmfbk",
      "kind": "Cabinet dentaire",
      "link": "/cabinet-dentaire/lyon/centre-dentaire-labelia"
    },
    {
      "city": "Montmorency",
      "owner_type": "Organization",
      "value": 254493,
      "name": "Centre dentaire Montmorency",
      "name_with_title": "Centre dentaire Montmorency",
      "main_name": "Centre dentaire Montmorency",
      "cloudinary_public_id": "ilcbkh4pmwlo1wmrfmiy",
      "kind": "Centre dentaire",
      "link": "/centre-dentaire/montmorency/centre-dentaire-montmorency"
    },
    {
      "city": "Poissy",
      "owner_type": "Organization",
      "value": 117854,
      "name": "Centre Dentaire Poissy",
      "name_with_title": "Centre Dentaire Poissy",
      "main_name": "Centre Dentaire Poissy",
      "cloudinary_public_id": "bms0ns5p0eh4lvfqgyej",
      "kind": "Centre dentaire",
      "link": "/centre-dentaire/poissy/centre-dentaire-poissy"
    },
    {
      "city": "Courbevoie",
      "owner_type": "Organization",
      "value": 62922,
      "name": "Centre dentaire de Courbevoie",
      "name_with_title": "Centre dentaire de Courbevoie",
      "main_name": "Centre dentaire de Courbevoie",
      "cloudinary_public_id": "yeprozontyjds3c0rsv1",
      "kind": "Centre médical et dentaire",
      "link": "/centre-medical-et-dentaire/courbevoie/centre-dentaire-courbevoie"
    }
  ],
  "specialities": [
    {
      "value": 1,
      "slug": "dentiste",
      "name": "Chirurgien-dentiste"
    },
    {
      "value": 3368,
      "slug": "alignement-dentaire-invisible",
      "name": "Alignement dentaire invisible"
    }
  ],
  "organization_statuses": [
    {
      "value": 15,
      "slug": "centre-dentaire",
      "name": "Centre dentaire"
    },
    {
      "value": 2,
      "slug": "cabinet-dentaire",
      "name": "Cabinet dentaire"
    },
    {
      "value": 7,
      "slug": "centre-medical-et-dentaire",
      "name": "Centre médical et dentaire"
    },
    {
      "value": 16,
      "slug": "cabinet-medical-et-dentaire",
      "name": "Cabinet médical et dentaire"
    }
  ]
}
JSON;

        return self::createMockJsonResponse($json);
    }

    public static function createBooking(): ResponseInterface
    {
        $json = <<<'JSON'
{
  "data": {
    "profile": {
      "id": 90648,
      "name_with_title_and_determiner": "le Dr Anne Ruch",
      "name_with_title": "Dr Anne MARTIN",
      "speciality": {
        "id": 1,
        "name": "Chirurgien-dentiste",
        "created_at": "2013-10-17T13:48:20.309+02:00",
        "updated_at": "2021-05-18T10:34:42.911+02:00",
        "position": 1,
        "title_allowed": true,
        "alternate_name": "Chirurgie dentaire",
        "short_name": null,
        "name_en": "Dentist",
        "alternate_name_en": null,
        "allow_multiple_booking": false,
        "deleted_at": null,
        "short_name_en": null,
        "ref_motive_search_enabled": true,
        "labels": {
          "plural": "Chirurgiens-dentistes",
          "singular": "Chirurgien-dentiste",
          "en_singular": null,
          "singular_female": null
        },
        "seo_top": true,
        "country": "fr",
        "slug": "dentiste",
        "regulation_sectors_search_enabled": false,
        "kind": "medical",
        "self_onboarding": false,
        "searchable_by": "mapping",
        "salesforce_id": "Chirurgien-dentiste",
        "hidden": false,
        "practitioner_identity_verification_required": true,
        "prospect_name": "Chirurgien-dentiste",
        "salesforce_slug": "CHIRURGIEN_DENTISTE_FR",
        "data_sub_group": "dentists",
        "pro_sante_connect_eligibility": true,
        "instant_messaging_searchability": true,
        "recall_friendly": false,
        "covid_vaccination_eligible": false,
        "medical_identifier_check_enabled": true,
        "availabilities_first_in_search": false
      },
      "organization": false,
      "redirect_url": "/dentiste/le-plessis-trevise",
      "language_list": "Anglais et Français"
    },
    "specialities": [
      {
        "id": 1,
        "name": "Chirurgien-dentiste",
        "kind": "medical"
      }
    ],
    "visit_motive_categories": [],
    "visit_motives": [
      {
        "id": 496053,
        "name": "Consultation dentaire",
        "visit_motive_category_id": null,
        "organization_id": 23739,
        "speciality_id": 1,
        "ref_visit_motive_id": 157,
        "position": 2,
        "telehealth": false,
        "vaccination_days_range": 0,
        "vaccination_motive": false,
        "covid_vaccination_set_appointment_organization": false,
        "first_shot_motive": false,
        "allow_new_patients": true,
        "allow_new_patients_on_insurance_sector": null,
        "configurations": null
      },
      {
        "id": 496057,
        "name": "Blanchiment des dents",
        "visit_motive_category_id": null,
        "organization_id": 23739,
        "speciality_id": 1,
        "ref_visit_motive_id": 161,
        "position": 6,
        "telehealth": false,
        "vaccination_days_range": 0,
        "vaccination_motive": false,
        "covid_vaccination_set_appointment_organization": false,
        "first_shot_motive": false,
        "allow_new_patients": true,
        "allow_new_patients_on_insurance_sector": null,
        "configurations": null
      },
      {
        "id": 496487,
        "name": "Consultation d'esthétique dentaire",
        "visit_motive_category_id": null,
        "organization_id": 23739,
        "speciality_id": 1,
        "ref_visit_motive_id": 2961,
        "position": 4,
        "telehealth": false,
        "vaccination_days_range": 0,
        "vaccination_motive": false,
        "covid_vaccination_set_appointment_organization": false,
        "first_shot_motive": false,
        "allow_new_patients": true,
        "allow_new_patients_on_insurance_sector": null,
        "configurations": null
      },
      {
        "id": 1622403,
        "name": "Première consultation dentaire",
        "visit_motive_category_id": null,
        "organization_id": 87291,
        "speciality_id": 1,
        "ref_visit_motive_id": 475,
        "position": 2,
        "telehealth": false,
        "vaccination_days_range": 0,
        "vaccination_motive": false,
        "covid_vaccination_set_appointment_organization": false,
        "first_shot_motive": false,
        "allow_new_patients": true,
        "allow_new_patients_on_insurance_sector": null,
        "configurations": null
      },
      {
        "id": 1622410,
        "name": "Contrôle annuel et/ou détartrage",
        "visit_motive_category_id": null,
        "organization_id": 87291,
        "speciality_id": 1,
        "ref_visit_motive_id": 2964,
        "position": 4,
        "telehealth": false,
        "vaccination_days_range": 0,
        "vaccination_motive": false,
        "covid_vaccination_set_appointment_organization": false,
        "first_shot_motive": false,
        "allow_new_patients": true,
        "allow_new_patients_on_insurance_sector": null,
        "configurations": null
      },
      {
        "id": 1622414,
        "name": "Consultation dentaire",
        "visit_motive_category_id": null,
        "organization_id": 87291,
        "speciality_id": 1,
        "ref_visit_motive_id": 157,
        "position": 1,
        "telehealth": false,
        "vaccination_days_range": 0,
        "vaccination_motive": false,
        "covid_vaccination_set_appointment_organization": false,
        "first_shot_motive": false,
        "allow_new_patients": true,
        "allow_new_patients_on_insurance_sector": null,
        "configurations": null
      },
      {
        "id": 1622416,
        "name": "Consultation d'implantologie",
        "visit_motive_category_id": null,
        "organization_id": 87291,
        "speciality_id": 1,
        "ref_visit_motive_id": 1346,
        "position": 3,
        "telehealth": false,
        "vaccination_days_range": 0,
        "vaccination_motive": false,
        "covid_vaccination_set_appointment_organization": false,
        "first_shot_motive": false,
        "allow_new_patients": true,
        "allow_new_patients_on_insurance_sector": null,
        "configurations": null
      }
    ],
    "agendas": [
      {
        "id": 449621,
        "booking_disabled": false,
        "booking_temporary_disabled": false,
        "landline_number": "01 40 70 95 64",
        "anonymous": false,
        "organization_id": 23739,
        "visit_motive_ids_by_practice_id": {
          "30366": [
            496053,
            496487,
            496057
          ]
        },
        "visit_motive_ids": [
          496053,
          496487,
          496057
        ],
        "visit_motive_ids_only_for_doctors": null,
        "practice_id": 30366,
        "speciality_id": 1,
        "practitioner_id": 778865,
        "insurance_sector_enabled": false,
        "equipment_agendas_required": false
      },
      {
        "id": 46640,
        "booking_disabled": true,
        "booking_temporary_disabled": false,
        "landline_number": "01 85 64 44 55",
        "anonymous": false,
        "organization_id": 15468,
        "visit_motive_ids_by_practice_id": {},
        "visit_motive_ids": [],
        "visit_motive_ids_only_for_doctors": null,
        "practice_id": 25386,
        "speciality_id": 1,
        "practitioner_id": 778865,
        "insurance_sector_enabled": false,
        "equipment_agendas_required": false
      },
      {
        "id": 270800,
        "booking_disabled": false,
        "booking_temporary_disabled": false,
        "landline_number": "01 45 76 36 77",
        "anonymous": false,
        "organization_id": 87291,
        "visit_motive_ids_by_practice_id": {
          "107232": [
            1622414,
            1622403,
            1622416,
            1622410
          ]
        },
        "visit_motive_ids": [
          1622414,
          1622403,
          1622416,
          1622410
        ],
        "visit_motive_ids_only_for_doctors": null,
        "practice_id": 107232,
        "speciality_id": 1,
        "practitioner_id": 778865,
        "insurance_sector_enabled": false,
        "equipment_agendas_required": false
      }
    ],
    "places": [
      {
        "id": "practice-107232",
        "address": "17 Avenue Ardouin",
        "zipcode": "94420",
        "city": "Le Plessis-Trévise",
        "floor": 1,
        "latitude": 48.8087895,
        "longitude": 2.57434560000002,
        "elevator": false,
        "handicap": false,
        "formal_name": "Cabinet dentaire des docteurs Swinburne et Ruch ",
        "landline_number": "01 45 76 36 77",
        "reception_info": null,
        "full_address": "17 Avenue Ardouin, 94420 Le Plessis-Trévise",
        "opening_hours": [
          {
            "day": 1,
            "ranges": [
              [
                "09:00",
                "19:00"
              ]
            ],
            "enabled": true
          },
          {
            "day": 2,
            "ranges": [
              [
                "09:00",
                "19:00"
              ]
            ],
            "enabled": true
          },
          {
            "day": 3,
            "ranges": [
              [
                "09:00",
                "20:00"
              ]
            ],
            "enabled": false
          },
          {
            "day": 4,
            "ranges": [
              [
                "09:00",
                "19:00"
              ]
            ],
            "enabled": true
          },
          {
            "day": 5,
            "ranges": [
              [
                "09:00",
                "19:00"
              ]
            ],
            "enabled": true
          },
          {
            "day": 6,
            "ranges": [
              [
                "09:00",
                "12:30"
              ]
            ],
            "enabled": false
          },
          {
            "day": 0,
            "ranges": [
              [
                "09:00",
                "13:00"
              ]
            ],
            "enabled": false
          }
        ],
        "name": "Cabinet dentaire des docteurs Swinburne et Ruch ",
        "practice_ids": [
          107232
        ],
        "is_aphp": false,
        "aphp_url": "http://www.aphp.fr/contenu/combien-ca-coute",
        "payment_means": "Chèques, espèces et cartes bancaires",
        "regulation_sector": "Conventionné",
        "insurance_card": true
      },
      {
        "id": "practice-30366",
        "address": "8 Boulevard de la Madeleine",
        "zipcode": "75009",
        "city": "Paris",
        "floor": 0,
        "latitude": 48.8700525,
        "longitude": 2.3268962,
        "elevator": true,
        "handicap": true,
        "formal_name": "The Smile Clinic ",
        "landline_number": "01 40 70 95 64",
        "reception_info": null,
        "full_address": "8 Boulevard de la Madeleine, 75009 Paris",
        "opening_hours": [
          {
            "day": 1,
            "ranges": [
              [
                "09:00",
                "19:30"
              ]
            ],
            "enabled": true
          },
          {
            "day": 2,
            "ranges": [
              [
                "09:00",
                "19:30"
              ]
            ],
            "enabled": true
          },
          {
            "day": 3,
            "ranges": [
              [
                "09:00",
                "19:30"
              ]
            ],
            "enabled": true
          },
          {
            "day": 4,
            "ranges": [
              [
                "09:00",
                "19:30"
              ]
            ],
            "enabled": true
          },
          {
            "day": 5,
            "ranges": [
              [
                "09:00",
                "19:30"
              ]
            ],
            "enabled": true
          },
          {
            "day": 6,
            "ranges": [
              [
                "11:00",
                "17:30"
              ]
            ],
            "enabled": true
          },
          {
            "day": 0,
            "ranges": [
              [
                "12:00",
                "17:30"
              ]
            ],
            "enabled": false
          }
        ],
        "name": "The Smile Clinic ",
        "practice_ids": [
          30366
        ],
        "is_aphp": false,
        "aphp_url": "http://www.aphp.fr/contenu/combien-ca-coute",
        "payment_means": null,
        "regulation_sector": null,
        "insurance_card": null
      }
    ],
    "practitioners": [
      {
        "id": 778865,
        "profile_id": 90648,
        "cloudinary_public_id": "dwwb56he5aiqow0unypp",
        "name": "MARTIN",
        "name_with_title_and_determiner": "le Dr Anne Ruch",
        "name_with_title": "Dr Anne MARTIN",
        "speciality": "Chirurgien-dentiste"
      }
    ],
    "availabilities_preview_compatible": false,
    "vaccination_center": false,
    "number_future_vaccinations": 0,
    "has_new_patient_rule": true
  }
}
JSON;

        return self::createMockJsonResponse($json);
    }

    public static function createAvailabilities(): ResponseInterface
    {
        $json = <<<'JSON'
{
  "availabilities": [
    {
      "date": "2021-05-25",
      "slots": [
        "2021-05-25T16:00:00.000+02:00",
        "2021-05-25T16:10:00.000+02:00",
        "2021-05-25T16:30:00.000+02:00",
        "2021-05-25T16:40:00.000+02:00",
        "2021-05-25T16:50:00.000+02:00"
      ],
      "substitution": null
    },
    {
      "date": "2021-05-26",
      "slots": [],
      "substitution": null
    },
    {
      "date": "2021-05-27",
      "slots": [
        "2021-05-27T14:10:00.000+02:00",
        "2021-05-27T14:20:00.000+02:00",
        "2021-05-27T14:30:00.000+02:00",
        "2021-05-27T14:40:00.000+02:00",
        "2021-05-27T14:50:00.000+02:00",
        "2021-05-27T15:15:00.000+02:00",
        "2021-05-27T15:25:00.000+02:00",
        "2021-05-27T15:35:00.000+02:00",
        "2021-05-27T15:45:00.000+02:00",
        "2021-05-27T15:55:00.000+02:00",
        "2021-05-27T16:05:00.000+02:00",
        "2021-05-27T16:15:00.000+02:00",
        "2021-05-27T16:25:00.000+02:00",
        "2021-05-27T16:35:00.000+02:00",
        "2021-05-27T16:45:00.000+02:00"
      ],
      "substitution": null
    },
    {
      "date": "2021-05-28",
      "slots": [
        "2021-05-28T09:00:00.000+02:00",
        "2021-05-28T09:10:00.000+02:00",
        "2021-05-28T09:20:00.000+02:00",
        "2021-05-28T09:30:00.000+02:00",
        "2021-05-28T09:40:00.000+02:00",
        "2021-05-28T09:50:00.000+02:00",
        "2021-05-28T10:20:00.000+02:00",
        "2021-05-28T10:30:00.000+02:00",
        "2021-05-28T10:40:00.000+02:00",
        "2021-05-28T10:50:00.000+02:00",
        "2021-05-28T11:00:00.000+02:00",
        "2021-05-28T11:10:00.000+02:00",
        "2021-05-28T11:30:00.000+02:00",
        "2021-05-28T11:40:00.000+02:00",
        "2021-05-28T11:50:00.000+02:00",
        "2021-05-28T12:00:00.000+02:00",
        "2021-05-28T12:10:00.000+02:00",
        "2021-05-28T12:20:00.000+02:00",
        "2021-05-28T12:30:00.000+02:00"
      ],
      "substitution": null
    }
  ],
  "total": 39
}
JSON;

        return self::createMockJsonResponse($json);
    }

    public static function createPatientAppointments(): ResponseInterface
    {
        $json = <<<'JSON'
{
  "data": {
    "confirmed": [
      {
        "substitute_name": null,
        "substitution_wording": null,
        "created_by": 123456,
        "id": "2393464-foobarfoobarfoobarfoobarfoobarfoobarfoobarfoobarfoobarfoobarfoobarfoobarfoobarfoobarfoobarfoobar=--fa9387e2592cf242c4851e3b31b7f41eb211606f",
        "start_date": "2021-07-10T11:40:00.000+02:00",
        "end_date": "2021-07-10T12:00:00.000+02:00",
        "branding": true,
        "confirmed": true,
        "canceled": false,
        "suspended": false,
        "is_movable": true,
        "cancelable": true,
        "too_late_to_cancel": false,
        "phone_number": null,
        "source": "patient",
        "show_patient": false,
        "past": false,
        "patient_can_share_documents": true,
        "no_show": false,
        "agenda_id": 145530,
        "profile": {
          "link": "/dermatologue/paris/pierre-paul",
          "cloudinary_public_id": "l64lx6opdhvsdz1yw0xa",
          "id": 49135,
          "city": "Paris",
          "name_with_title": "Dr Pierre Paul",
          "physician_identifier": null,
          "RPPS": null,
          "title": "Dr",
          "owner_type": "Account",
          "bio": "Nihil est enim virtute amabilius, nihil quod magis adliciat ad diligendum, quippe cum propter virtutem et probitatem etiam eos, quos numquam vidimus, quodam modo diligamus. Quis est qui C. Fabrici, M'. Curi non cum caritate aliqua benevola memoriam usurpet, quos numquam viderit? quis autem est, qui Tarquinium Superbum, qui Sp. Cassium, Sp. Maelium non oderit? Cum duobus ducibus de imperio in Italia est decertatum, Pyrrho et Hannibale; ab altero propter probitatem eius non nimis alienos animos habemus, alterum propter crudelitatem semper haec civitas oderit.",
          "searchable": true,
          "trashed": false,
          "speciality": "Dermatologue et vénérologue",
          "speciality_id": 6,
          "medical": true,
          "organization": false,
          "speciality_allow_multiple_booking": true,
          "allow_online_booking": true,
          "display_payment_means": true,
          "payment_means": {
            "cash": "1",
            "check": "0",
            "credit_card": "1"
          },
          "insurance_card": true,
          "regulation_sector": "Conventionné secteur 2"
        },
        "documents": [],
        "practice": {
          "id": 56330,
          "address": "14 Rue de Châteaudun",
          "zipcode": "75009",
          "city": "Paris",
          "floor": 1,
          "latitude": 48.8761614,
          "longitude": 2.3398171,
          "elevator": true,
          "handicap": false,
          "formal_name": "",
          "intercom": "\"Cabinet Médical\" à gauche dans le hall",
          "code1": "A12345",
          "code2": "",
          "note": "Au-dessus de la boulangerie.",
          "reception_info": null,
          "full_address": "12 Rue de Châteaudun, 75009 Paris",
          "opening_hours": [
            {
              "day": 1,
              "ranges": [
                [
                  "09:00",
                  "12:00"
                ]
              ],
              "enabled": false
            },
            {
              "day": 2,
              "ranges": [
                [
                  "09:00",
                  "13:00"
                ]
              ],
              "enabled": false
            },
            {
              "day": 3,
              "ranges": [
                [
                  "14:30",
                  "18:30"
                ]
              ],
              "enabled": false
            },
            {
              "day": 4,
              "ranges": [
                [
                  "09:00",
                  "12:30"
                ],
                [
                  "14:00",
                  "18:30"
                ]
              ],
              "enabled": false
            },
            {
              "day": 5,
              "ranges": [
                [
                  "14:00",
                  "18:30"
                ]
              ],
              "enabled": false
            },
            {
              "day": 6,
              "ranges": [
                [
                  "09:00",
                  "13:00"
                ]
              ],
              "enabled": false
            },
            {
              "day": 0,
              "ranges": [
                [
                  "09:00",
                  "13:00"
                ]
              ],
              "enabled": false
            }
          ]
        },
        "appointment_rules": [],
        "country": "fr",
        "patient": {
          "id": "2415131-Bf78c19hdAY7AFQw--b99426595fab5c871e57139c400662a8",
          "first_name": "Julien",
          "last_name": "Foobar",
          "master_patient_id": 123456,
          "child": false
        },
        "document_count": null
      }
    ],
    "done": [
      {
        "substitute_name": null,
        "substitution_wording": null,
        "created_by": 123456,
        "id": "239364-foobarfoobarfoobarfoobarfoobarfoobarfoobarfoobarfoobarfoobarfoobarfoobarfoobarfoobarfoobarfoobar=--fa9387e2592cf242c4851e3b31b7f41eb211606f",
        "start_date": "2021-04-17T12:20:00.000+02:00",
        "end_date": "2021-04-17T12:30:00.000+02:00",
        "branding": true,
        "confirmed": false,
        "canceled": false,
        "suspended": false,
        "is_movable": false,
        "cancelable": false,
        "uncancelable_reason": "too_close_from_start_date",
        "too_late_to_cancel": true,
        "phone_number": null,
        "source": "patient",
        "show_patient": false,
        "past": true,
        "patient_can_share_documents": false,
        "no_show": false,
        "agenda_id": 454973,
        "profile": {
          "link": "/dermatologue/paris/pierre-paul",
          "cloudinary_public_id": "l64lx6opdhvsdz1yw0xa",
          "id": 49135,
          "city": "Paris",
          "name_with_title": "Dr Pierre Paul",
          "physician_identifier": null,
          "RPPS": null,
          "title": "Dr",
          "owner_type": "Account",
          "bio": "Nihil est enim virtute amabilius, nihil quod magis adliciat ad diligendum, quippe cum propter virtutem et probitatem etiam eos, quos numquam vidimus, quodam modo diligamus. Quis est qui C. Fabrici, M'. Curi non cum caritate aliqua benevola memoriam usurpet, quos numquam viderit? quis autem est, qui Tarquinium Superbum, qui Sp. Cassium, Sp. Maelium non oderit? Cum duobus ducibus de imperio in Italia est decertatum, Pyrrho et Hannibale; ab altero propter probitatem eius non nimis alienos animos habemus, alterum propter crudelitatem semper haec civitas oderit.",
          "searchable": true,
          "trashed": false,
          "speciality": "Dermatologue et vénérologue",
          "speciality_id": 6,
          "medical": true,
          "organization": false,
          "speciality_allow_multiple_booking": true,
          "allow_online_booking": true,
          "display_payment_means": true,
          "payment_means": {
            "cash": "1",
            "check": "0",
            "credit_card": "1"
          },
          "insurance_card": true,
          "regulation_sector": "Conventionné secteur 2"
        },
        "documents": [],
        "practice": {
          "id": 56330,
          "address": "14 Rue de Châteaudun",
          "zipcode": "75009",
          "city": "Paris",
          "floor": 1,
          "latitude": 48.8761614,
          "longitude": 2.3398171,
          "elevator": true,
          "handicap": false,
          "formal_name": "",
          "intercom": "\"Cabinet Médical\" à gauche dans le hall",
          "code1": "A12345",
          "code2": "",
          "note": "Au-dessus de la boulangerie.",
          "reception_info": null,
          "full_address": "12 Rue de Châteaudun, 75009 Paris",
          "opening_hours": [
            {
              "day": 1,
              "ranges": [
                [
                  "09:00",
                  "12:00"
                ]
              ],
              "enabled": false
            },
            {
              "day": 2,
              "ranges": [
                [
                  "09:00",
                  "13:00"
                ]
              ],
              "enabled": false
            },
            {
              "day": 3,
              "ranges": [
                [
                  "14:30",
                  "18:30"
                ]
              ],
              "enabled": false
            },
            {
              "day": 4,
              "ranges": [
                [
                  "09:00",
                  "12:30"
                ],
                [
                  "14:00",
                  "18:30"
                ]
              ],
              "enabled": false
            },
            {
              "day": 5,
              "ranges": [
                [
                  "14:00",
                  "18:30"
                ]
              ],
              "enabled": false
            },
            {
              "day": 6,
              "ranges": [
                [
                  "09:00",
                  "13:00"
                ]
              ],
              "enabled": false
            },
            {
              "day": 0,
              "ranges": [
                [
                  "09:00",
                  "13:00"
                ]
              ],
              "enabled": false
            }
          ]
        },
        "country": "fr",
        "document_count": null,
        "patient": {
          "id": "2415131-Bf78c19hdAY7AFQw--b99426595fab5c871e57139c400662a8",
          "first_name": "Julien",
          "last_name": "Foobar",
          "master_patient_id": 123456,
          "child": false
        }
      },
      {
        "substitute_name": null,
        "substitution_wording": null,
        "created_by": 123456,
        "id": "139364-foobarfoobarfoobarfoobarfoobarfoobarfoobarfoobarfoobarfoobarfoobarfoobarfoobarfoobarfoobarfoobar=--fa9387e2592cf242c4851e3b31b7f41eb211606f",
        "start_date": "2021-02-15T15:40:00.000+02:00",
        "end_date": "2021-02-15T16:00:00.000+02:00",
        "branding": true,
        "confirmed": false,
        "canceled": false,
        "suspended": false,
        "is_movable": false,
        "cancelable": false,
        "uncancelable_reason": "too_close_from_start_date",
        "too_late_to_cancel": true,
        "phone_number": null,
        "source": "doctor",
        "show_patient": false,
        "past": true,
        "patient_can_share_documents": true,
        "no_show": false,
        "agenda_id": 145530,
        "profile": {
          "link": "/dermatologue/paris/pierre-paul",
          "cloudinary_public_id": "l64lx6opdhvsdz1yw0xa",
          "id": 49135,
          "city": "Paris",
          "name_with_title": "Dr Pierre Paul",
          "physician_identifier": null,
          "RPPS": null,
          "title": "Dr",
          "owner_type": "Account",
          "bio": "Nihil est enim virtute amabilius, nihil quod magis adliciat ad diligendum, quippe cum propter virtutem et probitatem etiam eos, quos numquam vidimus, quodam modo diligamus. Quis est qui C. Fabrici, M'. Curi non cum caritate aliqua benevola memoriam usurpet, quos numquam viderit? quis autem est, qui Tarquinium Superbum, qui Sp. Cassium, Sp. Maelium non oderit? Cum duobus ducibus de imperio in Italia est decertatum, Pyrrho et Hannibale; ab altero propter probitatem eius non nimis alienos animos habemus, alterum propter crudelitatem semper haec civitas oderit.",
          "searchable": true,
          "trashed": false,
          "speciality": "Dermatologue et vénérologue",
          "speciality_id": 6,
          "medical": true,
          "organization": false,
          "speciality_allow_multiple_booking": true,
          "allow_online_booking": true,
          "display_payment_means": true,
          "payment_means": {
            "cash": "1",
            "check": "0",
            "credit_card": "1"
          },
          "insurance_card": true,
          "regulation_sector": "Conventionné secteur 2"
        },
        "documents": [],
        "practice": {
          "id": 56330,
          "address": "14 Rue de Châteaudun",
          "zipcode": "75009",
          "city": "Paris",
          "floor": 1,
          "latitude": 48.8761614,
          "longitude": 2.3398171,
          "elevator": true,
          "handicap": false,
          "formal_name": "",
          "intercom": "\"Cabinet Médical\" à gauche dans le hall",
          "code1": "A12345",
          "code2": "",
          "note": "Au-dessus de la boulangerie.",
          "reception_info": null,
          "full_address": "12 Rue de Châteaudun, 75009 Paris",
          "opening_hours": [
            {
              "day": 1,
              "ranges": [
                [
                  "09:00",
                  "12:00"
                ]
              ],
              "enabled": false
            },
            {
              "day": 2,
              "ranges": [
                [
                  "09:00",
                  "13:00"
                ]
              ],
              "enabled": false
            },
            {
              "day": 3,
              "ranges": [
                [
                  "14:30",
                  "18:30"
                ]
              ],
              "enabled": false
            },
            {
              "day": 4,
              "ranges": [
                [
                  "09:00",
                  "12:30"
                ],
                [
                  "14:00",
                  "18:30"
                ]
              ],
              "enabled": false
            },
            {
              "day": 5,
              "ranges": [
                [
                  "14:00",
                  "18:30"
                ]
              ],
              "enabled": false
            },
            {
              "day": 6,
              "ranges": [
                [
                  "09:00",
                  "13:00"
                ]
              ],
              "enabled": false
            },
            {
              "day": 0,
              "ranges": [
                [
                  "09:00",
                  "13:00"
                ]
              ],
              "enabled": false
            }
          ]
        },
        "country": "fr",
        "document_count": null,
        "patient": {
          "id": "2415131-Bf78c19hdAY7AFQw--b99426595fab5c871e57139c400662a8",
          "first_name": "Julien",
          "last_name": "Foobar",
          "master_patient_id": 123456,
          "child": false
        }
      }
    ]
  }
}
JSON;

        return self::createMockJsonResponse($json);
    }

    public static function createAppointment(): ResponseInterface
    {
        $json = <<<'JSON'
{
        "substitute_name": null,
        "substitution_wording": null,
        "created_by": 123456,
        "id": "2393464-foobarfoobarfoobarfoobarfoobarfoobarfoobarfoobarfoobarfoobarfoobarfoobarfoobarfoobarfoobarfoobar=--fa9387e2592cf242c4851e3b31b7f41eb211606f",
        "start_date": "2021-07-10T11:40:00.000+02:00",
        "end_date": "2021-07-10T12:00:00.000+02:00",
        "branding": true,
        "confirmed": true,
        "canceled": false,
        "suspended": false,
        "is_movable": true,
        "cancelable": true,
        "too_late_to_cancel": false,
        "phone_number": null,
        "source": "patient",
        "show_patient": false,
        "past": false,
        "patient_can_share_documents": true,
        "no_show": false,
        "agenda_id": 145530,
        "profile": {
          "link": "/dermatologue/paris/pierre-paul",
          "cloudinary_public_id": "l64lx6opdhvsdz1yw0xa",
          "id": 49135,
          "city": "Paris",
          "name_with_title": "Dr Pierre Paul",
          "physician_identifier": null,
          "RPPS": null,
          "title": "Dr",
          "owner_type": "Account",
          "bio": "Nihil est enim virtute amabilius, nihil quod magis adliciat ad diligendum, quippe cum propter virtutem et probitatem etiam eos, quos numquam vidimus, quodam modo diligamus. Quis est qui C. Fabrici, M'. Curi non cum caritate aliqua benevola memoriam usurpet, quos numquam viderit? quis autem est, qui Tarquinium Superbum, qui Sp. Cassium, Sp. Maelium non oderit? Cum duobus ducibus de imperio in Italia est decertatum, Pyrrho et Hannibale; ab altero propter probitatem eius non nimis alienos animos habemus, alterum propter crudelitatem semper haec civitas oderit.",
          "searchable": true,
          "trashed": false,
          "speciality": "Dermatologue et vénérologue",
          "speciality_id": 6,
          "medical": true,
          "organization": false,
          "speciality_allow_multiple_booking": true,
          "allow_online_booking": true,
          "display_payment_means": true,
          "payment_means": {
            "cash": "1",
            "check": "0",
            "credit_card": "1"
          },
          "insurance_card": true,
          "regulation_sector": "Conventionné secteur 2"
        },
        "documents": [],
        "practice": {
          "id": 56330,
          "address": "14 Rue de Châteaudun",
          "zipcode": "75009",
          "city": "Paris",
          "floor": 1,
          "latitude": 48.8761614,
          "longitude": 2.3398171,
          "elevator": true,
          "handicap": false,
          "formal_name": "",
          "intercom": "\"Cabinet Médical\" à gauche dans le hall",
          "code1": "A12345",
          "code2": "",
          "note": "Au-dessus de la boulangerie.",
          "reception_info": null,
          "full_address": "12 Rue de Châteaudun, 75009 Paris",
          "opening_hours": [
            {
              "day": 1,
              "ranges": [
                [
                  "09:00",
                  "12:00"
                ]
              ],
              "enabled": false
            },
            {
              "day": 2,
              "ranges": [
                [
                  "09:00",
                  "13:00"
                ]
              ],
              "enabled": false
            },
            {
              "day": 3,
              "ranges": [
                [
                  "14:30",
                  "18:30"
                ]
              ],
              "enabled": false
            },
            {
              "day": 4,
              "ranges": [
                [
                  "09:00",
                  "12:30"
                ],
                [
                  "14:00",
                  "18:30"
                ]
              ],
              "enabled": false
            },
            {
              "day": 5,
              "ranges": [
                [
                  "14:00",
                  "18:30"
                ]
              ],
              "enabled": false
            },
            {
              "day": 6,
              "ranges": [
                [
                  "09:00",
                  "13:00"
                ]
              ],
              "enabled": false
            },
            {
              "day": 0,
              "ranges": [
                [
                  "09:00",
                  "13:00"
                ]
              ],
              "enabled": false
            }
          ]
        },
        "appointment_rules": [],
        "country": "fr",
        "patient": {
          "id": "2415131-Bf78c19hdAY7AFQw--b99426595fab5c871e57139c400662a8",
          "first_name": "Julien",
          "last_name": "Foobar",
          "master_patient_id": 123456,
          "child": false
        },
        "document_count": null
      }
JSON;

        return self::createMockJsonResponse($json);
    }
}
