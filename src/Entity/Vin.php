<?php

namespace App\Entity;

use App\Repository\VinRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VinRepository::class)]
class Vin
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $annee = null;

    #[ORM\Column(length: 50)]
    private ?string $cepage = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $gout = null;

    #[ORM\Column]
    private ?int $FormatCl = null;

    #[ORM\Column(length: 255)]
    private ?string $domain = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\ManyToOne(inversedBy: 'vins')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Robe $robe = null;

    #[ORM\ManyToOne(inversedBy: 'vins')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TeneurEnSucre $teneurEnSucre = null;

    #[ORM\ManyToMany(targetEntity: Cave::class, mappedBy: 'IdBouteille')]
    private Collection $caves;

    public function __construct()
    {
        $this->caves = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getAnnee(): ?\DateTimeInterface
    {
        return $this->annee;
    }

    public function setAnnee(\DateTimeInterface $annee): self
    {
        $this->annee = $annee;

        return $this;
    }

    public function getCepage(): ?string
    {
        return $this->cepage;
    }

    public function setCepage(string $cepage): self
    {
        $this->cepage = $cepage;

        return $this;
    }

    public function getGout(): ?string
    {
        return $this->gout;
    }

    public function setGout(?string $gout): self
    {
        $this->gout = $gout;

        return $this;
    }

    public function getFormatCl(): ?int
    {
        return $this->FormatCl;
    }

    public function setFormatCl(int $FormatCl): self
    {
        $this->FormatCl = $FormatCl;

        return $this;
    }

    public function getDomain(): ?string
    {
        return $this->domain;
    }

    public function setDomain(string $domain): self
    {
        $this->domain = $domain;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getRobe(): ?Robe
    {
        return $this->robe;
    }

    public function setRobe(?Robe $robe): self
    {
        $this->robe = $robe;

        return $this;
    }

    public function getTeneurEnSucre(): ?TeneurEnSucre
    {
        return $this->teneurEnSucre;
    }

    public function setTeneurEnSucre(?TeneurEnSucre $teneurEnSucre): self
    {
        $this->teneurEnSucre = $teneurEnSucre;

        return $this;
    }

    /**
     * @return Collection<int, Cave>
     */
    public function getCaves(): Collection
    {
        return $this->caves;
    }
}
