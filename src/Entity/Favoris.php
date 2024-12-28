<?php

namespace App\Entity;

use App\Repository\FavorisRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FavorisRepository::class)]
class Favoris
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, Video>
     */
    #[ORM\ManyToMany(targetEntity: Video::class, inversedBy: 'favoris')]
    private Collection $videoId;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $addedAt = null;

    #[ORM\ManyToOne(inversedBy: 'favoris')]
    private ?User $user = null;

    public function __construct()
    {
        $this->videoId = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Video>
     */
    public function getVideoId(): Collection
    {
        return $this->videoId;
    }

    public function addVideoId(Video $videoId): static
    {
        if (!$this->videoId->contains($videoId)) {
            $this->videoId->add($videoId);
        }

        return $this;
    }

    public function removeVideoId(Video $videoId): static
    {
        $this->videoId->removeElement($videoId);

        return $this;
    }

    public function getAddedAt(): ?\DateTimeInterface
    {
        return $this->addedAt;
    }

    public function setAddedAt(\DateTimeInterface $addedAt): static
    {
        $this->addedAt = $addedAt;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}
