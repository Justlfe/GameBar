<?php
/**
 * Created by PhpStorm.
 * User: Etudiant
 * Date: 08/05/2019
 * Time: 17:57
 */

namespace App\Controller;


use App\Entity\Contact;
use App\Form\ContactFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class ContactController extends AbstractController
{

    use HelperTrait;

    /**
     * @Route("/contact", name="default_contact")
     */
    public function jeu(Request $request)
    {
        // Création du Jeu
        $contact = new Contact();

        //Création d'une formulaire "JEU"
        $form = $this->createForm(ContactFormType::class, $contact);

        return $this->render("default/contact.html.twig", [
                'form' => $form->createView()
            ]
        );
    }


}


