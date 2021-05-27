<?php
/**
 * Note controller.
 */

namespace App\Controller;

use App\Entity\Note;
use App\Repository\NoteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
     * @param \App\Repository\NoteRepository $noteRepository Note repository
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/",
     *     methods={"GET"},
     *     name="note_index",
     * )
     */
    public function index(NoteRepository $noteRepository): Response
    {
        return $this->render(
            'note/index.html.twig',
            ['notes' => $noteRepository->findAll()]
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