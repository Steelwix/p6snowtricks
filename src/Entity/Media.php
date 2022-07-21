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
