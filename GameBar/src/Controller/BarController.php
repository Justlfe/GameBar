<?php
/**
 * Created by PhpStorm.
 * User: Etudiant
 * Date: 29/04/2019
 * Time: 16:27
 */

namespace App\Controller;


use App\Entity\Bar;
use App\Entity\Event;
use App\Entity\Membre;
use App\Form\BarFormType;
use App\Form\EventFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BarController extends AbstractController
{
    use HelperTrait;

    /**
     * @Route("/formulairebar", name="default_formulairebar")
     */
    public function addBar(Request $request)
    {
        // Création d'un nouveau Bar
        $bar = new Bar();

        # Récupération d'un Gérant (Membre avec role gérant)

        $membre = $this->getDoctrine()
            ->getRepository(Membre::class)
            ->find(23);

        # Affecter un gérant au bar
        $bar->setGerant($membre);

        $bar->setLat(48.8031);
        $bar->setLng(2.1334100000000262);

        #Création d'un Formulaire "BAR"
        $form = $this->createForm(BarFormType::class, $bar);

        # Traitement des données POST
        $form->handleRequest($request);

        #Vérification de la soumission du formulaire
        if ($form->isSubmitted() && $form->isValid()) {


            # 1. Génération du Slug
            $bar->setSlug($this->slugify($bar->getNom()));

            # 2. Traitement de l'upload de l'image
            /** @var UploadedFile $file */
            $file = $bar->getImage();
            $fileName = $bar->getSlug() . '-img.' . $file->guessExtension();

            // Move the file to the directory where brochures are stored
            try {
                $file->move(
                    $this->getParameter('images_directory'),
                    $fileName
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }

            # Mise à jour de l'image
            $bar->setImage($fileName);

            # 2. Traitement de l'upload du kbis
            /** @var UploadedFile $kbis */
            $kbis = $bar->getKbis();
            $kbisName = $bar->getSlug() . '-kbis.' . $kbis->guessExtension();

            // Move the file to the directory where brochures are stored
            try {
                $kbis->move(
                    $this->getParameter('kbis_directory'),
                    $kbisName
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }

            # Mise à jour de l'image
            $bar->setKbis($kbisName);

            # Sauvegarde en BDD
            $em = $this->getDoctrine()->getManager();
            $em->persist($bar);
            $em->flush();

            //Notification
            $this->addFlash('notice',
                'Votre demande à bien été enregistrée !');


            $barId = $this->getDoctrine()
                ->getRepository(Bar::class)
                ->findOneBy(array(), array('id' => 'DESC'))
                ->getId();

            return $this->redirectToRoute("membre_connexion");
        }

        #Affichage du Formulaire dans la vue
        return $this->render("default/formulairebar.html.twig", [
            'form' => $form->createView()
        ]);


    }

    /**
     * @Route("/bars/{id}/delete", name="delete_bar")
     */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();

        $barToDelete = $em->getRepository(Bar::class)->find($id);

        if (!$barToDelete) {

            $delete = "failure";

            return $this->redirectToRoute("default_bar", [
                'delete' => $delete
            ]);
        }

        $nameBarDeleted = $barToDelete->getNom();

        $em->remove($barToDelete);
        $em->flush();

        $delete = 'success';

        return $this->redirectToRoute("default_bar", [
            'delete' => $delete,
            'nameBarDeleted' => $nameBarDeleted
        ]);
    }


    /*
     * @Route("/horaire-bar", name="default_horaire")
     */
    public function horaire(Request $request)
    {
       /* //Récupération via $_SESSION de l'id du bar
        $barId = 6;

        // on récupère le bar dans la DB
        $bar = $this->getDoctrine()
            ->getRepository(Bar::class)
            ->findOneBy(['id' => $barId]);

        // SI LE BAR N'EXISTE PAS
        if (!isset($bar)) {

            $info = 'vous devez être connecté en tant que gérant d\'un bar pour accéder à cette option';

            //Redirection
            return $this->redirectToRoute('index', [
                'info' => $info
            ]);
        }
        // SI LE BAR EXISTE

        // LE BAR POSSEDE-T-IL DEJA UN EVENT HORAIRE OU FAUT-IL EN CREE UN NOUVEAU ?

        $eventsDuBar = $bar->getEvents();

        foreach ($eventsDuBar as $event) {

            // on verifie si un event du bar est déjà un horaire
            $isHoraire = $event->getIsHoraires();

            if ($isHoraire == 1) {

                // si le bar a déjà un horaire de fermeture, on UPDATE L'HORAIRE

                // ATTENTION PEUT-ETRE BESOIN ICI D'UNE FONCTION UPDATE
                // --------> dans le doute je renvoie un erreur pour l'instant et met le reste en commentaire

                $info = 'un horaire a déjà été créé pour ce bar';


                                //Création du formulaire
                                $form = $this->createForm(EventFormType::class,$event)
                                    ->handleRequest($request);

                                // Vérification de la soumission du formulaire
                                if ($form->isSubmitted() && $form->isValid()) {



                                    //Sauvegarde en BDD
                                    $em = $this->getDoctrine()->getManager();
                                    $em->persist($event);
                                    $em->flush();

                                    //notification
                                    $this->addFlash('notice',
                                        'Felicitation ! Vos horaires ont bien été mis à jour !');


                //Redirection
                return $this->redirectToRoute('index', [
                    'info' => $info
                ]);

            }
        }
        */


        // si le bar n'a pas encore d'horaire de fermeture, on CREE UN NOUVEL HORAIRE

        $eventHoraire = new Event();

        //Création du formulaire
        $form = $this->createForm(EventFormType::class, $eventHoraire)
            ->handleRequest($request);

        // Vérification de la soumission du formulaire
        if ($form->isSubmitted() && $form->isValid()) {

            /*// Ajout du titre de l'event
            $nomDuBar = $bar->getNom();
            $eventHoraire->setTitre("Horaire du bar $nomDuBar");*/

            //Booleens
            $eventHoraire->setConfirmation(0);
            $eventHoraire->setComplet(0);
            $eventHoraire->setIsHoraires(1);

            //Sauvegarde en BDD
            $em = $this->getDoctrine()->getManager();
            $em->persist($eventHoraire);
            $em->flush();

            //notification
            $info = 'Felicitation ! Vos horaires ont bien été mis à jour !';

            //Redirection
            return $this->redirectToRoute('index', [
                'info' => $info
            ]);

        }


        //Affichage du Formulaire dans la vue
        return $this->render("default/formulairehoraire.html.twig", [
            'form' => $form->createView()
        ]);


    }


}

