<?php

namespace App\Form;

use App\Entity\Activite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class AddactiviteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Cardio' => 'Cardio',
                    'weightlifting' => 'weightlifting',
                    'Body Building' => 'Body Building',
                    
                ],
                'placeholder' => 'Select Type',
                'required' => true,
                'attr' => [
                    'class' => 'form-control', 
                ],
            ])
            ->add('dateDebut')
            ->add('dateFin')
            ->add('duree')
            ->add('notes')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Activite::class,
        ]);
    }
}
