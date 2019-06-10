<?php
/**
 * Created by PhpStorm.
 * User: Etudiant
 * Date: 29/04/2019
 * Time: 11:42
 */

namespace App\Form;

use App\Entity\Membre;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MembreFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {


        $builder
            // PSEUDO
            ->add('pseudo', TextType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'placeholder' => "Pseudo"
                ]
            ])
            // EMAIL
            ->add('email', EmailType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'placeholder' => "Email"
                ]
            ])
            /*          // MOT DE PASSE
                      ->add('password', PasswordType::class, [
                          'required' => true,
                          'label'  => 'Mot de Passe'
                      ])*/

            ->add('Password', RepeatedType::class, array(
                'type' => PasswordType::class,
                'required' => true,
                'first_options' => array(
                    'label' => false,
                    'attr' => array('placeholder' => 'Mot de Passe')
                ),
                'second_options' => array(
                    'label' => false,
                    'attr' => array('placeholder' => 'Confirmer Mot de Passe')
                ),

            ))
            // NOM
            ->add('nom', TextType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'placeholder' => "Nom"
                ]
            ])
            // PRENOM
            ->add('prenom', TextType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'placeholder' => "Prénom"
                ]
            ])
            // CODE POSTAL
            ->add('code_postal', IntegerType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'placeholder' => "Code Postal"
                ]
            ])
            // DATE DE NAISSANCE
            ->add('date_naissance', BirthdayType::class, [
                'required' => true,
                'label' => "Date de Naissance",
                'attr' => [
                    'placeholder' => "Date de Naissance"
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => "Je m'inscris !"
            ]);
    }


}