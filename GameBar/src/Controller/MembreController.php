<?php
/**
 * Created by PhpStorm.
 * User: Etudiant
 * Date: 29/04/2019
 * Time: 15:25
 */

namespace App\Controller;


use App\Entity\Membre;
use App\Form\ConnexionFormType;
use App\Form\MembreFormType;
use App\Form\MembreGerantFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class MembreController extends AbstractController
{

    /**
     * @Route("/inscription", name="membre_inscription")
     */
    public function inscription(Request $request, UserPasswordEncoderInterface $encoder)
    {
        // Création de l'inscription
        $membre = new Membre();
        $membre->setRoles(['ROLE_MEMBRE']);


        //Création du formulaire inscription
        $form = $this->createForm(MembreFormType::class, $membre)
            ->handleRequest($request);


        // Vérification de la soumission du formulaire
        if ($form->isSubmitted() && $form->isValid()) {

            #Encode
            $membre->setPassword(
                $encoder->encodePassword($membre, $membre->getPassword())
            );


            //Sauvegarde en BDD
            $em = $this->getDoctrine()->getManager();
            $em->persist($membre);
            $em->flush();

            //notification
            $this->addFlash('notice',
                'Felicitation ! A vous de jouez !');

            //Redirection
            return $this->redirectToRoute('membre_connexion');

        }
        // Affichage du formulaire dans la vue
        return $this->render('membre/inscription.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/inscriptiongerant", name="gerant_inscription")
     *
     */
    public function inscriptionGerant(Request $request, UserPasswordEncoderInterface $encoder)
    {
        // Création de l'inscription
        $membre = new Membre();
        $membre->setRoles(['ROLE_GERANT']);


        //Création du formulaire inscription
        $form = $this->createForm(MembreGerantFormType::class, $membre)
            ->handleRequest($request);


        // Vérification de la soumission du formulaire
        if ($form->isSubmitted() && $form->isValid()) {

            #Encode
            $membre->setPassword(
                $encoder->encodePassword($membre, $membre->getPassword())
            );


            //Sauvegarde en BDD
            $em = $this->getDoctrine()->getManager();
            $em->persist($membre);
            $em->flush();

            //notification
            $this->addFlash('notice',
                'Felicitation ! A vous de jouez !');

            //Redirection
            return $this->redirectToRoute('default_formulairebar');

        }
        // Affichage du formulaire dans la vue
        return $this->render('membre/inscriptionGerant.html.twig', [
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/connexion", name="membre_connexion")
     */
    public function connexion(AuthenticationUtils $authenticationUtils)
    {

        # Récup du Formulaire de Connexion
        $form = $this->createForm(ConnexionFormType::class, ['pseudo' => $authenticationUtils->getLastUserName()]);

        // Vérification de la soumission du formulaire
        if ($form->isSubmitted() && $form->isValid()) {
        # Redirection
        return $this->redirectToRoute('index.html.twig');
        }

        #Affichage du formulaire dans la vue
        return $this->render('membre/connexion.html.twig', [
            'form' => $form->createView(),
            'error' => $authenticationUtils->getLastAuthenticationError()
        ]);
    }

    /**
     * @Route("/deconnexion", name="membre_deconnexion")
     */
    public function deconnexion()
    {

    }
}