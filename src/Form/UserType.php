<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Participant;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pseudo')

            ->add('nom')

            ->add('prenom')

            ->add('telephone')

            ->add('email')

            ->add('password', RepeatedType::class, array(
                'mapped'=> false,
                'required'=>false,
                'type' => PasswordType::class,
                'first_options'  => array('label' => 'password'),
                'second_options' => array('label' => 'confirmation'),
            ))

            ->add('Campus', EntityType::class, [
                // looks for choices from this entity
                'class' => Campus::class,
                // uses the User.username property as the visible option string
                'choice_label' => 'nom',
            ])

            ->add('image', FileType::class, [
                'label'=> 'Image(jpeg)',
                'mapped'=>false,
                'required'=>false,
                'constraints' => [
                new File([
                    'maxSize' => '111111111111111111k',
                    'mimeTypes'=> [
                        'image/jpeg',
                        'image/png',

                    ],
                    'mimeTypesMessage'=> 'please upload a valid document'
                ])
                    ],
            ])
            ->add('Enregistrer', SubmitType::class)

            ->add('Annuler', SubmitType::class);
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Participant::class,
        ]);
    }
}
