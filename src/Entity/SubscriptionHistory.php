<?php

namespace App\Entity;

use App\Repository\SubscriptionHistoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SubscriptionHistoryRepository::class)]
class SubscriptionHistory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $startDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $endDate = null;

    /**
     * @var Collection<int, Abonnement>
     */
    #[ORM\ManyToMany(targetEntity: Abonnement::class, inversedBy: 'subscriptionHistories')]
    private Collection $subscriptionId;

    #[ORM\ManyToOne(inversedBy: 'subscriptionHistory')]
    private ?User $user = null;

    public function __construct()
    {
        $this->subscriptionId = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(?\DateTimeInterface $startDate): static
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTimeInterface $endDate): static
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * @return Collection<int, Abonnement>
     */
    public function getSubscriptionId(): Collection
    {
        return $this->subscriptionId;
    }

    public function addSubscriptionId(Abonnement $subscriptionId): static
    {
        if (!$this->subscriptionId->contains($subscriptionId)) {
            $this->subscriptionId->add($subscriptionId);
        }

        return $this;
    }

    public function removeSubscriptionId(Abonnement $subscriptionId): static
    {
        $this->subscriptionId->removeElement($subscriptionId);

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
