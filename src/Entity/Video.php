<?php

namespace App\Entity;

use App\Repository\VideoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VideoRepository::class)]
class Video
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
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
     * @var Collection<int, User>
     */
    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'videoEnregistrer')]
    private Collection $users;

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

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->Note = new ArrayCollection();
        $this->Commentaire = new ArrayCollection();
        $this->Rapport = new ArrayCollection();
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
}
