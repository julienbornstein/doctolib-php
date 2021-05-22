<?php

declare(strict_types=1);

use Doctolib\Client;
use Doctolib\Exception\UnavailableSlotException;
use Doctolib\Model\Appointment;
use Doctolib\SerializerFactory;
use Doctolib\Utils\UrlUtils;
use Symfony\Component\HttpClient\NativeHttpClient;

require __DIR__.'/../vendor/autoload.php';

$httpClient = new NativeHttpClient();
$serializer = SerializerFactory::create();

$client = new Client($httpClient, $serializer);

// On recherche un "centre de vaccination" à proximité de Paris 9ème
// en filtrant par VisitMotive (raison de la consultation)
$visitMotiveIds = [
    6970, // "1re injection vaccin COVID-19 (Pfizer-BioNTech)"
    7005, // "1re injection vaccin COVID-19 (Moderna)"
];

// https://www.doctolib.fr/vaccination-covid-19/75009-paris?ref_visit_motive_ids[]=6970&ref_visit_motive_ids[]=7005

$profiles = $client->searchProfilesBySpecialityAndLocation(
    'vaccination-covid-19',
    '75009-paris',
    [
        'ref_visit_motive_ids' => $visitMotiveIds,
    ],
);

// on vérifie que la recherche a retournée au moins un résultat.
if (0 === count($profiles)) {
    exit("Pas de résultat.\n");
}

// on recupère les infos Booking du 1er résultat retourné.
// $profile = $profiles[0];
// $profileSlug = UrlUtils::getSlugFromPath($profile->getLink()); // de rien ;-)
// echo sprintf("Recupération du booking de \"%s\"\n", $profile->getNameWithTitle());
// $booking = $client->getBooking($profileSlug);

// Ou on sélectionne  son centre de vaccination, comme ici le Stade de France
$booking = $client->getBooking('centre-de-vaccination-covid-19-stade-de-france');

// On récupère les agendas
$agendas = $booking->getAgendas();

// on recupère les disponiblités à partir de maintenant en spécifiant les `VisitMotive` (parentes) qui nous interessent
$now = new DateTime('2021-05-28');
$availabilities = $client->getAvailabilities($agendas, $now, $visitMotiveIds[0]);

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
try {
    $appointment = $client->createMultiStepAppointment($booking, $firstSlot);
} catch (UnavailableSlotException $e) {
    exit("Le Slot n'est plus disponible, veuillez choisir un autre Slot.\n");
}

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
