<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UlidGenerator;

/**
 * @ORM\Entity(repositoryClass=BookRepository::class)
 */
class Book
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class=UlidGenerator::class)
     */
    protected ?string $id;

    /**
     * @ORM\Column (type="string", length=255)
     */
    protected ?string $title = "";

    /**
     * @ORM\Column (type="string", length=255, nullable=true)
     */
    protected ?string $authorName;

    /**
     * @ORM\Column (type="datetime")
     */
    protected \DateTimeInterface $createdOn;

    /**
     * @ORM\Column (type="datetime")
     */
    protected \DateTimeInterface $updatedOn;

    /**
     * @ORM\ManyToOne (targetEntity=User::class, inversedBy="books")
     *
     * @ORM\JoinColumn (nullable=false)
     */
    protected User $user;

    /**
     * @ORM\OneToMany(targetEntity=Note::class, mappedBy="book")
     */
    protected Collection $notes;

    public function __construct(User $user)
    {
        $this->user = $user;
        $user->addBook($this);
        $this->notes = new ArrayCollection();
        $this->createdOn = new \DateTimeImmutable();
        $this->updatedOn = new \DateTimeImmutable();
    }

    public function getId(): string
    {
        return $this->id ?? "";
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getAuthorName(): ?string
    {
        return $this->authorName;
    }

    public function setAuthorName(?string $authorName): self
    {
        $this->authorName = $authorName;
        return $this;
    }

    public function getTitle(): string
    {
        return $this->title ?? "";
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @return Collection<array-key, Note>
     */
    public function getNotes(): Collection
    {
        return $this->notes;
    }

    public function addNote(Note $note): self
    {
        if (!$this->notes->contains($note)) {
            $this->notes->add($note);
            $note->setBook($this);
        }
        return $this;
    }

    public function getCreatedOn(): \DateTimeInterface
    {
        return $this->createdOn;
    }
    public function getUpdatedOn(): \DateTimeInterface
    {
        return $this->updatedOn;
    }
}
