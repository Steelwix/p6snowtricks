<?php

namespace App\Entity;

use App\Repository\MediaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MediaRepository::class)]
class Media
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 80)]
    private $mediaName;

    #[ORM\Column(type: 'string', length: 255)]
    private $mediaLink;

    #[ORM\Column(type: 'boolean')]
    private $is_video;

    #[ORM\ManyToOne(targetEntity: trick::class, inversedBy: 'media')]
    #[ORM\JoinColumn(nullable: false)]
    private $idTrick;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMediaName(): ?string
    {
        return $this->mediaName;
    }

    public function setMediaName(string $mediaName): self
    {
        $this->mediaName = $mediaName;

        return $this;
    }

    public function getMediaLink(): ?string
    {
        return $this->mediaLink;
    }

    public function setMediaLink(string $mediaLink): self
    {
        $this->mediaLink = $mediaLink;

        return $this;
    }

    public function isIsVideo(): ?bool
    {
        return $this->is_video;
    }

    public function setIsVideo(bool $is_video): self
    {
        $this->is_video = $is_video;

        return $this;
    }

    public function getIdTrick(): ?trick
    {
        return $this->idTrick;
    }

    public function setIdTrick(?trick $idTrick): self
    {
        $this->idTrick = $idTrick;

        return $this;
    }
}
