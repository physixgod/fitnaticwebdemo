<?php

namespace App\Form;

use App\Entity\Competition;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class CompetitionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
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
            ->add('location')
            ->add('description')
            ->add('competitionCategory', ChoiceType::class, [
                'label' => 'Competition Category',
                'choices' => [
                    'Professional' => 'Professional',
                    'Amateur' => 'Amateur',
                    'University' => 'University',
                    'Cadet' => 'Cadet',
                    'Friendly' => 'Friendly',
                    'Regional' => 'Regional',
                    'National' => 'National',
                    'Qualification' => 'Qualification',
                    'Final' => 'Final',
                    'Other' => 'Other',
                ],
                'attr' => ['class' => 'form-select'],
            ])
            ->add('entryFee')
            ->add('maxParticipants')
            
            ->add('prize')
            ->add('sportType')
            ->add('save', SubmitType::class, [
                'label' => 'Add Competition',
            ])
        ;
        ;
    }
    public function validateEndDate($value, ExecutionContextInterface $context)
    {
        $startDate = $context->getRoot()['start_date']->getData();

        if ($startDate >= $value) {
            $context->buildViolation('End date must be greater than the start date.')
                ->atPath('end_date')
                ->addViolation();
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Competition::class,
            'sportTypeChoices' => [],
        ]);
    }
}
