<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MangaRepository")
 */
class Manga
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Titre obligatoire")
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Titre trop long, il doit être au plus {{ limit }} caractères"
     * )
     */
    private $title;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Positive(message="Dois être positif")
     */
    private $totalVolume;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\PositiveOrZero(message="Dois être positif")
     */
    private $availableVolume;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\GreaterThanOrEqual(
     *     value="1900",
     *     message="Année invalide"
     * )
     */
    private $year;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Editor", inversedBy="mangas")
     * @ORM\JoinColumn(nullable=false)
     */
    private $editor;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\EditorCollection", inversedBy="mangas")
     */
    private $editorCollection;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getTotalVolume(): ?int
    {
        return $this->totalVolume;
    }

    public function setTotalVolume(?int $totalVolume): self
    {
        $this->totalVolume = $totalVolume;

        return $this;
    }

    public function getAvailableVolume(): ?int
    {
        return $this->availableVolume;
    }

    public function setAvailableVolume(?int $availableVolume): self
    {
        $this->availableVolume = $availableVolume;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(?int $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getEditor(): ?Editor
    {
        return $this->editor;
    }

    public function setEditor(?Editor $editor): self
    {
        $this->editor = $editor;

        return $this;
    }

    public function getEditorCollection(): ?EditorCollection
    {
        return $this->editorCollection;
    }

    public function setEditorCollection(?EditorCollection $editorCollection): self
    {
        $this->editorCollection = $editorCollection;

        return $this;
    }
}
