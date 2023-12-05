<?php

namespace App\Form;

use App\Entity\Exercices;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ExercicesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomE')
            ->add('categorie', ChoiceType::class, [
                'choices' => [
                    'Compound' => 'Compound',
                    'Isolation' => 'Isolation',
                    // Add more categories as needed
                ],
                'placeholder' => 'Select a category',
                'required' => true,
                'attr' => ['class' => 'form-control'],
            ])
            ->add('dureeE')
            ->add('repetitions')
            ->add('series')
            ->add('objectif')
            ->add('niveauDifficulte', ChoiceType::class, [
                'choices' => [
                    'Easy' => 'easy',
                    'Medium' => 'medium',
                    'Hard' => 'hard',
                ],
                'placeholder' => 'Select difficulty level',
                'required' => true,
                'attr' => ['class' => 'form-control'],
            ])
            ->add('progress')
            ->add('imageFile', VichImageType::class, [
                'label' => 'Product Image',
                'required' => false, // Set to true if the image is mandatory
            ]);
            
            
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Exercices::class,
        ]);
    }
}
