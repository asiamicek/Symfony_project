<?php
/**
 * Note controller.
 */

namespace App\Controller;

use App\Entity\Note;
use App\Form\NoteType;
use App\Service\NoteService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
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
     * Note service.
     *
     * @var \App\Service\NoteService
     */
    private $noteService;

    /**
     * NoteController constructor.
     *
     * @param \App\Service\NoteService $noteService Note service
     */
    public function __construct(NoteService $noteService)
    {
        $this->noteService = $noteService;
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
     *     name="note_index",
     * )
     */
    public function index(Request $request): Response
    {
        $filters = [];
        $filters['tags_id'] = $request->query->getInt('filters_tags_id');
        $filters['category_id'] = $request->query->getInt('filters_category_id');

        $pagination = $this->noteService->createPaginatedList(
            $request->query->getInt('page', 1),
            $this->getUser(),
            $filters
        );

        return $this->render(
            'note/index.html.twig',
            ['pagination' => $pagination]
        );
    }

    /**
     * Show action.
     *
     * @param \App\Entity\Note $note Note entity
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/{id}",
     *     methods={"GET"},
     *     name="note_show",
     *     requirements={"id": "[1-9]\d*"},
     * )
     */
    public function show(Note $note): Response
    {
        if ($note->getAuthor() !== $this->getUser()) {
            $this->addFlash('warning', 'message_item_not_found');

            return $this->redirectToRoute('note_index');
        }

        return $this->render(
            'note/show.html.twig',
            ['note' => $note]
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
     *     name="note_create",
     * )
     */
    public function create(Request $request): Response
    {
        $note = new Note();
        $form = $this->createForm(NoteType::class, $note);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $note->setAuthor($this->getUser());
            $this->noteService->save($note);
            $this->addFlash('success', 'message_created_successfully');

            return $this->redirectToRoute('note_index');
        }

        return $this->render(
            'note/create.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * Edit action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP request
     * @param \App\Entity\Note                          $note    Note entity
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
     *     name="note_edit",
     * )
     */
    public function edit(Request $request, Note $note): Response
    {
        if ($note->getAuthor() !== $this->getUser()) {
            $this->addFlash('warning', 'message_item_not_found');

            return $this->redirectToRoute('note_index');
        }

        $form = $this->createForm(NoteType::class, $note, ['method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->noteService->save($note);
            $this->addFlash('success', 'message_updated_successfully');

            return $this->redirectToRoute('note_index');
        }

        return $this->render(
            'note/edit.html.twig',
            [
                'form' => $form->createView(),
                'note' => $note,
            ]
        );
    }

    /**
     * Delete action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP request
     * @param \App\Entity\Note                          $note    Note entity
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
     *     name="note_delete",
     * )
     */
    public function delete(Request $request, Note $note): Response
    {
        if ($note->getAuthor() !== $this->getUser()) {
            $this->addFlash('warning', 'message_item_not_found');

            return $this->redirectToRoute('note_index');
        }

        $form = $this->createForm(FormType::class, $note, ['method' => 'DELETE']);
        $form->handleRequest($request);

        if ($request->isMethod('DELETE') && !$form->isSubmitted()) {
            $form->submit($request->request->get($form->getName()));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $this->noteService->delete($note);
            $this->addFlash('success', 'message_deleted_successfully');

            return $this->redirectToRoute('note_index');
        }

        return $this->render(
            'note/delete.html.twig',
            [
                'form' => $form->createView(),
                'note' => $note,
            ]
        );
    }
}
