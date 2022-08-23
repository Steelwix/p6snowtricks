<?php

namespace App\Form;;

use App\Entity\TrickGroup;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CreateTrickFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('trick_name', TextType::class, [
                'label' => 'Titre',
                'attr' => [
                    'placeholder' => '',
                    'class' => 'form-control'
                ]
            ])

            ->add('description', TextareaType::class, [
                'label' => 'Contenu',
                'attr' => [
                    'placeholder' => '',
                    'class' => 'form-control'
                ],
                'row_attr' => ['class' => 'trick-description-aera', 'rows' => "10"]
            ])

            ->add('trickGroup', EntityType::class, [
                'label' => 'Catégorie',
                'class' => TrickGroup::class,
                'choice_label' => 'trick_group_name',
                'multiple' => false,
                'expanded' => false,
                'attr' => [
                    'class' => 'form-control'
                ]

            ])
            ->add(
                'illustration',
                FileType::class,
                [
                    'label' => 'Ajouter une photo d\'illustration',
                    'multiple' => false,
                    'mapped' => false,
                    'required' => false,
                    'attr' => [
                        'class' => 'form-control'
                    ]
                ]
            )
            ->add(
                'media',
                FileType::class,
                [
                    'label' => '',
                    'multiple' => true,
                    'mapped' => false,
                    'required' => false,
                    'attr' => [
                        'class' => 'form-control'
                    ]
                ]
            )
            ->add(
                'url',
                TextType::class,
                [
                    'label' => 'Lien YouTube d\'une vidéo ',
                    'mapped' => false,
                    'required' => false,
                    'attr' => [
                        'class' => 'form-control'
                    ]
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
