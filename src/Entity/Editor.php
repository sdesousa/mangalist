<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EditorRepository")
 * @UniqueEntity(
 *     fields={"name"}
 *     message="Editeur déjà présent"
 * )
 */
class Editor
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
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Manga", mappedBy="editor")
     */
    private $mangas;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\EditorCollection", mappedBy="editor", orphanRemoval=true)
     */
    private $editorCollections;

    public function __construct()
    {
        $this->mangas = new ArrayCollection();
        $this->editorCollections = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Manga[]
     */
    public function getMangas(): Collection
    {
        return $this->mangas;
    }

    public function addManga(Manga $manga): self
    {
        if (!$this->mangas->contains($manga)) {
            $this->mangas[] = $manga;
            $manga->setEditor($this);
        }

        return $this;
    }

    public function removeManga(Manga $manga): self
    {
        if ($this->mangas->contains($manga)) {
            $this->mangas->removeElement($manga);
            // set the owning side to null (unless already changed)
            if ($manga->getEditor() === $this) {
                $manga->setEditor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|EditorCollection[]
     */
    public function getEditorCollections(): Collection
    {
        return $this->editorCollections;
    }

    public function addEditorCollection(EditorCollection $editorCollection): self
    {
        if (!$this->editorCollections->contains($editorCollection)) {
            $this->editorCollections[] = $editorCollection;
            $editorCollection->setEditor($this);
        }

        return $this;
    }

    public function removeEditorCollection(EditorCollection $editorCollection): self
    {
        if ($this->editorCollections->contains($editorCollection)) {
            $this->editorCollections->removeElement($editorCollection);
            // set the owning side to null (unless already changed)
            if ($editorCollection->getEditor() === $this) {
                $editorCollection->setEditor(null);
            }
        }

        return $this;
    }
}
