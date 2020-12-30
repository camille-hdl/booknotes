<?php // phpcs:disable PSR1.Files.SideEffects.FoundWithSymbols

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/book')]
class BookController extends AbstractController
{
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
    #[Route('/', name: 'book_index', methods: ['GET'])]
    public function index(BookRepository $bookRepository): Response
    {
        $user = $this->getLoggedUser();
        return $this->render('book/index.html.twig', [
            'books' => $bookRepository->findBy([ "user" => $user ]),
        ]);
    }

    #[Route('/new', name: 'book_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $book = new Book($this->getLoggedUser());
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($book);
            $entityManager->flush();

            return $this->redirectToRoute('book_index');
        }

        return $this->render('book/new.html.twig', [
            'book' => $book,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'book_show', methods: ['GET'])]
    public function show(Book $book): Response
    {
        $this->assertOwnerIsLoggedIn($book);
        return $this->render('book/show.html.twig', [
            'book' => $book,
        ]);
    }

    #[Route('/{id}/edit', name: 'book_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Book $book): Response
    {
        $this->assertOwnerIsLoggedIn($book);
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('book_index');
        }

        return $this->render('book/edit.html.twig', [
            'book' => $book,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'book_delete', methods: ['DELETE', 'POST'])]
    public function delete(Request $request, Book $book): Response
    {
        $this->assertOwnerIsLoggedIn($book);
        if ($this->isCsrfTokenValid('delete' . $book->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($book);
            $entityManager->flush();
        }

        return $this->redirectToRoute('book_index');
    }

    /**
     * @param Book $book
     * @return void
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     */
    protected function assertOwnerIsLoggedIn(Book $book)
    {
        if ($book->getUser() !== $this->getLoggedUser()) {
            throw $this->createAccessDeniedException();
        }
    }
}
