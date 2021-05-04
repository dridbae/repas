<?php

namespace App\Entity;

use App\Repository\AlimentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AlimentRepository::class)
 */
class Aliment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $code;

    /**
     * @ORM\ManyToMany(targetEntity=Repas::class, inversedBy="aliments")
     */
    private $repas;

    /**
     * @ORM\ManyToOne(targetEntity=SousGroupe::class, inversedBy="aliments")
     */
    private $sousGroupe;

    public function __construct()
    {
        $this->repas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): self
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return Collection|Repas[]
     */
    public function getRepas(): Collection
    {
        return $this->repas;
    }

    public function addRepa(Repas $repa): self
    {
        if (!$this->repas->contains($repa)) {
            $this->repas[] = $repa;
        }

        return $this;
    }

    public function removeRepa(Repas $repa): self
    {
        $this->repas->removeElement($repa);

        return $this;
    }

    public function getSousGroupe(): ?SousGroupe
    {
        return $this->sousGroupe;
    }

    public function setSousGroupe(?SousGroupe $sousGroupe): self
    {
        $this->sousGroupe = $sousGroupe;

        return $this;
    }
}
