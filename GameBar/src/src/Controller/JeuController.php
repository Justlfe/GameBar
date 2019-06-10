<?php
/**
 * Created by PhpStorm.
 * User: Etudiant
 * Date: 30/04/2019
 * Time: 12:15
 */

namespace App\Controller;


use App\Entity\Jeu;
use App\Form\JeuFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class JeuController extends AbstractController
{

    use HelperTrait;
    /**
     * @Route("/formulairejeu", name="default_formulairejeu")
     */
    public function jeu(Request $request)
    {
        // Création du Jeu
        $jeu = new Jeu();

        //Création d'une formulaire "JEU"
        $form = $this->createForm(JeuFormType::class, $jeu);


        # Traitement des données POST
        $form->handleRequest($request);

        #Vérification de la soumission du formulaire
        if ($form->isSubmitted() && $form->isValid()) {


            # 1. Génération du Slug
            $jeu->setSlug( $this->slugify( $jeu->getNom() ) );

            #  Traitement de l'upload de l'image
            /** @var UploadedFile $file */
            $file = $jeu->getImage();
            $fileName = $jeu->getSlug().'-img.'. $file->guessExtension();

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
            $jeu->setImage($fileName);

            # 2. Traitement de l'upload des règles
            /** @var UploadedFile $regles */
            $regles = $jeu->getRegles();
            $reglesName = $jeu->getSlug().'-regles.'. $regles->guessExtension();

            // Move the file to the directory where brochures are stored
            try {
                $regles->move(
                    $this->getParameter('regles_directory'),
                    $reglesName
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }

            # Mise à jour de l'image
            $jeu->setRegles($reglesName);

            # Sauvegarde en BDD
            $em = $this->getDoctrine()->getManager();
            $em->persist($jeu);
            $em->flush();

            //Notification
            $this->addFlash('notice',
                'Votre demande à bien été enregistrée !');


            $jeuId = $this->getDoctrine()
                ->getRepository(Jeu::class)
                ->findOneBy(array(), array('id' => 'DESC'))
                ->getId();

            return $this->redirectToRoute("default_jeu", ['id'=> $jeuId ]);
        }



        //Affichage du Formulaire dans la vue
        return $this->render("default/formulairejeu.html.twig", [
            'form' => $form->createView()
        ]);



    }

    /**
     * @Route("/jeux/{id}/delete", name="delete_jeu")
     */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();

        $jeuToDelete = $em->getRepository(Jeu::class)->find($id);

        if(!$jeuToDelete){

            $delete = "failure";

            return $this->redirectToRoute("default_jeu", [
                'delete' => $delete
            ]);
        }

        $nameJeuDeleted = $jeuToDelete->getNom();

        $em->remove($jeuToDelete);
        $em->flush();

        $delete = 'success';

        return $this->redirectToRoute("default_jeu", [
            'delete' => $delete,
            'nameJeuDeleted' => $nameJeuDeleted
        ]);
    }
}