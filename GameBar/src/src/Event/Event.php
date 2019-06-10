<?php
/**
 * Created by PhpStorm.
 * User: Bobby
 * Date: 07/05/2019
 * Time: 14:37
 */

namespace App\Event;


class Event
{

    public function getJsonForCalendar($events)
    {
        $arrayForJSON = [];

        /** @var \App\Entity\Event $event */
        foreach ($events as $event ) {

            $id = $event->getId();
            $titre = $event->getTitre();

            $dateDebutBeforeCut = $event->getHeureDebut()->format('Y-m-d H:i:s');
            $dateDebut1 = substr($dateDebutBeforeCut, 0, strpos($dateDebutBeforeCut, ' '));
            $dateDebut2 = substr($dateDebutBeforeCut, 11, strlen($dateDebutBeforeCut));
            $dateDebut = $dateDebut1 . 'T' . $dateDebut2;

            $dateFinBeforeCut = $event->getHeureFin()->format('Y-m-d H:i:s');
            $dateFin1 = substr($dateFinBeforeCut, 0, strpos($dateFinBeforeCut, ' '));
            $dateFin2 = substr($dateFinBeforeCut, 11, strlen($dateFinBeforeCut));
            $dateFin = $dateFin1 . 'T' . $dateFin2;

            $arrayForJSON[] = array(

                "title" => $titre,
                "start" => $dateDebut,
                "end" => $dateFin,
                "url" => "/events/$id"
            );


        }
        return json_encode($arrayForJSON);
    }
}