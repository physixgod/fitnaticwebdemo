<?php

namespace App\Controller;

use App\Entity\Calorique;
use App\Entity\Imc;
use App\Form\CaloriqueType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CaloriqueController extends AbstractController
{
    #[Route('/calorique/calculate', name: 'calculate_calorique', methods: ['GET', 'POST'])]
    public function calculateCalories(Request $request): Response
    {
        $imcRepository = $this->getDoctrine()->getRepository(Imc::class);
        $latestImc = $imcRepository->findLatestImc();

        if ($latestImc === null) {
            $this->addFlash('error', 'No IMC available. Please calculate IMC first.');
            return $this->redirectToRoute('calculate_calorique');
        }

        $form = $this->createForm(CaloriqueType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $calorique = $form->getData(); // This assumes your form is mapped to the Calorique entity

            // Proceed with the calculation
            $calories = $this->calculateCaloriesFromWeightHeightAgeGender(
                $latestImc->getPoids(),
                $latestImc->getTaille(),
                $latestImc->getAge(),
                $latestImc->getSexe(),
                $calorique->getActivite(),
                $calorique->getObjectif(),
                $calorique->getRegimeAlimentaire(),
                $calorique->getNiveauStress()
            );

            $calorique->setBesoinsCaloriques($calories);
            $a=$calorique->setBesoinsCaloriques($calories);
            $calorique->setImcs($latestImc);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($calorique);

            try {
                $entityManager->flush();
            } catch (\Exception $e) {
                $this->addFlash('error', 'An error occurred while saving Caloric data.');
                // Log the error or handle it appropriately
                return $this->redirectToRoute('calculate_calorique');
            }

            $this->addFlash('success', 'Caloric data saved successfully.');
            return $this->redirectToRoute('calculate_calorique',['x'=>$a]);
        }

        return $this->render('calorique/Calorique.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    private function calculateCaloriesFromWeightHeightAgeGender($poids, $taille, $age, $sexe, $activite, $objectif, $regimeAlimentaire, $niveauStress)
    {
        $mb = ($sexe === 'homme') ?
            88.362 + (13.397 * $poids) + (4.799 * $taille) - (5.677 * $age) :
            447.593 + (9.247 * $poids) + (3.098 * $taille) - (4.330 * $age);

        $facteursActivite = [
            'sedentary' => 1.0,
            'lightlyActive' => 1.2,
            'moderatelyActive' => 1.5,
            'veryActive' => 1.8,
        ];

        $facteursObjectif = [
            'loseWeight' => 1.1,
            'maintain' => 1.0,
            'buildMuscle' => 1.4,
        ];

        $facteursNiveauStress = [
            'low' => 1.2,
            'medium' => 1.3,
            'high' => 1.4,
        ];

        $facteurRegimeAlimentaire = [
            'vegan' => 1.1,
            'vegetarian' => 1.2,
            'pescatarian' => 1.4,
            'omnivore' => 1.5,
        ];

        $besoinsCaloriques = $mb *
        ($facteursActivite[$activite] ?? 1.0) *
        ($facteursObjectif[$objectif] ?? 1.0) *
        ($facteurRegimeAlimentaire[$regimeAlimentaire] ?? 1.0) *
        ($facteursNiveauStress[$niveauStress] ?? 1.0);
    

        return abs($besoinsCaloriques);
    }
}
