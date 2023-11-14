<?php

namespace App\Controller;

use App\Entity\Points;
use App\Form\PointsType;
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
    public function addPoints(ManagerRegistry $manager, Request $request): Response
    {
        $em = $manager->getManager();

        $points = new Points();
        $userData = $this->getDoctrine()->getRepository(Points::class)->findAll();
        $form = $this->createForm(PointsType::class, $points);

        $form->handleRequest($request);
        if ($form->isSubmitted () ) {   
            $em->persist($points);
            $em->flush();
            return $this->redirectToRoute('points');
        
          
        }
        
        return $this->renderForm('points/userpoints.html.twig', ['form' => $form,'userData' => $userData]);
    } 
}
