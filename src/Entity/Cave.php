<?php

namespace App\Entity;

use App\Repository\CaveRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CaveRepository::class)]
class Cave
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateMiseENCave = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $DateSortie = null;

    #[ORM\Column(nullable: true)]
    private ?int $note = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $commentaire = null;

    #[ORM\OneToOne(inversedBy: 'cave', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $idUser = null;

    #[ORM\ManyToMany(targetEntity: Vin::class, inversedBy: 'caves')]
    private Collection $IdBouteille;

    public function __construct()
    {
        $this->IdBouteille = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateMiseENCave(): ?\DateTimeInterface
    {
        return $this->dateMiseENCave;
    }

    public function setDateMiseENCave(\DateTimeInterface $dateMiseENCave): self
    {
        $this->dateMiseENCave = $dateMiseENCave;

        return $this;
    }

    public function getDateSortie(): ?\DateTimeInterface
    {
        return $this->DateSortie;
    }

    public function setDateSortie(?\DateTimeInterface $DateSortie): self
    {
        $this->DateSortie = $DateSortie;

        return $this;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(?int $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(?string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getIdUser(): ?Utilisateur
    {
        return $this->idUser;
    }

    public function setIdUser(Utilisateur $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }

    /**
     * @return Collection<int, Vin>
     */
    public function getIdBouteille(): Collection
    {
        return $this->IdBouteille;
    }

    public function addIdBouteille(Vin $idBouteille): self
    {
        if (!$this->IdBouteille->contains($idBouteille)) {
            $this->IdBouteille->add($idBouteille);
        }

        return $this;
    }

    public function removeIdBouteille(Vin $idBouteille): self
    {
        $this->IdBouteille->removeElement($idBouteille);

        return $this;
    }
}
