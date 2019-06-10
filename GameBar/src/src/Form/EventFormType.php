<?php
/**
 * Created by PhpStorm.
 * User: Etudiant
 * Date: 29/04/2019
 * Time: 15:58
 */

namespace App\Form;


use App\Entity\Bar;
use App\Entity\Jeu;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;

class EventFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            // JEUX CHOIX
            ->add('jeu', EntityType::class, [
                'class' => Jeu::class,
                'choice_label' => 'nom',
                'label' => false
            ])
            // BAR CHOIX
            ->add('bar', EntityType::class, [
                'class' => Bar::class,
                'choice_label' => 'nom',
                'label' => false
            ])
            // JOUEURS MIN
            ->add('joueurs_min', IntegerType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'placeholder' => "Nombre de Joueur Minimal"
                ]
            ])
            // JOUEURS MAX
            ->add('joueurs_max', IntegerType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'placeholder' => "Nombre de Joueur Maximal"
                ]
            ])



            // DEBUT
            ->add('heure_debut', DateTimeType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => "Heure de début"
                ]

            ])
            // FIN
            ->add('heure_fin', DateTimeType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => "Heure de fin"
                ]
            ])
            // AUTRES INFOS
            ->add('autre_infos', TextareaType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'placeholder' => "Informations complémentaires"
                ]
            ])
        // SUBMIT
        ->
        add('submit', SubmitType::class, [
            'label' => "Créer l'event"
        ]);
    }


}