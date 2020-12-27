<?php

namespace App\Entity;

use App\Repository\NoteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NoteRepository::class)
 */
class Note
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column (type="text", nullable=true)
     *
     * @var null|string
     */
    private ?string $content;

    /**
     * @ORM\ManyToOne (targetEntity=Book::class, inversedBy="notes")
     *
     * @var Book|null
     */
    private ?Book $book;

    /**
     * @ORM\Column (type="datetime")
     *
     * @var \DateTimeInterface
     */
    private \DateTimeInterface $createdOn;

    /**
     * @ORM\Column (type="datetime")
     *
     * @var \DateTimeInterface
     */
    private \DateTimeInterface $updatedOn;

    /**
     * @ORM\ManyToOne (targetEntity=User::class, inversedBy="notes")
     *
     * @ORM\JoinColumn (nullable=false)
     *
     * @var User|null
     */
    private ?User $user;

    public function getBook(): ?Book
    {
        return $this->book;
    }

    public function setBook(?Book $book): self
    {
        $this->book = $book;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
