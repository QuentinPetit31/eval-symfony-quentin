<?php

namespace App\Service;

use App\Entity\Task;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;

class TaskService
{
    private TaskRepository $taskRepository;
    private EntityManagerInterface $em;

    public function __construct(TaskRepository $taskRepository, EntityManagerInterface $em)
    {
        $this->taskRepository = $taskRepository;
        $this->em = $em;
    }

    public function addTask(Task $task): void
    {
        try {
            $this->em->persist($task);
            $this->em->flush();
        } catch (\Exception $e) {
            throw new \Exception("Erreur lors de l'ajout de la tâche : " . $e->getMessage());
        }
    }

    public function getAllTasks(): array
    {
        try {
            return $this->taskRepository->findAll();
        } catch (\Exception $e) {
            throw new \Exception("Erreur lors de la récupération des tâches : " . $e->getMessage());
        }
    }
}
