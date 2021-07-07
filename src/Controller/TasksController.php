<?php
namespace App\Controller;

use App\Entity\Task;
use App\Form\Type\TaskType;
use App\Repository\TaskRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class TasksController extends AbstractController
{

    /**
     * @var TaskRepository
     */
    private $repository;

    public function __construct(SessionInterface $session)
    {
        $this->repository = new TaskRepository($session);
    }

    /**
     * @Route("/", name="tasks_index")
     */
    public function index(Session $session)
    {
        // debug
        // $session->set('tasks',[]);

        $tasks = $this->repository->findAll();

        return $this->render('tasks/index.html.twig', [
            'tasks' => $tasks
        ]);
    }

    /**
     * @Route("tasks/new", methods={"GET","HEAD", "POST"}, name="tasks_new")
     */
    public function new(Request $request): Response
    {
        $task = new Task;
        // $task->setContent('first blog');
        $task->setDueDate(new \DateTime());

        $form = $this->createForm(TaskType::class, $task, [
            'method' => 'POST'
        ]);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();

            $this->repository->create($task);

            return $this->redirectToRoute('tasks_index');
        }


        return $this->render('tasks/new.html.twig', [
            'form' => $form->createView()
        ]);
    }



}