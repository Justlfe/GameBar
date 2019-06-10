<?php


namespace App\Controller;


use App\Entity\Bar;
use App\Entity\Event;
use App\Entity\Jeu;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class DefaultController extends AbstractController
{


    public function index()
    {
        $repository = $this->getDoctrine()
            ->getRepository(Bar::class);

        $bars = $repository->findAll();

        return $this->render("default/index.html.twig", [
            'bars' => $bars
        ]);
    }

    /**
     * @Route("/commentmarche", name="default_commentmarche")
     */
    public function showCommentMarche()
    {
        $repository = $this->getDoctrine()
            ->getRepository(Bar::class);

        $bars = $repository->findAll();

        return $this->render("default/commentmarche.html.twig", [
            'bars' => $bars
        ]);
    }




    /**
     * @Route("/bars/{id}", defaults={"id"="0"}, name="default_bar")
     */

    public function showBar($id, \App\Event\Event $eventModel)
    {
        $bar = $this->getDoctrine()
            ->getRepository(Bar::class)
            ->findOneBy(['id' => $id]);

        if(!isset($bar)){

            $bars = $this->getDoctrine()
                ->getRepository(Bar::class)
                ->findAll();

            return $this->render("default/bars.html.twig", [
                'bars' => $bars
            ]);
        }

        $events = $bar->getEvents();

        $calendar = $eventModel->getJsonForCalendar($events);

        return $this->render("default/bar.html.twig", [
            'bar' => $bar,
            'calendar' => $calendar
        ]);
    }

    /**
     * @Route("/events/{id}", defaults={"id"="0"}, name="default_event")
     */
    public function showEvent($id, \App\Event\Event $eventModel)
    {
        $event = $this->getDoctrine()
            ->getRepository(Event::class)
            ->findOneBy(['id' => $id]);

        if(!isset($event)){

            $events = $this->getDoctrine()
                ->getRepository(Event::class)
                ->findAll();

            $calendar = $eventModel->getJsonForCalendar($events);

            return $this->render("default/events.html.twig", [
                'events' => $events,
                'calendar' => $calendar
            ]);
        }

        return $this->render("default/event.html.twig", [
            'event' => $event
        ]);
    }

    /**
     * @Route("/jeux/{id}", defaults={"id"="0"}, name="default_jeu")
     */
        public function showJeu($id)
    {
        $jeu = $this->getDoctrine()
            ->getRepository(Jeu::class)
            ->findOneBy(['id' => $id]);

        if(!isset($jeu)){

            $jeux = $this->getDoctrine()
                ->getRepository(Jeu::class)
                ->findAll();

            return $this->render("default/jeux.html.twig", [
                'jeux' => $jeux
            ]);
        }

        return $this->render("default/jeu.html.twig", [
            'jeu' => $jeu
        ]);
    }

    /**
     * @Route("mapbar", name="mapbar")
     */
    public function mapbar()
    {
        return $this->render("default/mapbar.html.twig");
    }

}