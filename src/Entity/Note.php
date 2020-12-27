<?php

namespace App\Entity;

use App\Repository\NoteRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UlidGenerator;

/**
 * @ORM\Entity(repositoryClass=NoteRepository::class)
 */
class Note
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class=UlidGenerator::class)
     */
    protected ?string $id;

    /**
     * @ORM\Column (type="text", nullable=true)
     */
    protected ?string $content;

    /**
     * @ORM\ManyToOne (targetEntity=Book::class, inversedBy="notes")
     */
    protected ?Book $book;

    /**
     * @ORM\Column (type="datetime")
     */
    protected \DateTimeInterface $createdOn;

    /**
     * @ORM\Column (type="datetime")
     */
    protected \DateTimeInterface $updatedOn;

    /**
     * @ORM\ManyToOne (targetEntity=User::class, inversedBy="notes")
     *
     * @ORM\JoinColumn (nullable=false)
     *
     * @var User
     */
    protected User $user;

    public function __construct(User $user, ?Book $book)
    {
        $this->user = $user;
        $this->book = $book;
        $user->addNote($this);
        $this->createdOn = new \DateTimeImmutable();
        $this->updatedOn = new \DateTimeImmutable();
    }

    public function getBook(): ?Book
    {
        return $this->book;
    }

    public function setBook(?Book $book): self
    {
        if ($book && $book->getUser() !== $this->getUser()) {
            throw new \DomainException(
                "Note attached to another user's book"
            );
            $book->addNote($this);
        }

        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
