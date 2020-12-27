<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User
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
    private $username;

    /**
     * @ORM\Column (type="string", length=255, nullable=true)
     *
     * @var null|string
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity=Book::class, mappedBy="user", orphanRemoval=true)
     */
    private $books;

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
     * @ORM\OneToMany(targetEntity=Note::class, mappedBy="user", orphanRemoval=true)
     */
    private $notes;
}
