<?php

namespace App\Form;

use App\Entity\Campus;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HomeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('Campus', EntityType::class, [
                // looks for choices from this entity
                'class' => Campus::class,
                // uses the User.username property as the visible option string
                'choice_label' => 'nom',
                'placeholder' => 'choisir un campus',
                'required' => false

            ])
            ->add('recherche', TextType::class, [
                'label' => 'Le nom de la sortie contient :',
                'required'=>false
            ])
            ->add('dateDebutRecherche', DateType::class, [
                'label' => 'Entre',
                'html5' => true,
                'widget' => 'single_text',
                'required' => false,
                'empty_data' => ''
            ])
            ->add('dateFin', DateType::class, [
                'label' => 'Et',
                'html5' => true,
                'widget' => 'single_text',
                'required' => false,
                'empty_data' => ''
            ])
            ->add('sortieOrganisees', CheckboxType::class, [

                'required' => false,
                'label' => 'Sorties dont je suis l\'organisateur/trice',

            ])
            ->add('sortieInscrit',CheckboxType::class,
                [

                    'required' => false,
                    'label' => 'Sorties auquelles je suis inscrit/e',

                ])
            ->add('sortieNonInscrit',CheckboxType::class,  [

                'required' => false,
                'label' => 'Sorties auxquelles je ne suis pas inscrit/e',

            ])
            ->add('sortiePass', CheckboxType::class, [

                'required' => false,
                'label' => 'Sorties passées',

            ])
            ->add('Rechercher', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => HomeModele::class,
        ]);
    }
}
