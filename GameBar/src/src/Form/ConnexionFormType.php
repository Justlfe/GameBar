<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConnexionFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       $builder

           ->add('pseudo', TextType::class, [
               'label' => false,
               'attr' => ['placeholder' => 'Pseudo']
           ])

           ->add('password', PasswordType::class, [
               'label' => false,
               'attr' => ['placeholder' => 'Mot de passe']
           ])

           ->add('submit', SubmitType::class, [
               'label' => 'Connexion'
           ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('data_class', null);
    }

    public function getBlockPrefix()
    {
        return 'app_login';
    }
}