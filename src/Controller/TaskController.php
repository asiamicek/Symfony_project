<?php
/**
 * Task controller.
 */

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Service\TaskService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
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
     * Task service.
     *
     * @var \App\Service\TaskService
     */
    private $taskService;

    /**
     * TaskController constructor.
     *
     * @param \App\Service\TaskService $taskService Task service
     */
    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    /**
     * Index action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP request
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/",
     *     methods={"GET"},
     *     name="task_index",
     * )
     */
    public function index(Request $request): Response
    {
        $filters = [];
        $filters['register_id'] = $request->query->getInt('filters_register_id');

        $pagination = $this->taskService->createPaginatedList(
            $request->query->getInt('page', 1),
            $this->getUser(),
            $filters
        );
//        if($filters->count()<0){
//            $this->addFlash('warning', 'message_item_not_found');
//
//            return $this->redirectToRoute('register_index');
//        }

        return $this->render(
            'task/index.html.twig',
            ['pagination' => $pagination]
        );
    }

    /**
     * Show action.
     *
     * @param \App\Entity\Task $task Task entity
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/{id}",
     *     methods={"GET"},
     *     name="task_show",
     *     requirements={"id": "[1-9]\d*"},
     * )
     */
    public function show(Task $task): Response
    {
        if ($task->getRegister()->getAuthor()->getId() !== $this->getUser()->getId()) {
            $this->addFlash('warning', 'message_item_not_found');

            return $this->redirectToRoute('register_index');
        }

        return $this->render(
            'task/show.html.twig',
            ['task' => $task]
        );
    }

    /**
     * Create action.
     *
     * @param \Symfony\Component\HttpFoundation\Request           $request HTTP request
     * @param \Symfony\Component\Security\Core\User\UserInterface $user
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Symfony\Component\Form\Exception\LogicException
     * @Route(
     *     "/create",
     *     methods={"GET", "POST"},
     *
     *     name="task_create",
     * )
     */
    public function create(Request $request): Response
    {
//        $form = $this->createForm(TaskType::class, $task, ['method' => 'PUT']);
//        $form->handleRequest($request);

        $task = new Task();
        $form = $this->createForm(TaskType::class, $task, ['method' => 'POST']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->taskService->save($task);
            $this->addFlash('success', 'message_created_successfully');

            return $this->redirectToRoute('register_index');
        }

        return $this->render(
            'task/create.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * Edit action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP request
     * @param \App\Entity\Task                          $task    Task entity
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/{id}/edit",
     *     methods={"GET", "PUT"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="task_edit",
     * )
     */
    public function edit(Request $request, Task $task): Response
    {
        if ($task->getRegister()->getAuthor()->getId() !== $this->getUser()->getId()) {
            $this->addFlash('warning', 'message_item_not_found');

            return $this->redirectToRoute('task_index');
        }
        $form = $this->createForm(TaskType::class, $task, ['method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->taskService->save($task);
            $this->addFlash('success', 'message_updated_successfully');

            return $this->redirectToRoute('register_index');
        }

        return $this->render(
            'task/edit.html.twig',
            [
                'form' => $form->createView(),
                'task' => $task,
            ]
        );
    }

    /**
     * Delete action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP request
     * @param \App\Entity\Task                          $task    Task entity
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/{id}/delete",
     *     methods={"GET", "DELETE"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="task_delete",
     * )
     */
    public function delete(Request $request, Task $task): Response
    {
        if ($task->getRegister()->getAuthor()->getId() !== $this->getUser()->getId()) {
            $this->addFlash('warning', 'message_item_not_found');

            return $this->redirectToRoute('task_index');
        }
        $form = $this->createForm(FormType::class, $task, ['method' => 'DELETE']);
        $form->handleRequest($request);

        if ($request->isMethod('DELETE') && !$form->isSubmitted()) {
            $form->submit($request->request->get($form->getName()));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $this->taskService->delete($task);
            $this->addFlash('success', 'message_deleted_successfully');

            return $this->redirectToRoute('task_index');
        }

        return $this->render(
            'task/delete.html.twig',
            [
                'form' => $form->createView(),
                'task' => $task,
            ]
        );
    }
}
