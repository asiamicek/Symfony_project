<?php
/**
 * Register controller.
 */

namespace App\Controller;

use App\Entity\Register;
use App\Repository\RegisterRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use \Knp\Component\Pager\PaginatorInterface;

/**
 * Class RegisterController.
 *
 * @Route("/register")
 */
class RegisterController extends AbstractController
{
    /**
     * Index action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request        HTTP request
     * @param \App\Repository\RegisterRepository            $registerRepository Register repository
     * @param \Knp\Component\Pager\PaginatorInterface   $paginator      Paginator
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/",
     *     name="register_index",
     * )
     */
    public function index(Request $request, RegisterRepository $registerRepository, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $registerRepository->findAll(),
            $request->query->getInt('page', 1),
            RegisterRepository::PAGINATOR_ITEMS_PER_PAGE
        );

        return $this->render(
            'register/index.html.twig',
            ['pagination' => $pagination]
        );
    }

    /**
     * Show action.
     *
     * @param \App\Repository\RegisterRepository $repository Register repository
     * @param int                              $id        Register id
     *
     * @Route(
     *     "/{id}",
     *     methods={"GET"},
     *     name="register_show",
     *     requirements={"id": "[1-9]\d*"},
     * )
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     */
    public function show(Register $register): Response
    {
        return $this->render(
            'register/show.html.twig',
            ['register' => $register]
        );
    }
}