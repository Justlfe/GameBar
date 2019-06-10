<?php
/**
 * Created by PhpStorm.
 * User: Etudiant
 * Date: 30/04/2019
 * Time: 14:30
 */

namespace App\Controller;


use App\Entity\Event;
use App\Entity\Membre;
use App\Form\EventFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class EventController extends AbstractController
{
    /**
     * @Route("/formulairevent", name="default_formulairevent")
     */
    public function event(Request $request)
    {

        //Création Event
        $event = new Event();

        //Création du formulaire inscription
        $form = $this->createForm(EventFormType::class,$event)
            ->handleRequest($request);

        // Vérification de la soumission du formulaire
        if ($form->isSubmitted() && $form->isValid()) {

            // Ajout du titre de l'event
            $nomDuJeu = $event->getJeu()->getNom();
            $event->setTitre("Partie de $nomDuJeu");

            //Booleen
            $event->setConfirmation(0);

            //Sauvegarde en BDD
            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();

            //notification
            $this->addFlash('notice',
                'Felicitation ! La partie est créée !');

            //Redirection
            return $this->redirectToRoute('default_event',[
                'id' => $event->getId()
            ]);
        }

        //Affichage du Formulaire dans la vue
        return $this->render("default/formulairevent.html.twig", [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/events/{id}/delete", name="delete_event")
     */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();

        $eventToDelete = $em->getRepository(Event::class)->find($id);

        if(!$eventToDelete){

            $delete = "failure";

            return $this->redirectToRoute("default_event", [
                'delete' => $delete
            ]);
        }

        $idEventDeleted = $eventToDelete->getId();
        $barEventDeleted = $eventToDelete->getBar()->getNom();

        $em->remove($eventToDelete);
        $em->flush();

        $delete = 'success';

        return $this->redirectToRoute("default_event", [
            'delete' => $delete,
            'idEventDeleted' => $idEventDeleted,
            'barEventDeleted' => $barEventDeleted
        ]);
    }

    /**
     * @Route("/events/{id}/addjoueur", name="addjoueur")
     */
    public function addJoueur($id, UserInterface $user)
    {
        $em = $this->getDoctrine()->getManager();

        $eventToModify = $em->getRepository(Event::class)->find($id);

        if(!$eventToModify){

            return $this->redirectToRoute("default_event");
        }

        $joueurId = $this->getUser()->getId();

        $joueur = $em->getRepository(Membre::class)->find($joueurId);

        $eventToModify->addJoueur($joueur);

        //Sauvegarde en BDD
        $em->persist($eventToModify);
        $em->flush();

        return $this->redirectToRoute("default_event", [
            'id' => $id
        ]);


    }

}