<?php

namespace App\Form;

use App\Entity\SportType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SportTypeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('location')
            ->add('start_date', DateType::class, [
                'label' => 'Start Date',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',

            ])
            ->add('end_date', DateType::class, [
                'label' => 'End Date',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',

            ])
            ->add('save', SubmitType::class, [
                'label' => 'Add Sport Type',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SportType::class,
        ]);
    }
}
