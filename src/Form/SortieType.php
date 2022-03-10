<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Sortie;
use App\Entity\Lieu;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
class SortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('dateHeureDebut', DateType::class, [
                'label' => 'dateHeureDebut',
                'html5' => true,
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('dateLimiteInscription',DateType::class, [
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
            ->add('Annuler', SubmitType::class)
        ;
    }


    // ici se fait le lien avec la classe sortie
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
