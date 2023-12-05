<?php

namespace App\Controller;

use App\Entity\Exercices;
use App\Form\ExercicesType;
use App\Repository\ExercicesRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Snappy\Pdf;

class ExercicesController extends AbstractController
{
    private $exerciseApiService;

    // Inject ExerciseApiService into the constructor
   /* public function __construct(ExerciseApiService $exerciseApiService)
    {
        $this->exerciseApiService = $exerciseApiService;
    }

    #[Route('/exercices', name: 'app_exercices')]
    public function index(): Response
    {
        $exercises = $this->exerciseApiService->getExercises();
        
        return $this->render('exercices/index.html.twig', [
            'controller_name' => 'ExercicesController',
            'exercises' => $exercises, 
        ]);
    }*/

    #[Route('/exercices/add', name: 'exercices_add')]
    public function addexercices(Request $req, ManagerRegistry $manager): Response
    {
        $Exercices = new Exercices();
        $Exercices->setProgress(0);
        $form = $this->createForm(ExercicesType::class, $Exercices);
        $form->handleRequest($req);
        if ($form->isSubmitted()) {
            $imageFile = $form->get('imageFile')->getData();
            if ($imageFile) {
                // Set the image file in the entity
                $Exercices->setImageFile($imageFile);
                
            }
    
            $em = $manager->getManager();
            $em->persist($Exercices);
            $em->flush();
            return $this->redirectToRoute("exercices_list");
        }
        return $this->renderForm('exercices/form.html.twig', [
            'f' => $form
            
        ]);
    }

    #[Route('/exercices/show', name: 'exercices_list')]
    public function showexercices(ExercicesRepository $repo): Response
    {
        $Exercices = $repo->findAll();
         // Fetch historical progress data
         $historicalData = $repo->findHistoricalProgressData();
         $data = json_encode($historicalData);

         // Prepare data for the template
         
        return $this->render('exercices/show.html.twig', [
            'Exercices' => $Exercices,
            'data' => $data,
        ]);
    }
    private $knpSnappyPdf;

    public function __construct(Pdf $knpSnappyPdf)
    {
        $this->knpSnappyPdf = $knpSnappyPdf;
    }
    
    #[Route('/exercices/show/pdf', name: 'exercices_list_pdf')]
    public function generatePdf(ExercicesRepository $repo): Response
    {
        $exercices = $repo->findAll();
    
        // Render the Twig template to HTML
        $html = $this->renderView('exercices/show.html.twig', ['Exercices' => $exercices]);
    
        $contentStart = '<table class="table table-bordered table-hover">';
        $contentEnd = '</table>';
        $startPosition = strpos($html, $contentStart);
        $endPosition = strpos($html, $contentEnd, $startPosition + strlen($contentStart));
        
        if ($startPosition !== false && $endPosition !== false) {
            $contentHtml = substr($html, $startPosition, $endPosition - $startPosition + strlen($contentEnd));
    
            // Generate PDF response for the specific content
            return new PdfResponse(
                $this->knpSnappyPdf->getOutputFromHtml($contentHtml),
                'exercices_list.pdf'
            );
        }
    
        // Handle the case where the content tags are not found
        return $this->render('error.html.twig', ['error' => 'Content not found in the HTML']);
    }
    

    #[Route('/exercices/updateexercicesForm/{id}', name: 'exercices_update')]
    public function updateactivite(Request $req, ManagerRegistry $manager, $id, ExercicesRepository $repo): Response
    {
        $em = $manager->getManager();
        $author = $repo->find($id);

        // Appel au formulaire 
        $form = $this->createForm(ExercicesType::class, $author);
        $form->handleRequest($req);
        if ($form->isSubmitted()) {
            $em->persist($author);
            $em->flush();

            return $this->redirectToRoute('exercices_list');
        }

        return $this->renderForm('exercices/form.html.twig', ['f' => $form]);
    }

    #[Route('/exercices/delete/{id}', name: 'exercices_delete')]
    public function deleteActivite(ManagerRegistry $manager, $id, ExercicesRepository $repo): Response
    {
        $author = $repo->find($id);

        $em = $manager->getManager();
        $em->remove($author);
        $em->flush();

        return $this->redirectToRoute('exercices_list');
    }
}
