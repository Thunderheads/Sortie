<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Lieu;
use App\Entity\Sortie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UpdateSortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('dateHeureDebut', DateTimeType::class, [
                'label' => 'dateHeureDebut',
                'html5' => true,
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('dateLimiteInscription',DateTimeType::class, [
                'label' => 'dateLimiteInscription ',
                'html5' => true,
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('nbInscriptionMax')
            ->add('duree')
            ->add('infosSortie')
            ->add('Campus',  EntityType::class, [
                // looks for choices from this entity
                'class' => Campus::class,
                // uses the User.username property as the visible option string
                'choice_label' => 'nom',
                'placeholder' => 'choisir un campus'

            ])
            ->add('Lieu', EntityType::class, [
                // looks for choices from this entity
                'class' => Lieu::class,
                // uses the User.username property as the visible option string
                'choice_label' => 'nom'

            ])
            // pour que les boutons soient de type submit
            ->add('Enregistrer', SubmitType::class)
            ->add('Publier', SubmitType::class)
            ->add('Supprimer', SubmitType::class)
            ->add('Annuler', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
