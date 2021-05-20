<?php
/**
 * Tasks controller.
 */

namespace App\Controller;

use App\Entity\Task;
use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TasksController.
 *
 * @Route("/tasks")
 */
class TaskController extends AbstractController
{
    /**
     * Index action.
     *
     * @param \App\Repository\TaskRepository $taskRepository Tasks repository
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/",
     *     methods={"GET"},
     *     name="tasks_index",
     * )
     */
    public function index(TaskRepository $taskRepository): Response
    {
        return $this->render(
            'tasks/index.html.twig',
            ['tasks' => $taskRepository->findAll()]
        );
    }

    /**
     * Show action.
     *
     * @param \App\Repository\TaskRepository $repository Tasks repository
     * @param int                              $id        Tasks id
     *
     * @Route(
     *     "/{id}",
     *     methods={"GET"},
     *     name="tasks_show",
     *     requirements={"id": "[1-9]\d*"},
     * )
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     */
    public function show(TaskRepository $repository, int $id): Response
    {
        return $this->render(
            'tasks/show.html.twig',
            ['task' => $repository->findById($id)]
        );
    }
}