<?php

namespace App\Entity;

use App\Repository\BrandRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BrandRepository::class)]
class Brand
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
    #[ORM\OneToMany(targetEntity: Pants::class, mappedBy: 'brand')]
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
            $pants->setBrand($this);
        }

        return $this;
    }

    public function removePants(Pants $pants): static
    {
        if ($this->pants->removeElement($pants)) {
            // set the owning side to null (unless already changed)
            if ($pants->getBrand() === $this) {
                $pants->setBrand(null);
            }
        }

        return $this;
    }
}
