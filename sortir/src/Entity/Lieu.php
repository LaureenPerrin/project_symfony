<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LieuRepository")
 */
class Lieu
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $nom_lieu;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $rue;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $latitude;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $longitude;
    /**
     * @var Ville
     * @ORM\ManyToOne(targetEntity="App\Entity\Ville", inversedBy="lieux")
     */
    private $ville;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="App\Entity\Sortie", mappedBy="lieu")
     */
    private $sorties;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomLieu(): ?string
    {
        return $this->nom_lieu;
    }

    public function setNomLieu(string $nom_lieu): self
    {
        $this->nom_lieu = $nom_lieu;

        return $this;
    }

    public function getRue(): ?string
    {
        return $this->rue;
    }

    public function setRue(?string $rue): self
    {
        $this->rue = $rue;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(?float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(?float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * @return Ville
     */
    public function getVille(): Ville
    {
        return $this->ville;
    }

    /**
     * @param Ville $ville
     */
    public function setVille(Ville $ville)
    {
        $this->ville = $ville;
    }

    /**
     * @return ArrayCollection
     */
    public function getSorties(): ArrayCollection
    {
        return $this->sorties;
    }

    /**
     * @param ArrayCollection $sorties
     */
    public function setSorties(ArrayCollection $sorties)
    {
        $this->sorties = $sorties;
    }
}
