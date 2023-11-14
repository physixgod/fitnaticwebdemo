<?php

namespace App\Controller;

use App\Entity\SportType;
use App\Form\SportTypeType;
use App\Repository\SportTypeRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SportTypeController extends AbstractController
{
    #[Route('/sport/type', name: 'app_sport_type')]
    public function index(): Response
    {
        return $this->render('sport_type/index.html.twig', [
            'controller_name' => 'SportTypeController',
        ]);
    }
    #[Route('/sporttype/add', name: 'add_sporttype')]
    public function addSportType(ManagerRegistry $manager, Request $request): Response
    {
        $em = $manager->getManager();
    
        $sportType = new SportType();
    
        $form = $this->createForm(SportTypeType::class, $sportType); 
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($sportType);
            $em->flush();
    
            return $this->redirectToRoute('list_sport'); 
        }
        return $this->renderForm('sport_type/addsporttype.html.twig', ['form' => $form]);
    
    }
    #[Route('/sport', name: 'list_sport')]
    public function listCompetition(SportTypeRepository $sportrepo): Response
    {
        return $this->render('sport_type/sport_list.html.twig', [
            'sportTypes' => $sportrepo->findAll(),
        ]);
    }  
    #[Route('/sport_type/edit/{id}', name: 'sport_type_edit')]
    public function editSportType(Request $request, ManagerRegistry $manager, $id, SportTypeRepository $sportTypeRepository): Response
    {
        $em = $manager->getManager();

        $sportType = $sportTypeRepository->find($id);
        $form = $this->createForm(SportTypeType::class, $sportType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($sportType);
            $em->flush();
         
            return $this->redirectToRoute('list_sport');
        }

        return $this->renderForm('sport_type/editSportType.html.twig', [
            'sportType' => $sportType,
            'form' => $form,
        ]);
    }
    #[Route('/sport_type/delete/{id}', name: 'sport_type_delete')]
    public function deleteSportType(Request $request, $id, ManagerRegistry $manager, SportTypeRepository $sportTypeRepository): Response
    {
        $em = $manager->getManager();
        $sportType = $sportTypeRepository->find($id);

        if (!$sportType) {
            throw $this->createNotFoundException('Sport Type not found');
        }

        $em->remove($sportType);
        $em->flush();

        

        return $this->redirectToRoute('list_sport');
    }
    
}
