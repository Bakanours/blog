<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class  Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $contenu = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $datecreation = null;

    #[ORM\Column]
    private ?int $votes = 0;

    #[ORM\ManyToOne(inversedBy: 'nomCategorie')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Categorie $categorie = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getDatecreation(): ?\DateTimeInterface
    {
        return $this->datecreation;
    }

    public function setDatecreation(\DateTimeInterface $datecreation): self
    {
        $this->datecreation = $datecreation;

        return $this;
    }

    public function getVotes(): ?int
    {
        return $this->votes;
    }

    public function setVotes(int $votes): self
    {
        $this->votes = $votes;

        return $this;
    }

    public function getVotesString() : string
    {
        $prefix = $this->getVotes() >=0 ? '+' : '-';
        return sprintf('%s %d', $prefix, abs($this->getVotes()));
    }

 //   /**
//     * @return Collection<int, Categorie>
 //    */
//    public function getCategories(): Collection
//    {
//        return $this->categories;
//    }
//
//    public function addCategory(Categorie $category): self
//    {
//        if (!$this->categories->contains($category)) {
//            $this->categories->add($category);
//            $category->setNomCategorie($this);
//        }
//
//        return $this;
//    }
//
//    public function removeCategory(Categorie $category): self
//    {
//        if ($this->categories->removeElement($category)) {
//            // set the owning side to null (unless already changed)
//            if ($category->getNomCategorie() === $this) {
//                $category->setNomCategorie(null);
//            }
//        }
//
//        return $this;
//    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    //implementer toString




}
