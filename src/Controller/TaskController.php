<?php
/**
 * Task controller.
 */

namespace App\Controller;

use App\Entity\Task;
use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TaskController.
 *
 * @Route("/task")
 */
class TaskController extends AbstractController
{
    /**
     * Index action.
     *
     * @param \App\Repository\TaskRepository $taskRepository Task repository
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/",
     *     methods={"GET"},
     *     name="task_index",
     * )
     */
    public function index(TaskRepository $taskRepository): Response
    {
        return $this->render(
            'task/index.html.twig',
            ['tasks' => $taskRepository->findAll()]
        );
    }

    /**
     * Show action.
     *
     * @param \App\Repository\TaskRepository $repository Task repository
     * @param int                              $id        Task id
     *
     * @Route(
     *     "/{id}",
     *     methods={"GET"},
     *     name="task_show",
     *     requirements={"id": "[1-9]\d*"},
     * )
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     */
    public function show(TaskRepository $repository, int $id): Response
    {
        return $this->render(
            'task/show.html.twig',
            ['task' => $repository->findById($id)]
        );
    }
}