<?php // phpcs:disable PSR1.Files.SideEffects.FoundWithSymbols

namespace App\Controller;

use App\Entity\Note;
use App\Entity\Book;
use App\Form\NoteType;
use App\Repository\NoteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/note')]
class NoteController extends AbstractController
{
    /**
     * @param Note $note
     * @return void
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     */
    protected function assertOwnerIsLoggedIn(Note $note)
    {
        if ($note->getUser() !== $this->getLoggedUser()) {
            throw $this->createAccessDeniedException();
        }
    }
    /**
     * Ensures we have a logged in user
     *
     * @return \App\Entity\User
     */
    protected function getLoggedUser(): \App\Entity\User
    {
        $user = $this->getUser();
        if ($user instanceof \App\Entity\User) {
            return $user;
        }
        throw new \LogicException(
            "User should be authenticated at this stage."
        );
    }
    #[Route('/', name: 'note_index', methods: ['GET'])]
    public function index(NoteRepository $noteRepository): Response
    {
        return $this->render('note/index.html.twig', [
            'notes' => $noteRepository->findBy([
                "user" => $this->getLoggedUser()
            ]),
        ]);
    }

    #[Route('/new', name: 'note_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $user = $this->getLoggedUser();
        $note = new Note($user);
        $form = $this->createForm(NoteType::class, $note, [ "user" => $user ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($note);
            $entityManager->flush();

            return $this->redirectToRoute('note_index');
        }

        return $this->render('note/new.html.twig', [
            'note' => $note,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'note_show', methods: ['GET'])]
    public function show(Note $note): Response
    {
        $this->assertOwnerIsLoggedIn($note);
        return $this->render('note/show.html.twig', [
            'note' => $note,
        ]);
    }

    #[Route('/{id}/edit', name: 'note_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Note $note): Response
    {
        $this->assertOwnerIsLoggedIn($note);
        $user = $this->getLoggedUser();
        $form = $this->createForm(NoteType::class, $note, [ "user" => $user ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('note_index');
        }

        return $this->render('note/edit.html.twig', [
            'note' => $note,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'note_delete', methods: ['DELETE'])]
    public function delete(Request $request, Note $note): Response
    {
        $this->assertOwnerIsLoggedIn($note);
        if ($this->isCsrfTokenValid('delete' . $note->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($note);
            $entityManager->flush();
        }

        return $this->redirectToRoute('note_index');
    }
}
