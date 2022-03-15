<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Sortie;
use App\Entity\Lieu;

use App\Entity\Ville;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Button;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
class SortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('nom', [
                'label' => 'Nom :'
                ])

            //utiliser le datetime pour avoir le temps en minute
            ->add('dateHeureDebut', DateTimeType::class, [
                'label' => 'Date et heure du début : ',
                'html5' => true,
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('dateLimiteInscription', DateTimeType::class, [
                'label' => 'Date limite d\'inscription : ',
                'html5' => true,
                'widget' => 'single_text',
                'required' => false,
                'input' => 'datetime',
                'input_format' => 'Y-m-d H:i:s'
            ])
            ->add('nbInscriptionMax', [
                'label' => 'Nombre de places : '
            ])
            ->add('duree', [
                'label' => 'Durée : '
            ])
            ->add('infosSortie',[
                'label' => 'Description et information : '
            ])
            ->add('Campus', EntityType::class, [
                // looks for choices from this entity
                'class' => Campus::class,
                // uses the User.username property as the visible option string
                'choice_label' => 'nom',
                'placeholder' => 'choisir un campus',
                'label' => 'Campus : '
            ])


            ->add('Ville', EntityType::class, [
                // looks for choices from this entity
                'class' => Ville::class,
                "mapped" => false,
                // uses the User.username property as the visible option string
                'choice_label' => 'nom',
                'placeholder' => 'choisir une ville',
                'label' => 'Ville : '
            ])

            ->add('Lieu', EntityType::class, [
                // looks for choices from this entity
                'class' => Lieu::class,
                // uses the User.username property as the visible option string
                'choice_label' => 'nom',
                'placeholder' => 'choisir un lieu',
                'label' => 'Lieu : '
            ])

            ->add('Rue', null, ["mapped" => false])
            ->add('CodePostal', null, ["mapped" => false])
            ->add('Latitude', null, ["mapped" => false])
            ->add('Longitude', null, ["mapped" => false])
            // pour que les boutons soient de type submit
            ->add('Enregistrer', SubmitType::class)
            ->add('Publier', SubmitType::class)
            ->add('Annuler', ButtonType::class);
    }





    // ici se fait le lien avec la classe sortie
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
