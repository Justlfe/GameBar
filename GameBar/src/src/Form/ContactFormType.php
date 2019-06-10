<?php
/**
 * Created by PhpStorm.
 * User: Etudiant
 * Date: 08/05/2019
 * Time: 16:59
 */

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ContactFormType extends AbstractType
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
            ->add('email', EmailType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'placeholder' => "Email"
                ]
            ])

            // DESCRIPTION

            ->add('description', TextareaType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'placeholder' => "Ecrivez nous votre message"
                ]
            ])

            ->add('submit', SubmitType::class, [
                'label' => "Envoyer le message !"
            ]);
    }
}