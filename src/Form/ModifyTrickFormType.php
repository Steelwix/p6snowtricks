<?php

namespace App\Form;;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModifyTrickFormType extends AbstractType
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
            //->add('categorie', ChoiceType::class, [
            //'label' => 'Contenu',
            //'attr' => [
            //'placeholder' => '',
            //'class' => 'form-control'
            //]
            // ])

            ->add('slug', TextType::class, [
                'label' => 'Tag',
                'attr' => [
                    'placeholder' => '',
                    'class' => 'form-control'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}