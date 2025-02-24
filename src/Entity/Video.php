<?php

namespace App\Entity;

use App\Enum\VideoLevel;
use App\Repository\VideoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity(repositoryClass: VideoRepository::class)]
class Video
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $theme = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\Column(length: 255)]
    private ?string $fichierVideo = null;

    #[ORM\Column(nullable: true)]
    private ?float $noteGlobal = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    /**
     * @var Collection<int, Note>
     */
    #[ORM\OneToMany(targetEntity: Note::class, mappedBy: 'video')]
    private Collection $Note;

    /**
     * @var Collection<int, Commentaire>
     */
    #[ORM\OneToMany(targetEntity: Commentaire::class, mappedBy: 'video')]
    private Collection $Commentaire;

    /**
     * @var Collection<int, Rapport>
     */
    #[ORM\OneToMany(targetEntity: Rapport::class, mappedBy: 'video')]
    private Collection $Rapport;

    #[ORM\ManyToOne(inversedBy: 'Video')]
    private ?Historique $historique = null;

    #[ORM\Column(enumType: VideoLevel::class)]
    private ?VideoLevel $level = null;

    #[ORM\Column(nullable: true)]
    private ?int $view = null;

    /**
     * @var Collection<int, Favoris>
     */
    #[ORM\ManyToMany(targetEntity: Favoris::class, mappedBy: 'videoId')]
    private Collection $favoris;

    /**
     * @var Collection<int, Programme>
     */
    #[ORM\ManyToMany(targetEntity: Programme::class, mappedBy: 'videoId')]
    private Collection $programmes;

    /**
     * @var Collection<int, User>
     */
    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'videoEnregistrer')]
    private Collection $users;

    #[ORM\Column(nullable: true)]
    private ?bool $Recommended = null;

    public function __construct()
    {
        $this->Note = new ArrayCollection();
        $this->Commentaire = new ArrayCollection();
        $this->Rapport = new ArrayCollection();
        $this->favoris = new ArrayCollection();
        $this->programmes = new ArrayCollection();
        $this->users = new ArrayCollection();
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

    public function getTheme(): ?string
    {
        return $this->theme;
    }

    public function setTheme(string $theme): static
    {
        $this->theme = $theme;

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

    public function getFichierVideo(): ?string
    {
        return $this->fichierVideo;
    }

    public function setFichierVideo(string $fichierVideo): static
    {
        $this->fichierVideo = $fichierVideo;

        return $this;
    }

    public function getNoteGlobal(): ?float
    {
        return $this->noteGlobal;
    }

    public function setNoteGlobal(?float $noteGlobal): static
    {
        $this->noteGlobal = $noteGlobal;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<int, Note>
     */
    public function getNote(): Collection
    {
        return $this->Note;
    }

    public function addNote(Note $note): static
    {
        if (!$this->Note->contains($note)) {
            $this->Note->add($note);
            $note->setVideo($this);
        }

        return $this;
    }

    public function removeNote(Note $note): static
    {
        if ($this->Note->removeElement($note)) {
            // set the owning side to null (unless already changed)
            if ($note->getVideo() === $this) {
                $note->setVideo(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Commentaire>
     */
    public function getCommentaire(): Collection
    {
        return $this->Commentaire;
    }

    public function addCommentaire(Commentaire $commentaire): static
    {
        if (!$this->Commentaire->contains($commentaire)) {
            $this->Commentaire->add($commentaire);
            $commentaire->setVideo($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): static
    {
        if ($this->Commentaire->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getVideo() === $this) {
                $commentaire->setVideo(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Rapport>
     */
    public function getRapport(): Collection
    {
        return $this->Rapport;
    }

    public function addRapport(Rapport $rapport): static
    {
        if (!$this->Rapport->contains($rapport)) {
            $this->Rapport->add($rapport);
            $rapport->setVideo($this);
        }

        return $this;
    }

    public function removeRapport(Rapport $rapport): static
    {
        if ($this->Rapport->removeElement($rapport)) {
            // set the owning side to null (unless already changed)
            if ($rapport->getVideo() === $this) {
                $rapport->setVideo(null);
            }
        }

        return $this;
    }

    public function getHistorique(): ?Historique
    {
        return $this->historique;
    }

    public function setHistorique(?Historique $historique): static
    {
        $this->historique = $historique;

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

    public function getView(): ?int
    {
        return $this->view;
    }

    public function setView(?int $view): static
    {
        $this->view = $view;

        return $this;
    }

    /**
     * @return Collection<int, Favoris>
     */
    public function getFavoris(): Collection
    {
        return $this->favoris;
    }

    public function addFavori(Favoris $favori): static
    {
        if (!$this->favoris->contains($favori)) {
            $this->favoris->add($favori);
            $favori->addVideoId($this);
        }

        return $this;
    }

    public function removeFavori(Favoris $favori): static
    {
        if ($this->favoris->removeElement($favori)) {
            $favori->removeVideoId($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Programme>
     */
    public function getProgrammes(): Collection
    {
        return $this->programmes;
    }

    public function addProgramme(Programme $programme): static
    {
        if (!$this->programmes->contains($programme)) {
            $this->programmes->add($programme);
            $programme->addVideoId($this);
        }

        return $this;
    }

    public function removeProgramme(Programme $programme): static
    {
        if ($this->programmes->removeElement($programme)) {
            $programme->removeVideoId($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addVideoEnregistrer($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            $user->removeVideoEnregistrer($this);
        }

        return $this;
    }

    public function isRecommended(): ?bool
    {
        return $this->Recommended;
    }

    public function setRecommended(?bool $Recommended): static
    {
        $this->Recommended = $Recommended;

        return $this;
    }
}
