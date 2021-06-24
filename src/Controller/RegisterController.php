<?php
/**
 * Register controller.
 */

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Register;
use App\Form\RegisterType;
use App\Service\RegisterService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class RegisterController.
 *
 * @Route("/register")
 */
class RegisterController extends AbstractController
{
    /**
     * Register service.
     *
     * @var \App\Service\RegisterService
     */
    private $registerService;

    /**
     * RegisterController constructor.
     *
     * @param \App\Service\RegisterService $registerService Register service
     */
    public function __construct(RegisterService $registerService)
    {
        $this->registerService = $registerService;
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
     *     name="register_index",
     * )
     */
    public function index(Request $request): Response
    {
        $filters = [];
        $filters['category_id'] = $request->query->getInt('filters_category_id');

        $pagination = $this->registerService->createPaginatedList(
            $request->query->getInt('page', 1),
            $this->getUser(),
            $filters
        );

        return $this->render(
            'register/index.html.twig',
            ['pagination' => $pagination]
        );
    }

    /**
     * Show action.
     *
     * @param \App\Entity\Register $register Register entity
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/{id}",
     *     methods={"GET"},
     *     name="register_show",
     *     requirements={"id": "[1-9]\d*"},
     * )
     */
    public function show(Register $register): Response
    {
        if ($register->getAuthor() !== $this->getUser()) {
            $this->addFlash('warning', 'message_item_not_found');

            return $this->redirectToRoute('register_index');
        }

        return $this->render(
            'register/show',
            ['register' => $register]
        );
    }

    /**
     * Create action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP request
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/create",
     *     methods={"GET", "POST"},
     *     name="register_create",
     * )
     */
    public function create(Request $request): Response
    {
        $register = new Register();
        $form = $this->createForm(RegisterType::class, $register);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $register->setAuthor($this->getUser());
            $this->registerService->save($register);
            $this->addFlash('success', 'message_created_successfully');

            return $this->redirectToRoute('register_index');
        }

        return $this->render(
            'register/create.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * Edit action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request  HTTP request
     * @param \App\Entity\Register                      $register Register entity
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
     *     name="register_edit",
     * )
     */
    public function edit(Request $request, Register $register): Response
    {
        if ($register->getAuthor() !== $this->getUser()) {
            $this->addFlash('warning', 'message_item_not_found');

            return $this->redirectToRoute('register_index');
        }
        $form = $this->createForm(RegisterType::class, $register, ['method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->registerService->save($register);
            $this->addFlash('success', 'message_updated_successfully');

            return $this->redirectToRoute('register_index');
        }

        return $this->render(
            'register/edit.html.twig',
            [
                'form' => $form->createView(),
                'register' => $register,
            ]
        );
    }

    /**
     * Delete action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request  HTTP request
     * @param \App\Entity\Register                      $register Register entity
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
     *     name="register_delete",
     * )
     */
    public function delete(Request $request, Register $register): Response
    {
        if ($register->getAuthor() !== $this->getUser()) {
            $this->addFlash('warning', 'message_item_not_found');

            return $this->redirectToRoute('register_index');
        }
        if ($register->getTasks()->count()) {
            $this->addFlash('warning', 'message_register_contains_tasks');

            return $this->redirectToRoute('category_index');
        }

        $form = $this->createForm(FormType::class, $register, ['method' => 'DELETE']);
        $form->handleRequest($request);

        if ($request->isMethod('DELETE') && !$form->isSubmitted()) {
            $form->submit($request->request->get($form->getName()));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $this->registerService->delete($register);
            $this->addFlash('success', 'message_deleted_successfully');

            return $this->redirectToRoute('register_index');
        }

        return $this->render(
            'register/delete.html.twig',
            [
                'form' => $form->createView(),
                'register' => $register,
            ]
        );
    }
}
