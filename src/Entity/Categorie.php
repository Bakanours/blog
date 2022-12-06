<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

//nomCategorie=articles=lien avec la table article et non le nom de la cat en string, nom mal choisit, nomCategorie devrait s'appeler articles

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'categorie', targetEntity: Article::class)]
    private Collection $nomCategorie;

    #[ORM\Column(length: 255)]
    private ?string $nomDeCategorie = null;

    public function __construct()
    {
        $this->nomCategorie = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Article>
     */
    public function getNomCategorie(): Collection
    {
        return $this->nomCategorie;
    }

    public function addNomCategorie(Article $nomCategorie): self
    {
        if (!$this->nomCategorie->contains($nomCategorie)) {
            $this->nomCategorie->add($nomCategorie);
            $nomCategorie->setCategorie($this);
        }

        return $this;
    }

    public function removeNomCategorie(Article $nomCategorie): self
    {
        if ($this->nomCategorie->removeElement($nomCategorie)) {
            // set the owning side to null (unless already changed)
            if ($nomCategorie->getCategorie() === $this) {
                $nomCategorie->setCategorie(null);
            }
        }

        return $this;
    }

    public function getNomDeCategorie(): ?string
    {
        return $this->nomDeCategorie;
    }

    public function setNomDeCategorie(string $nomDeCategorie): self
    {
        $this->nomDeCategorie = $nomDeCategorie;

        return $this;
    }

    //implementer toString
}
