<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Sortie;
use App\Entity\Lieu;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Button;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
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

            //utiliser le datetime pour avoir le temps en minute
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
                'input'=> 'datetime',
                'input_format'=>'Y-m-d H:i:s'
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
        'choice_label' => 'nom',
                'placeholder' => 'choisir un lieu'

    ])
            // pour que les boutons soient de type submit
            ->add('Enregistrer', SubmitType::class)
            ->add('Publier', SubmitType::class)
            ->add('Annuler', ButtonType::class)
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
