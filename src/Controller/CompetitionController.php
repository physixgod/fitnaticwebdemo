<?php

namespace App\Controller;

use App\Entity\Competition;
use App\Entity\SportType;
use App\Form\CompetitionType;
use App\Form\EmailSendType;
use App\Form\RatingType;
use App\Repository\CompetitionRepository;
use App\Service\MailService;
use CompileError;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Snappy\Pdf;
use Mailtrap\Config;
use Mailtrap\Helper\ResponseHelper;
use Mailtrap\MailtrapClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
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
    public function addCompetition(EntityManagerInterface $entityManager, Request $request): Response
    {
        $competition = new Competition();
        
        // Fetch sport types from the repository
       
    
        $form = $this->createForm(CompetitionType::class, $competition);
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $competition->setStatus("Open");
    
            $entityManager->persist($competition);
            $entityManager->flush();
    
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
#[Route('/usercompetitions', name: 'app_competitions')]
public function listcompetitinosuser(CompetitionRepository $competitionrepo,Request $request , MailerInterface $mailer , MailService $mailService): Response
{
    $openCompetitions = $competitionrepo->findBy(['status' => 'open']);
    $form = $this->createForm(EmailSendType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() ) {
            $competitionName = $request->request->get('competition_name');
            $email = $form->get('email')->getData();
            $mailContent = "<p>Dear participant,<br>
            Thank you for joining the < $competitionName > competition. Your participation is greatly appreciated, and we look forward to your active involvement. If you have any questions or need assistance, please don't hesitate to contact us.<br>
            Best regards,<br>
            The Competition Team!</p>";
        
        

$mailService->sendEmail($email, 'Confirmation of Participation!', $mailContent);

            
$this->addFlash('success', 'Email sent successfully!');

            return $this->redirectToRoute('app_competitions');
        }

  

    return $this->render('competition/competitionsList.html.twig', [
        'competitions' => $openCompetitions,
        'emailForm' => $form->createView(),
    ]);
}
#[Route('/competitions/details/{id}', name: 'competitions_details')]
public function show(CompetitionRepository $competitionRepository, $id): Response
{
    return $this->render('competition/readmore.html.twig', [
        'competition' => $competitionRepository->find($id),
    ]);
}  
#[Route('/email')]
public function sendEmail(MailerInterface $mailer , MailService $mailService): Response
{
    $mailService->sendEmail('moez@esprit.tn', 'Confirmation of Participation!', '<p>Welcome to our competition!</p>');

    return $this->render('competition/test.html.twig');
}

public function handleEmail(Request $request , MailerInterface $mailer , MailService $mailService): Response
    {
        $form = $this->createForm(EmailSendType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() ) {
            $competitionName = $request->request->get('competition_name');
          
            $email = $form->get('email')->getData();
            $mailContent = "<p>Dear participant,
            Thank you for joining the $competitionName competition. Your participation is greatly appreciated, and we look forward to your active involvement. If you have any questions or need assistance, please don't hesitate to contact us.
            Best regards,
            The Competition Team!</p>";
        
        $mailService->sendEmail($email, 'Confirmation of Participation!', $mailContent);

            
  
            return $this->redirectToRoute('app_competitions');
        }

  
        return $this->render('competition/competitionsList.html.twig', [
            'emailForm' => $form->createView(),
        ]);
    }
    #[Route('/Evaluation', name: 'competition_evaluation')]
    public function Evaluation(EntityManagerInterface $entityManager, Request $request): Response
    {
        
        
        $form = $this->createForm(RatingType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() ) {
            $comment = $form->get('Comment')->getData();
            
            
            
            $badWords = ['rape', 'kill', 'suicide'];

            
            if ($this->containsBadWords($comment, $badWords)) {
                $this->addFlash('error', 'The comment contains inappropriate words.');
                return $this->redirectToRoute('competition_evaluation');
                
            }
            return $this->redirectToRoute('app_competitions');
            

         
           
        }

        return $this->renderForm('competition/evaluation.html.twig', ['ratingForm' => $form]);
    }

    private function containsBadWords($comment, $badWords)
    {
        $comment = strtolower($comment); 

        foreach ($badWords as $badWord) {
            if (strpos($comment, strtolower($badWord)) !== false) {
                return true;
            }
        }

        return false;
    }
    #[Route('/toPdf/{id}', name: 'print_competition')]
    public function printCompetition(Pdf $pdf, $id,CompetitionRepository $competitionrepo)
    {
        $competition = $competitionrepo->find($id);
        $name = $competition->getName();

        $html = $this->renderView('competition/pdf.html.twig', ['competition' => $competition]);

        $filename = 'competition_' . $name . '.pdf';

        return new Response(
            $pdf->getOutputFromHtml($html),
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $filename . '"',
            ]
        );
    }
    #[Route('/quiz1', name: 'quiz_app')]
    public function quiz(Request $request): Response
    {
        return $this->render('competition/quiz.html.twig');
    }  
    #[Route('/quiz/submit', name: 'quiz_submit', methods: ['POST'])]
    public function submitQuiz(Request $request): Response
    {
       
        $answers = $request->request->all();

        
        $score = $this->calculateScore($answers);

        
        return $this->render('competition/quizresult.html.twig', ['score' => $score]);
    }

    private function calculateScore(array $answers): int
    {
       
        $correctAnswers = [
            'q1' => 'a',    
            'q2' => 'a',    
            'q3' => 'a',    
            'q4' => 'b',    
            'q5' => 'b',    
            'q6' => 'a',    
            'q7' => 'a',    
            'q8' => 'b',    
            'q9' => 'a',    
            'q10' => 'a',   
        ];

        $score = 0;
        foreach ($answers as $question => $selectedOption) {
            if (isset($correctAnswers[$question]) && $correctAnswers[$question] === $selectedOption) {
                $score++;
            }
        }

        return $score;
    }
}




