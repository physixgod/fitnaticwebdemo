<?php

namespace App\Controller;
use App\Entity\Task;
use App\Form\TaskType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/task', name: 'app_task')]
    public function index(): Response
    {
        
        $tasks = $this->entityManager->getRepository(Task::class)->findAll();

        return $this->render('task/api.html.twig', [
            'tasks' => $tasks,
        ]);
    }

    
    public function index1()
    {
        $tasks = $this->entityManager->getRepository(Task::class)->findAll();
        $data = [];

        foreach ($tasks as $task) {
            $data[] = [
                'id' => $task->getId(),
                'title' => $task->getTitle(),
                'description' => $task->getDescription(),
                'dueDate' => $task->getDueDate()->format('Y-m-d H:i:s'),
                'completed' => $task->isCompleted(),
                'priority' => $task->getPriority(),
            ];
        }

        return new JsonResponse($data);
    }


    /**
 * @Route("/tasks/{id}", name="task_show", methods={"GET"})
 */
public function show(Task $task)
{
    $data = [
        'id' => $task->getId(),
        'title' => $task->getTitle(),
        'description' => $task->getDescription(),
        'dueDate' => $task->getDueDate()->format('Y-m-d H:i:s'),
        'completed' => $task->isCompleted(),
        'priority' => $task->getPriority(),
    ];

    return new JsonResponse($data);
}

    
    public function create(Request $request)
    {
        // Parse JSON data from the request body
        $data = json_decode($request->getContent(), true);

        // Create a new Task entity
        $task = new Task();
        $task->setTitle($data['title']);
        $task->setDescription($data['description']);
        $task->setDueDate(new \DateTime($data['dueDate']));
        $task->setCompleted($data['completed']);
        $task->setPriority($data['priority']);

        // Save the task to the database
        $entityManager = $this->entityManager;
        $entityManager->persist($task);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Task created!'], JsonResponse::HTTP_CREATED);
    }

    /**
     * @Route("/task/update/{id}",name="task_update", methods={"PUT"})
     */
    public function update(Request $request, Task $task)
    {
        // Parse JSON data from the request body
        $data = json_decode($request->getContent(), true);

        // Update the task properties
        $task->setTitle($data['title']);
        $task->setDescription($data['description']);
        $task->setDueDate(new \DateTime($data['dueDate']));
        $task->setCompleted($data['completed']);
        $task->setPriority($data['priority']);

        // Save the updated task to the database
        $entityManager = $this->entityManager;
        $entityManager->flush();

        return new JsonResponse(['message' => 'Task updated!']);
    }

     /**
     * @Route("/task/delete/{id}",name="task_delete", methods={"DELETE"})
     */
    public function delete(Task $task)
    {
        // Remove the task from the database
        $entityManager = $this->entityManager;
        $entityManager->remove($task);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Task deleted!']);
    }

    #[Route('/task/create', name: 'task_create')]
    public function addexercices(Request $req, ManagerRegistry $manager): Response
    {
        $Task = new Task();
        $form = $this->createForm(TaskType::class, $Task);
        $form->handleRequest($req);
        if ($form->isSubmitted()) {
            $em = $manager->getManager();
            $em->persist($Task);
            $em->flush();
            return $this->redirectToRoute("app_task");
        }
        return $this->renderForm('task/create.html.twig', [
            'form' => $form
        ]);
    }
    #[Route('/useractivities', name: 'app_user_activities')]
    public function viewactivites(): Response
    {
        return $this->render('user_interface/act.html.twig', [
            'controller_name' => 'UserInterfaceController',
        ]);
    }

   
    
   
}
