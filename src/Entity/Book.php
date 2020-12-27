<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BookRepository::class)
 */
class Book
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column (type="string", length=255)
     *
     * @var null|string
     */
    private $title;

    /**
     * @ORM\Column (type="string", length=255, nullable=true)
     *
     * @var null|string
     */
    private $authorName;

    /**
     * @ORM\Column (type="datetime")
     *
     * @var \DateTimeInterface|null
     */
    private $createdOn;

    /**
     * @ORM\Column (type="datetime")
     *
     * @var \DateTimeInterface|null
     */
    private $updatedOn;

    /**
     * @ORM\ManyToOne (targetEntity=User::class, inversedBy="books")
     *
     * @ORM\JoinColumn (nullable=false)
     *
     * @var User|null
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=Note::class, mappedBy="book")
     * @var Note[]
     */
    private $notes;

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
