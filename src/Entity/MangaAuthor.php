<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MangaAuthorRepository")
 */
class MangaAuthor
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\AuthorRole", inversedBy="mangaAuthors")
     * @ORM\JoinColumn(nullable=false)
     */
    private $role;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Manga", inversedBy="mangaAuthors")
     * @ORM\JoinColumn(nullable=false)
     */
    private $manga;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Author", inversedBy="mangaAuthors")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRole(): ?AuthorRole
    {
        return $this->role;
    }

    public function setRole(?AuthorRole $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getManga(): ?Manga
    {
        return $this->manga;
    }

    public function setManga(?Manga $manga): self
    {
        $this->manga = $manga;

        return $this;
    }

    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    public function setAuthor(?Author $author): self
    {
        $this->author = $author;

        return $this;
    }
}
