<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Service\TaskService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends AbstractController
{
    #[Route('/formulaire', name: 'task_form')]
    public function add(Request $request, TaskService $taskService): Response
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $taskService->addTask($task);
                $this->addFlash('success', 'Tâche ajoutée avec succès !');
                return $this->redirectToRoute('task_list');
            } catch (\Exception $e) {
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('task/formulaire.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/liste', name: 'task_list')]
    public function list(TaskService $taskService): Response
    {
        try {
            $tasks = $taskService->getAllTasks();
        } catch (\Exception $e) {
            $this->addFlash('error', $e->getMessage());
            $tasks = [];
        }

        return $this->render('task/liste.html.twig', [
            'tasks' => $tasks,
        ]);
    }
}
