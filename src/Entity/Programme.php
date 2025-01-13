<?php

namespace App\Entity;

use App\Enum\ProgrammeTheme;
use App\Enum\VideoLevel;
use App\Repository\ProgrammeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProgrammeRepository::class)]
class Programme
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(enumType: VideoLevel::class)]
    private ?VideoLevel $level = null;

    /**
     * @var Collection<int, Video>
     */
    #[ORM\ManyToMany(targetEntity: Video::class, inversedBy: 'programmes')]
    private Collection $videoId;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\Column(nullable: true, enumType: ProgrammeTheme::class)]
    private ?ProgrammeTheme $Theme = null;

    public function __construct()
    {
        $this->videoId = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getLevel(): ?VideoLevel
    {
        return $this->level;
    }

    public function setLevel(VideoLevel $level): static
    {
        $this->level = $level;

        return $this;
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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getTheme(): ?ProgrammeTheme
    {
        return $this->Theme;
    }

    public function setTheme(?ProgrammeTheme $Theme): static
    {
        $this->Theme = $Theme;

        return $this;
    }
}
