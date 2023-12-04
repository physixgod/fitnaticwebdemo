<?php

namespace App\Controller;

use App\Entity\Stat;
use App\Form\StatType;
use App\Repository\StatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StatController extends AbstractController
{
    #[Route('/stat', name: 'app_stat')]
    public function index(): Response
    {
        return $this->render('stat/index.html.twig', [
            'controller_name' => 'StatController',
        ]);
    }

    #[Route('/statistics', name: 'statistics')]
public function statistics(Request $request, StatRepository $statRepository): Response
{
    // Créer le formulaire de notation
    $statEntity = new Stat(); // Assurez-vous d'avoir une instance de Stat
    $starRatingForm = $this->createForm(StatType::class, $statEntity);

    // Gérer la soumission du formulaire
    $starRatingForm->handleRequest($request);
    if ($starRatingForm->isSubmitted() && $starRatingForm->isValid()) {
        // Enregistrer la note dans la base de données ou effectuer toute autre logique nécessaire
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($statEntity);
        $entityManager->flush();

        // Rediriger ou rafraîchir la page si nécessaire
        return $this->redirectToRoute('statistics');
    }

    // Récupérer les évaluations des réclamations
    $ratings = $statRepository->getRatings();

    // Convertir les évaluations en format adapté pour le barchart
    $data = [];
    for ($i = 1; $i <= 5; $i++) {
        $count = $ratings[$i] ?? 0;
        $data["Rating $i"] = $count;
    }

    // Passer les données et le formulaire au template
    return $this->render('stat/statistics.html.twig', [
        'data' => $data,
        'starRatingForm' => $starRatingForm->createView(), // Créez la vue du formulaire
    ]);
}
}

