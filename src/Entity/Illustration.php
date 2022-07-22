<?php

namespace App\Entity;

use App\Repository\IllustrationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IllustrationRepository::class)]
class Illustration
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\OneToOne(inversedBy: 'illustration', targetEntity: Trick::class, cascade: ['persist'])]
    private $idTrick;

    #[ORM\OneToOne(targetEntity: Media::class, cascade: ['persist', 'remove'])]
    private $idMedia;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdTrick(): ?Trick
    {
        return $this->idTrick;
    }

    public function setIdTrick(?Trick $idTrick): self
    {
        $this->idTrick = $idTrick;

        return $this;
    }

    public function getIdMedia(): ?Media
    {
        return $this->idMedia;
    }

    public function setIdMedia(?Media $idMedia): self
    {
        $this->idMedia = $idMedia;

        return $this;
    }
}
