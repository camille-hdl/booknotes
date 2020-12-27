<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UlidGenerator;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class=UlidGenerator::class)
     */
    protected ?string $id = null;

    /**
     * @ORM\Column (type="string", length=255)
     *
     * @var null|string
     */
    protected $username;

    /**
     * @ORM\Column (type="string", length=255, nullable=true)
     *
     * @var null|string
     */
    protected $password;

    /**
     * @ORM\OneToMany(targetEntity=Book::class, mappedBy="user", orphanRemoval=true)
     */
    protected Collection $books;

    /**
     * @ORM\Column (type="datetime")
     */
    protected \DateTimeInterface $createdOn;

    /**
     * @ORM\Column (type="datetime")
     */
    protected \DateTimeInterface $updatedOn;

    /**
     * @ORM\OneToMany(targetEntity=Note::class, mappedBy="user", orphanRemoval=true)
     */
    protected Collection $notes;

    public function __construct(string $username)
    {
        $this->createdOn = new \DateTimeImmutable();
        $this->updatedOn = new \DateTimeImmutable();
        $this->notes = new ArrayCollection();
        $this->books = new ArrayCollection();
        $this->username = $username;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @return Collection<array-key, Book>
     */
    public function getBooks(): Collection
    {
        return $this->books;
    }

    /**
     * @return Collection<array-key, Note>
     */
    public function getNotes(): Collection
    {
        return $this->notes;
    }

    public function addBook(Book $book): self
    {
        if (!$this->books->contains($book)) {
            $this->books->add($book);
        }
        return $this;
    }

    public function addNote(Note $note): self
    {
        if (!$this->notes->contains($note)) {
            $this->notes->add($note);
        }
        return $this;
    }
}
