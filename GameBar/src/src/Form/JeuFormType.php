<?php
/**
 * Created by PhpStorm.
 * User: Etudiant
 * Date: 29/04/2019
 * Time: 13:58
 */

namespace App\Form;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class JeuFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {


        $builder

            // NOM

            ->add('nom', TextType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'placeholder' => "Nom"
                ]
            ])

            // JOUEURS MIN

            ->add('joueurs_min', IntegerType::class, [

                'required' => true,
                'label' => false,
                'attr' => [
                    'placeholder' => "Nombre minimal de joueurs"
                ]
            ])

            // JOUEURS MAX

            ->add('joueurs_max', IntegerType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'placeholder' => "Nombre maximal de joueurs"
                ]
            ])

            // DIFFICULTEY

            ->add('difficulty', TextType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'placeholder' => "Difficulté"
                ]
            ])

            // IMAGE UPLOAD
            ->add('image', FileType::class, [
                'required' => false,
                'label' => 'Image du jeu'

            ])

            // DESCRIPTION

            ->add('description', TextareaType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'placeholder' => "Description rapide du jeu"
                ]
            ])

            // TEMPS MOYEN

            ->add('temps_moyen', TextType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'placeholder' => "Temps de jeu moyen"
                ]
            ])

            // REGLE DU JEU (PDF)

            ->add('regles', FileType::class, [
                'required' => false,
                'label' => 'règles du jeu'
            ])

            // SUBMIT

            ->add('submit', SubmitType::class, [
                'label' => "Ajouter ce jeu à la liste"
            ])
        ;
    }


}