<?php

namespace App\Entity;

use App\Repository\MangaListingRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=MangaListingRepository::class)
 */
class MangaListing
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Manga::class, inversedBy="mangaListings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $manga;

    /**
     * @ORM\ManyToOne(targetEntity=Listing::class, inversedBy="mangaListings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $listing;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Positive(message="Dois être positif")
     */
    private $possessedVolume;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $remark;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getListing(): ?Listing
    {
        return $this->listing;
    }

    public function setListing(?Listing $listing): self
    {
        $this->listing = $listing;

        return $this;
    }

    public function getPossessedVolume(): ?int
    {
        return $this->possessedVolume;
    }

    public function setPossessedVolume(int $possessedVolume): self
    {
        $this->possessedVolume = $possessedVolume;

        return $this;
    }

    public function getRemark(): ?string
    {
        return $this->remark;
    }

    public function setRemark(?string $remark): self
    {
        $this->remark = $remark;

        return $this;
    }
}
