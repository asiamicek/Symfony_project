<?php
/**
 * Note controller.
 */

namespace App\Controller;

use App\Entity\Note;
use App\Repository\NoteRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use \Knp\Component\Pager\PaginatorInterface;

/**
 * Class NoteController.
 *
 * @Route("/note")
 */
class NoteController extends AbstractController
{
    /**
     * Index action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request        HTTP request
     * @param \App\Repository\NoteRepository            $noteRepository Note repository
     * @param \Knp\Component\Pager\PaginatorInterface   $paginator      Paginator
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/",
     *     name="note_index",
     * )
     */
    public function index(Request $request, NoteRepository $noteRepository, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $noteRepository->queryAll(),
            $request->query->getInt('page', 1),
            NoteRepository::PAGINATOR_ITEMS_PER_PAGE
        );

        return $this->render(
            'note/index.html.twig',
            ['pagination' => $pagination]
        );
    }

    /**
     * Show action.
     *
     * @param \App\Repository\NoteRepository $repository Note repository
     * @param int                              $id        Note id
     *
     * @Route(
     *     "/{id}",
     *     methods={"GET"},
     *     name="note_show",
     *     requirements={"id": "[1-9]\d*"},
     * )
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     */
    public function show(Note $note): Response
    {
        return $this->render(
            'note/show.html.twig',
            ['note' => $note]
        );
    }
}