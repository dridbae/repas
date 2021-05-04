<?php

namespace App\Entity;

use App\Repository\GroupeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GroupeRepository::class)
 */
class Groupe
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
     * @ORM\OneToMany(targetEntity=SousGroupe::class, mappedBy="groupe")
     */
    private $sousGroupes;

    public function __construct()
    {
        $this->sousGroupes = new ArrayCollection();
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
     * @return Collection|SousGroupe[]
     */
    public function getSousGroupes(): Collection
    {
        return $this->sousGroupes;
    }

    public function addSousGroupe(SousGroupe $sousGroupe): self
    {
        if (!$this->sousGroupes->contains($sousGroupe)) {
            $this->sousGroupes[] = $sousGroupe;
            $sousGroupe->setGroupe($this);
        }

        return $this;
    }

    public function removeSousGroupe(SousGroupe $sousGroupe): self
    {
        if ($this->sousGroupes->removeElement($sousGroupe)) {
            // set the owning side to null (unless already changed)
            if ($sousGroupe->getGroupe() === $this) {
                $sousGroupe->setGroupe(null);
            }
        }

        return $this;
    }
}
