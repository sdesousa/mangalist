<?php

namespace App\Entity;

use App\Repository\MangaListingRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * @ORM\Entity(repositoryClass=MangaListingRepository::class)
 * @UniqueEntity(
 *     fields={"manga", "listing"},
 *     message="Série déjà possédé"
 * )
 */
class MangaListing
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\ManyToOne(targetEntity=Manga::class, inversedBy="mangaListings")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?Manga $manga;

    /**
     * @ORM\ManyToOne(targetEntity=Listing::class, inversedBy="mangaListings")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?Listing $listing;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Positive(message="Dois être strictement positif")
     */
    private ?int $possessedVolume;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $remark;


    /**
     * @Assert\Callback
     * @param ExecutionContextInterface $context
     * @param Mixed $payload
     */
    public function validate(ExecutionContextInterface $context, $payload): void
    {
        $manga = $this->getManga();
        if (!is_null($manga) && $this->getPossessedVolume() > $manga->getTotalVolume()) {
            $context->buildViolation('Ne peut pas être supérieur au total de volumes')
                ->atPath('possessedVolume')
                ->addViolation();
        }
    }

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

    /**
     * @return bool
     */
    public function isFinished(): bool
    {
        $manga = $this->getManga();
        return (!is_null($manga) && $this->getPossessedVolume() === $manga->getTotalVolume());
    }
}
