<?php

namespace App\Entity;

use App\Repository\TrickGroupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TrickGroupRepository::class)]
class TrickGroup
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 100)]
    private $trickGroupName;

    #[ORM\OneToMany(mappedBy: 'TrickGroup', targetEntity: Trick::class)]
    private $tricks;

    public function __construct()
    {
        $this->tricks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTrickGroupName(): ?string
    {
        return $this->trickGroupName;
    }

    public function setTrickGroupName(string $trickGroupName): self
    {
        $this->trickGroupName = $trickGroupName;

        return $this;
    }

    /**
     * @return Collection<int, Trick>
     */
    public function getTricks(): Collection
    {
        return $this->tricks;
    }

    public function addTrick(Trick $trick): self
    {
        if (!$this->tricks->contains($trick)) {
            $this->tricks[] = $trick;
            $trick->setTrickGroup($this);
        }

        return $this;
    }

    public function removeTrick(Trick $trick): self
    {
        if ($this->tricks->removeElement($trick)) {
            // set the owning side to null (unless already changed)
            if ($trick->getTrickGroup() === $this) {
                $trick->setTrickGroup(null);
            }
        }

        return $this;
    }
}
