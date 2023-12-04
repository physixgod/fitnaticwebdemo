<?php

namespace App\Form;

use App\Entity\Stat;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('rating', ChoiceType::class, [
           'label' =>  'Rating',
            'choices' => [
                '1 star' => 1,
                '2 stars' => 2,
                '3 stars' => 3,
                '4 stars' => 4,
                '5 stars' => 5,
            ],
            
            'expanded' => true,
            'multiple' => false,
            'required' => true, // Le champ est requis
            'label_attr' => [
                'style' => 'color: white;', // Ajoutez cette ligne pour définir la couleur du texte
            ],
            'choice_attr' => function ($choice, $key, $value) {
                return ['class' => 'white-text']; // Ajoutez une classe aux options
            },
            
        ]);
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Stat::class,
        ]);
    }
}
