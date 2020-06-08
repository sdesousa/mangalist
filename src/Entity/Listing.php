<?php

namespace App\Entity;

use App\Repository\ListingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ListingRepository::class)
 */
class Listing
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=MangaListing::class, mappedBy="listing", orphanRemoval=true)
     */
    private $mangaListings;

    public function __construct()
    {
        $this->mangaListings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|MangaListing[]
     */
    public function getMangaListings(): Collection
    {
        return $this->mangaListings;
    }

    public function addMangaListing(MangaListing $mangaListing): self
    {
        if (!$this->mangaListings->contains($mangaListing)) {
            $this->mangaListings[] = $mangaListing;
            $mangaListing->setListing($this);
        }

        return $this;
    }

    public function removeMangaListing(MangaListing $mangaListing): self
    {
        if ($this->mangaListings->contains($mangaListing)) {
            $this->mangaListings->removeElement($mangaListing);
            // set the owning side to null (unless already changed)
            if ($mangaListing->getListing() === $this) {
                $mangaListing->setListing(null);
            }
        }

        return $this;
    }
}
