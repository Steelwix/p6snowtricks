<?php

namespace App\Entity;

use App\Repository\TrickRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: TrickRepository::class)]
class Trick
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 100)]
    private $trickName;

    #[ORM\Column(type: 'string', length: 2000)]
    private $description;

    #[ORM\ManyToOne(targetEntity: TrickGroup::class, inversedBy: 'tricks')]
    #[ORM\JoinColumn(nullable: false)]
    private $trickGroup;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'tricks')]
    #[ORM\JoinColumn(nullable: false)]
    private $author;

    #[ORM\OneToMany(mappedBy: 'idTrick', targetEntity: Media::class, orphanRemoval: true, cascade: ['persist', 'remove'])]
    private $media;

    #[ORM\OneToMany(mappedBy: 'idTrick', targetEntity: Message::class, orphanRemoval: true, cascade: ['persist', 'remove'])]
    private $messages;

    #[ORM\Column(type: 'string', length: 100)]
    private $slug;

    #[ORM\OneToOne(mappedBy: 'idTrick', targetEntity: Illustration::class, cascade: ['persist', 'remove'])]
    private $illustration;

    #[ORM\OneToMany(mappedBy: 'idTrick', targetEntity: Video::class, orphanRemoval: true, cascade: ['persist', 'remove'])]
    private $videos;

    public function __construct()
    {
        $this->media = new ArrayCollection();
        $this->messages = new ArrayCollection();
        $this->videos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTrickName(): ?string
    {
        return $this->trickName;
    }

    public function setTrickName(string $trickName): self
    {
        $this->trickName = $trickName;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getTrickGroup(): ?TrickGroup
    {
        return $this->trickGroup;
    }

    public function setTrickGroup(?TrickGroup $trickGroup): self
    {
        $this->trickGroup = $trickGroup;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return Collection<int, Media>
     */
    public function getMedia(): Collection
    {
        return $this->media;
    }

    public function addMedium(Media $medium): self
    {
        if (!$this->media->contains($medium)) {
            $this->media[] = $medium;
            $medium->setIdTrick($this);
        }

        return $this;
    }

    public function removeMedium(Media $medium): self
    {
        if ($this->media->removeElement($medium)) {
            // set the owning side to null (unless already changed)
            if ($medium->getIdTrick() === $this) {
                $medium->setIdTrick(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Message>
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setIdTrick($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getIdTrick() === $this) {
                $message->setIdTrick(null);
            }
        }

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getIllustration(): ?Illustration
    {
        return $this->illustration;
    }

    public function setIllustration(?Illustration $illustration): self
    {
        // unset the owning side of the relation if necessary
        if ($illustration === null && $this->illustration !== null) {
            $this->illustration->setIdTrick(null);
        }

        // set the owning side of the relation if necessary
        if ($illustration !== null && $illustration->getIdTrick() !== $this) {
            $illustration->setIdTrick($this);
        }

        $this->illustration = $illustration;

        return $this;
    }

    /**
     * @return Collection<int, Video>
     */
    public function getVideos(): Collection
    {
        return $this->videos;
    }

    public function addVideo(Video $video): self
    {
        if (!$this->videos->contains($video)) {
            $this->videos[] = $video;
            $video->setIdTrick($this);
        }

        return $this;
    }

    public function removeVideo(Video $video): self
    {
        if ($this->videos->removeElement($video)) {
            // set the owning side to null (unless already changed)
            if ($video->getIdTrick() === $this) {
                $video->setIdTrick(null);
            }
        }

        return $this;
    }
}
