<?php

namespace App\Controller;

use App\Entity\Points;
use App\Form\PointsType;
use App\Repository\PointsRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PointsController extends AbstractController
{
    #[Route('/points', name: 'app_points')]
    public function index(): Response
    {
        return $this->render('points/index.html.twig', [
            'controller_name' => 'PointsController',
        ]);
    }
    #[Route('/userpoints', name: 'points')]
    public function addPoints(ManagerRegistry $manager, Request $request, PointsRepository $repo): Response
    {
        $em = $manager->getManager();
        $data = $repo->findAll();
        $points = new Points();
        $pointsUser = [];
        $pointsP = [];
    
        foreach ($data as $point) {
            $pointsUser[] = $point->getUsername();
            $pointsP[] = $point->getPoints();   
        }
    
        $form = $this->createForm(PointsType::class, $points);
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted() ) {
            $enteredUsername = $form->get('Username')->getData();
            $enteredPoints = $form->get('points')->getData();
    
            
            $existingPointsEntity = $repo->findOneBy(['Username' => $enteredUsername]);
    
            if ($existingPointsEntity) {
               
                $existingPoints = $existingPointsEntity->getPoints();
                $existingPointsEntity->setPoints($existingPoints + $enteredPoints);
                $em->persist($existingPointsEntity);
            } else {
                
                $points->setUsername($enteredUsername);
                $points->setPoints($enteredPoints);
                $em->persist($points);
            }
    
            $em->flush();
    
            return $this->redirectToRoute('points');
        }
    
        return $this->renderForm('points/userpoints.html.twig', ['form' => $form, 'username' => json_encode($pointsUser), 'points' => json_encode($pointsP)]);
    }
    
}
