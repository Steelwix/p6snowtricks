<?php

namespace App\Form;;

use App\Entity\TrickGroup;
use App\Entity\Video;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\FileType;

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

            ->add('description', TextType::class, [
                'label' => 'Contenu',
                'attr' => [
                    'placeholder' => '',
                    'class' => 'form-control'
                ]
            ])

            ->add('trickGroup', EntityType::class, [
                'class' => TrickGroup::class,
                'choice_label' => 'trick_group_name',
                'multiple' => false,
                'expanded' => false
            ])
            ->add(
                'illustration',
                FileType::class,
                [
                    'label' => 'Image d\'illustration',
                    'multiple' => false,
                    'mapped' => false,
                    'required' => false
                ]
            )
            ->add(
                'media',
                FileType::class,
                [
                    'label' => '',
                    'multiple' => true,
                    'mapped' => false,
                    'required' => false
                ]
            )
            ->add(
                'url',
                TextType::class,
                [
                    'label' => 'url',
                    'mapped' => false,
                    'required' => false
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
