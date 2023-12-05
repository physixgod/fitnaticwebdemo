<?php

namespace App\Controller;

use App\Entity\Publication;
use App\Form\PublicationType;
use App\Repository\PublicationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PublicationController extends AbstractController
{
    // ...

    #[Route('/addpub', name: 'add_publication')]
    public function addPublication(ManagerRegistry $manager, Request $request, PublicationRepository $publicationRepository): Response
    {
        $em = $manager->getManager();
    
        $publication = new Publication();
    
        $form = $this->createForm(PublicationType::class, $publication);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($publication);
            $em->flush();
    
            // Charger les publications existantes
            $publications = $publicationRepository->findAll();
    
            return $this->render('publication/add.html.twig', [
                'form' => $form->createView(),
                'publications' => $publications, // Transmettre les publications à la vue
            ]);
        }
    
        // Charger les publications existantes
        $publications = $publicationRepository->findAll();
    
        return $this->render('publication/add.html.twig', [
            'form' => $form->createView(),
            'publications' => $publications, // Transmettre les publications à la vue
        ]);
    }
    #[Route('/publication/delete/{id}', name: 'publication_delete')]

    public function deletepublication(Request $request, $id, ManagerRegistry $manager, PublicationRepository $repo): Response
    {
        $em = $manager->getManager();
        $pub = $repo->find($id);

        if (!$pub) {
            throw $this->createNotFoundException('Publication not found');
        }

        $em->remove($pub);
        $em->flush();

       

        return $this->redirectToRoute('add_publication');
    }
    #[Route('/forum', name: 'app_forum')]
    public function index(): Response
    {
        return $this->render('evenement/forum.html.twig');
    }
}