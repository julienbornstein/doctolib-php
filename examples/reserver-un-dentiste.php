<?php

declare(strict_types=1);

use Doctolib\Client;
use Doctolib\Model\Agenda;
use Doctolib\Model\Appointment;
use Doctolib\SerializerFactory;
use Doctolib\Utils\UrlUtils;
use Symfony\Component\HttpClient\NativeHttpClient;

require __DIR__.'/../vendor/autoload.php';

$httpClient = new NativeHttpClient();
$serializer = SerializerFactory::create();

$client = new Client($httpClient, $serializer);

// On recherche un "dentiste"
$searchResults = $client->search('dentiste');
$speciality = $searchResults['specialities'][0];

// la liste non exhaustive de specialité est disponible à cette addresse :
// https://www.doctolib.fr/specialities

// rechercher à Paris
// $searchResults = $client->searchDoctorsByLocation($speciality->getSlug(), 'paris');

// recherche plus précise en spécifiant les coordonnées géographiques
$profiles = $client->searchProfilesBySpecialityAndLocation(
    $speciality->getSlug(),
    'paris',
    [
        'latitude' => 48.8785328,
        'longitude' => 2.3377854,
    ]
);

// on vérifie que la recherche a retournée au moins un résultat.
if (0 === count($profiles)) {
    exit("Pas de résultat.\n");
}

// on recupère les infos Booking du 1er résultat retourné
$profile = $profiles[0];
$profileSlug = UrlUtils::getSlugFromPath($profile->getLink()); // de rien ;-)
echo sprintf("Recupération du booking de \"%s\"\n", $profile->getNameWithTitle());
$booking = $client->getBooking($profileSlug);

// Si vous conaissez le médecin, vous pouvez récuperer son booking directement
// sans faire les recherches précédentes.
// ex: https://www.doctolib.fr/dentiste/paris/arnaud-coppola-paris
// $booking = $client->getBooking('arnaud-coppola-paris');

// On récupère les agendas et les `VisitMotive` (la raison de la consultation)
$agendas = $booking->getAgendas();
$visitMotives = Agenda::getVisitMotivesForAgendas($agendas);

// on recupère les disponiblités à partir de demain en spécifiant un `VisitMotive` (au hazard pour l'exemple)
// il faut passer l'id "parent" (`refVisitMotiveId`)
$tomorrow = new DateTime('tomorrow');
$visitMotive = $visitMotives[0]; // au hazard
$availabilities = $client->getAvailabilities($agendas, $tomorrow, $visitMotive->getRefVisitMotiveId());
if (0 === count($availabilities)) {
    exit("Pas de RDV disponibles\n");
}
$firstAvailability = $availabilities[0];
$firstSlot = $firstAvailability->getSlots()[0];
echo sprintf("Prochain RDV disponible : %s\n", $firstSlot->getStartDate()->format('l jS F Y H:i'));

// on crée un RDV. Vous devez être authentifié. L'authentification n'étant pas possible
// du à la protection de Cloudflare, vous devez passer la valeur de la session au Client
// qui se trouve dans le cookie "_doctolib_session" du navigateur après authentfication.
$client->setSessionId('Change Me');

// parfois les RDV se font en plusieurs étapes, comme c'est le cas pour la vaccination COVID-19
$steps = $firstSlot->getSteps();
if (0 < count($steps)) {
    exit("Vous devez utiliser createMultiStepAppointment() pour les RDV qui comportent des steps.\n");
}
$appointment = $client->createAppointment($booking, $visitMotive, $firstSlot);

if (!$appointment instanceof Appointment) {
    exit("Echec de la prise de RDV.\n");
}

if ('/account/new' === $appointment->getRedirection()) {
    exit("Vous avez créé un RDV sans être authentifié\n");
}

// récupération du Patient authentifié.
$patient = $client->getMasterPatient();

// confirmation du RDV
$appointment = $client->confirmAppointment($appointment, $patient);

if (false === $appointment->isFinalStep()) {
    exit("La confirmation du RDV a échouée.\n");
}

echo sprintf("RDV confirmé : https://www.doctolib.fr%s\n", $appointment->getRedirection());
