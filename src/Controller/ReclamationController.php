<?php

namespace App\Controller;
use App\Form\ReclamationType;
use App\Entity\Reclamation;
use App\Repository\ReclamationRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\TwilioService;

class ReclamationController extends AbstractController
{
    #[Route('/reclamation', name: 'app_reclamation')]
    public function index(): Response
    {
        return $this->render('reclamation/index.html.twig', [
            'controller_name' => 'ReclamationController',
        ]);
    }
 
    #[Route('/addReclamation', name: 'add_reclamation')]
    public function addReclamation(ManagerRegistry $manager, Request $request,TwilioService $twilioService): Response
    {
        $em = $manager->getManager();
    
        $Reclamation = new Reclamation();
    
        $form = $this->createForm(ReclamationType::class, $Reclamation);
        $form->handleRequest($request);
    
        $errorMessage = null;
    
        if ($form->isSubmitted() && $form->isValid()) {
            if ($this->badWords($Reclamation->getDescription())) {
                // Mots inappropriés détectés, définir le message d'erreur
                $errorMessage = 'Your reclamation contains inappropriate words.';
            } else {
                // Aucun mot inapproprié détecté, procéder à l'ajout de la réclamation
                $em->persist($Reclamation);
                $em->flush();
    
                $this->addFlash('success', 'Reclamation added successfully!');
                $to = '+21624264948'; // Static phone number

             $message = 'New Reclamation created'; 
          //   $twilioService->sendSMS($to, $message);
                return $this->redirectToRoute('list_lastrec');
            }
        }
    
        // Si vous arrivez ici, cela signifie qu'il y a des erreurs dans le formulaire
        // ou que la description contient des mots inappropriés
    
        return $this->renderForm('reclamation/addRec.html.twig', [
            'form' => $form,
            'errorMessage' => $errorMessage,
        ]);
    }
    
    
    #[Route('/listLastRec', name: 'list_lastrec')]
    public function listReclamation(ReclamationRepository $reclamationRepository): Response
    {
        // Fetch the latest reclamation based on some condition, for example, the highest ID
        $latestReclamation = $reclamationRepository->findOneBy([], ['id' => 'DESC']);
        $successMessage = $this->get('session')->getFlashBag()->get('success') ?? ['Reclamation added successfully!'];

        dump($successMessage);

        return $this->render('reclamation/listLastRec.html.twig', [
            'latestReclamation' => $latestReclamation,
            'successMessage' => $successMessage,
        ]);
    }
    
  private function badWords(string $text): bool
    {
        $badWords = ['raciste', 'pute', 'israil']; // Remplacez ces valeurs par votre liste de mots interdits

        foreach ($badWords as $badWord) {
            if (stripos($text, $badWord) !== false) {
                return true;
            }
        }
        
        return false;
    }  
    
}
    
