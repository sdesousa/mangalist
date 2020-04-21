<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AuthorRepository")
 */
class Author
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="Prénom obligatoire")
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Prénom trop long, il doit être au plus {{ limit }} caractères"
     * )
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="Nom obligatoire")
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Nom trop long, il doit être au plus {{ limit }} caractères"
     * )
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="Pseudo obligatoire")
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Pseudo trop long, il doit être au plus {{ limit }} caractères"
     * )
     */
    private $penname;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MangaAuthor", mappedBy="author")
     */
    private $mangaAuthors;

    public function __construct()
    {
        $this->mangaAuthors = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getPenname(): ?string
    {
        return $this->penname;
    }

    public function setPenname(?string $penname): self
    {
        $this->penname = $penname;

        return $this;
    }

    /**
     * @return Collection|MangaAuthor[]
     */
    public function getMangaAuthors(): Collection
    {
        return $this->mangaAuthors;
    }

    public function addMangaAuthor(MangaAuthor $mangaAuthor): self
    {
        if (!$this->mangaAuthors->contains($mangaAuthor)) {
            $this->mangaAuthors[] = $mangaAuthor;
            $mangaAuthor->setAuthor($this);
        }

        return $this;
    }

    public function removeMangaAuthor(MangaAuthor $mangaAuthor): self
    {
        if ($this->mangaAuthors->contains($mangaAuthor)) {
            $this->mangaAuthors->removeElement($mangaAuthor);
            // set the owning side to null (unless already changed)
            if ($mangaAuthor->getAuthor() === $this) {
                $mangaAuthor->setAuthor(null);
            }
        }

        return $this;
    }
}
