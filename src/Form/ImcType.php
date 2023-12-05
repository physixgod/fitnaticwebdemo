<?php

// src/Form/ImcType.php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use EWZ\Bundle\RecaptchaBundle\Form\Type\EWZRecaptchaType;

class ImcType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('sexe', ChoiceType::class, [
                 'choices' => [
                    'Male' => 'male',
                    'Female' => 'female',
                ],
            ])
            ->add('age', IntegerType::class, [
                'attr' => [
                    'placeholder' => 'Entrez votre âge',
                ],
            ])
            ->add('taille', NumberType::class, [
                'attr' => [
                    'placeholder' => 'Entrez votre taille',
                ],
            ])
            ->add('poids', NumberType::class, [
                'attr' => [
                    'placeholder' => 'Entrez votre poids',
                ],
            ])
            // ...

            ->add('recaptcha', EWZRecaptchaType::class, [
                'label' => false, // Set the label to false to hide it
                'mapped' => false, // The reCAPTCHA field is not mapped to any entity property
            ]); // Add a semicolon here

            // ...

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
