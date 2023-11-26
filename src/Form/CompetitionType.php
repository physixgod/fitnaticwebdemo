<?php

namespace App\Form;

use App\Entity\Competition;
use App\Entity\SportType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class CompetitionType extends AbstractType

{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {   $locations = $this->getLocations();
        $sportTypes = $this->getSportTypes();
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
            ->add('location', EntityType::class, [
                'class' => SportType::class, // Replace with the actual namespace of your Author entity
                'choice_label' => 'location', // Assuming Author entity has a method getFullName() that returns the author's full name
                'placeholder' => '', 
                'required' => true, 

            ])
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
              ->add('sportType', EntityType::class, [
                'class' => SportType::class, // Replace with the actual namespace of your Author entity
                'choice_label' => 'name', // Assuming Author entity has a method getFullName() that returns the author's full name
                'placeholder' => ' ', 
                'required' => true, 

            ])
            ->add('save', SubmitType::class, [
                'label' => 'Add Competition',
            ])
            
        ;
        ;
    }
    private function getLocations(): array
    {
        $locations = $this->entityManager->getRepository(SportType::class)->findDistinctLocations();

        return $locations;
    }

    private function getSportTypes(): array
    {
        $sportTypes = $this->entityManager->getRepository(SportType::class)->findAllSportTypes();

        return $sportTypes;
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
