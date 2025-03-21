<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $label = null;

    /**
     * @var Collection<int, Pants>
     */
    #[ORM\ManyToMany(targetEntity: Pants::class, mappedBy: 'categories')]
    private Collection $pants;

    public function __construct()
    {
        $this->pants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return Collection<int, Pants>
     */
    public function getPants(): Collection
    {
        return $this->pants;
    }

    public function addPants(Pants $pants): static
    {
        if (!$this->pants->contains($pants)) {
            $this->pants->add($pants);
            $pants->addCategory($this);
        }

        return $this;
    }

    public function removePants(Pants $pants): static
    {
        if ($this->pants->removeElement($pants)) {
            $pants->removeCategory($this);
        }

        return $this;
    }
}
