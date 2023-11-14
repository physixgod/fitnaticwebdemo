<?php

namespace App\Controller;

use App\Entity\Competition;
use App\Form\CompetitionType;
use App\Repository\CompetitionRepository;
use CompileError;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CompetitionController extends AbstractController
{
    #[Route('/competition', name: 'app_competition')]
    public function index(): Response
    {
        return $this->render('competition/index.html.twig', [
            'controller_name' => 'CompetitionController',
        ]);
    }
    #[Route('/CompetitionAdd', name: 'add_competition')]
    public function addCompetition(ManagerRegistry $manager, Request $request ): Response
    {
        $em = $manager->getManager();

        $competition = new Competition();

        $form = $this->createForm(CompetitionType::class, $competition);

        $form->handleRequest($request);
        if ($form->isSubmitted () && $form->isValid ()) {   
            $competition->setStatus("Open");
            $em->persist($competition);
            $em->flush();
            return $this->redirectToRoute('list_Competitions');
          
        }
        
        return $this->renderForm('competition/addcompetition.html.twig', ['form' => $form]);
    } 
    #[Route('/listCompetitions', name: 'list_Competitions')]
    public function listCompetition(CompetitionRepository $competitionrepo): Response
    {
        return $this->render('competition/listCompetitions.html.twig', [
            'competitions' => $competitionrepo->findAll(),
        ]);
    }   
    #[Route('/competition/edit/{id}', name: 'competition_edit')]
public function editCompetition(Request $request, ManagerRegistry $manager, $id, CompetitionRepository $competitionRepository): Response
{
    $em = $manager->getManager();

    $competition = $competitionRepository->find($id);
    $form = $this->createForm(CompetitionType::class, $competition);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $em->persist($competition);
        $em->flush();
        $this->addFlash('success', 'Competition has been updated successfully.');
        return $this->redirectToRoute('list_Competitions');
    }

    return $this->renderForm('competition/editCompetition.html.twig', [
        'competition' => $competition,
        'form' => $form,
    ]);
}
#[Route('/competition/delete/{id}', name: 'competition_delete')]
public function deleteCompetition(Request $request, $id, ManagerRegistry $manager, CompetitionRepository $competitionRepository): Response
{
    $em = $manager->getManager();
    $competition = $competitionRepository->find($id);

    if (!$competition) {
        throw $this->createNotFoundException('Competition not found');
    }

    $em->remove($competition);
    $em->flush();

    $this->addFlash('success', 'Competition has been deleted successfully.');

    return $this->redirectToRoute('list_Competitions');
}

}
