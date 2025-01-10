<?php

namespace App\Entity;

use App\Repository\UploadRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UploadRepository::class)]
class Upload
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $UploadedBy = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $UploadedAt = null;

    #[ORM\Column(length: 255)]
    private ?string $url = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUploadedBy(): ?string
    {
        return $this->UploadedBy;
    }

    public function setUploadedBy(?string $UploadedBy): static
    {
        $this->UploadedBy = $UploadedBy;

        return $this;
    }

    public function getUploadedAt(): ?\DateTimeImmutable
    {
        return $this->UploadedAt;
    }

    public function setUploadedAt(\DateTimeImmutable $UploadedAt): static
    {
        $this->UploadedAt = $UploadedAt;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): static
    {
        $this->url = $url;

        return $this;
    }
}
