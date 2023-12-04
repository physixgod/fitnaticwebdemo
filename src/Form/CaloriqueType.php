<?php
// src/Form/CaloriqueType.php

namespace App\Form;

use App\Entity\Calorique;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CaloriqueType extends AbstractType
{
    const OBJECTIF_CHOICES = [
        'Lose Weight' => 'loseWeight',
        'Maintain' => 'maintain',
        'Build Muscle' => 'buildMuscle',
    ];

    const ACTIVITE_CHOICES = [
        'Sedentary' => 'sedentary',
        'Lightly Active' => 'lightlyActive',
        'Moderately Active' => 'moderatelyActive',
        'Very Active' => 'veryActive',
    ];

    const NIVEAU_STRESS_CHOICES = [
        'Low' => 'low',
        'Medium' => 'medium',
        'High' => 'high',
    ];

    const REGIME_CHOICES = [
        'Vegan' => 'vegan',
        'Vegetarian' => 'vegetarian',
        'Pescatarian' => 'pescatarian',
        'Omnivore' => 'omnivore',
    ];

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('objectif', ChoiceType::class, [
                'choices' => array_flip(self::OBJECTIF_CHOICES),
                'expanded' => true,
                'multiple' => false,
                'label' => false,
            ])
            ->add('activite', ChoiceType::class, [
                'choices' => array_flip(self::ACTIVITE_CHOICES),
                'expanded' => true,
                'multiple' => false,
                'label' => false,
            ])
            ->add('regimeAlimentaire', ChoiceType::class, [
                'choices' => array_flip(self::REGIME_CHOICES),
                'expanded' => true,
                'multiple' => false,
                'label' => false,
            ])
            ->add('niveauStress', ChoiceType::class, [
                'choices' => array_flip(self::NIVEAU_STRESS_CHOICES),
                'expanded' => true,
                'multiple' => false,
                'label' => false,
            ])
     
            ->add('save', SubmitType::class, [
                'label' => 'Save',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Calorique::class,
        ]);
    }
}
