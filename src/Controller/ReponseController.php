<?php

namespace App\Controller;

use App\Service\MailService;
use App\Entity\Reclamation;
use App\Entity\Reponse;
use Doctrine\ORM\EntityNotFoundException;
use App\Form\ReclamationType;
use App\Form\ReponseType;
use App\Repository\ReclamationRepository;
use App\Repository\ReponseRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReponseController extends AbstractController
{
    #[Route('/reponse', name: 'app_reponse')]
    public function index(): Response
    {
        return $this->render('reponse/index.html.twig', [
            'controller_name' => 'ReponseController',
        ]);
    }

    

    #[Route('/listReclamation', name: 'list_reclamationDB')]
    public function listReclamation(ReclamationRepository $reclamationrepository): Response
    {
        
        return $this->render('reponse/listReclamation.html.twig', [
            'reclamations' => $reclamationrepository->findAll(),
        ]);
    }

    #[Route('/reclamation/delete/{id}', name: 'reclamation_delete')]
    public function deleteReclamation($id, ManagerRegistry $manager, ReclamationRepository $reclamationrepository): Response
    {
        $em = $manager->getManager();
        $reclamation = $reclamationrepository->find($id);
       
            $em->remove($reclamation);
            $em->flush();
        
        return $this->redirectToRoute('list_reclamationDB');
    }
//hnshngsgnhnwnshvwhns
    #[Route('/reclamation/edit/{id}', name: 'reclamation_edit')]
    public function editReclamation(Request $request, ManagerRegistry $manager, $id, ReponseRepository $reponserepository, MailService $mailService): Response
    {
        $em = $manager->getManager();

        $Reponse = new Reponse();

        $form = $this->createForm(ReponseType::class, $Reponse);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em->persist($Reponse);
            $em->flush();
            
             // Récupérer le contenu du formulaire
        $emailContent = $form->get('contenu')->getData();

        // Utiliser le contenu du formulaire pour envoyer l'e-mail
        $mailService->sendEmail('youssef.zammit@esprit.tn', 'Sujet de l\'e-mail', $emailContent);
            $this->addFlash('success', 'Reponse added successfully!');

            return $this->redirectToRoute('list_reclamationDB');
        }
        //dump('Template rendered!');
        return $this->renderForm('reponse/editReclamation.html.twig', ['form' => $form]);
    }
 
    #[Route('/rechercher', name: 'reclamation_search')]
    public function rechercherParUserId(Request $request): Response
    {
        // Récupérer le userId depuis la requête
        $userId = $request->query->get('userId');

        // Accéder au référentiel (repository) de l'entité Reclamation
        $reclamationRepository = $this->getDoctrine()->getRepository('App\Entity\Reclamation');

        // Rechercher la réclamation par userId
        $reclamations = $reclamationRepository->findBy(['userId' => $userId]);

        // Vous pouvez maintenant traiter les réclamations trouvées (par exemple, les afficher dans une vue)
        return $this->render('reponse/search.html.twig', [
            'reclamations' => $reclamations,
            'userId' => $userId,
        ]);
    }

}

    



