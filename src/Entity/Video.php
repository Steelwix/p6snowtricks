<?php

namespace App\Entity;

use App\Repository\VideoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VideoRepository::class)]
class Video
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $link;

    #[ORM\ManyToOne(targetEntity: Trick::class, inversedBy: 'videos')]
    #[ORM\JoinColumn(nullable: false)]
    private $idTrick;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): self
    {
        $this->link = $link;

        return $this;
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
}
