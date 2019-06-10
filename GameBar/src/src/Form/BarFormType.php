<?php
/**
 * Created by PhpStorm.
 * User: Etudiant
 * Date: 29/04/2019
 * Time: 14:20
 */

namespace App\Form;



use App\Entity\Bar;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BarFormType extends AbstractType
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

            // ADRESSE
            ->add('adresse', TextType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'placeholder' => "Adresse"
                ]
            ])

            // VILLE
            ->add('ville', TextType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'placeholder' => "Ville"
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

            // PLACE DISPONIBLE
            ->add('places_max', IntegerType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'placeholder' => "Place disponible dans bar pour les jeux"
                ]
            ])


            // AUTRES INFOS
            ->add('autres_infos', TextareaType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'placeholder' => "Informations complémentaires"
                ]
            ])

            ->add('image', FileType::class, [
                'required' => true,
                'label' => 'photo du bar'
            ])

            ->add('kbis', FileType::class, [
                'required' => true,
                'label' => 'extrait de kbis'
            ])


            // SUBMIT
            ->add('submit', SubmitType::class, [
                'label' => "Inscrire cet établissement"
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('data_class', bar::class);
    }

    public function getBlockPrefix()
    {
        return 'form';
    }


}