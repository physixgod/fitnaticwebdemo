<?php

namespace App\Controller;

use App\Entity\Activite;
use App\Form\AddactiviteType;
use App\Repository\ActiviteRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ActiviteController extends AbstractController
{
    #[Route('/activite', name: 'app_activite')]
    public function index(): Response
    {
        return $this->render('activite/index.html.twig', [
            'controller_name' => 'ActiviteController',
        ]);
    }

    #[Route('/activite/add', name: 'Activite_add')]
    public function addActivite(Request $req, ManagerRegistry $manager): Response
    {
        $Activite = new Activite();
        $form = $this->createForm(AddactiviteType::class, $Activite);
        $form->handleRequest($req);
        if ($form->isSubmitted()) {
            $em = $manager->getManager();
            $em->persist($Activite);
            $em->flush();
            return $this->redirectToRoute("activite_list");
        }
        return $this->renderForm('activite/form.html.twig', [
            'form' => $form
        ]);
    }
    #[Route('/activite/show', name: 'activite_list')]
    public function showactivite(ActiviteRepository $repo): Response
    {
        $Activite = $repo->findAll();
        return $this->render('activite/show.html.twig', [
            'Activite' => $Activite 
        ]);
    }

    #[Route('/activite/updateactiviteForm/{id}', name: 'activite_update')]
    public function updateactivite(Request $req, ManagerRegistry $manager, $id, ActiviteRepository $repo): Response
    {
        $em = $manager->getManager();
        $author = $repo->find($id);

        // Appel au formulaire 
        $form = $this->createForm(AddactiviteType::class, $author);
        $form->handleRequest($req);
        if ($form->isSubmitted()) {
            $em->persist($author);
            $em->flush();

            return $this->redirectToRoute('activite_list');
        }

        return $this->renderForm('activite/form.html.twig', ['form' => $form]);
    }

    #[Route('/activite/delete/{id}', name: 'activite_delete')]
    public function deleteActivite(ManagerRegistry $manager, $id, ActiviteRepository $repo): Response
    {
        $author = $repo->find($id);

        $em = $manager->getManager();
        $em->remove($author);
        $em->flush();

        return $this->redirectToRoute('activite_list');
    }

}
