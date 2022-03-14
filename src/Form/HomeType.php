<?php

namespace App\Form;

use App\Entity\Campus;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
                'placeholder' => 'choisir un campus'

            ])
            ->add('recherche')
            ->add('dateDebutRecherche', DateType::class, [
                'label' => 'dateDebutRecherche',
                'html5' => true,
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('dateFin', DateType::class, [
                'label' => 'dateFin',
                'html5' => true,
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('sortieOrganisees', CheckboxType::class, [

                'required' => false

            ])
            ->add('sortieInscrit',CheckboxType::class,
                [

                    'required' => false

                ])
            ->add('sortieNonInscrit',CheckboxType::class,  [

                'required' => false

            ])
            ->add('sortiePass', CheckboxType::class, [

                'required' => false

            ])
            ->add('Enregistrer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => HomeModele::class,
        ]);
    }
}
