<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SortieRepository")
 */
class Sortie
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
    private $nom_sortie;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateDebut;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $duree;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateCloture;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbinscriptionsmax;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private $descriptioninfos;

    /**
     * @ORM\Column(type="string", length=250, nullable=true)
     */
    private $urlPhoto;

    /**
     * @var Etat
     * @ORM\ManyToOne(targetEntity="App\Entity\Etat", inversedBy="sorties", cascade={"persist"})
     */
    private $etat;

    /**
     * @var Campus
     * @ORM\ManyToOne(targetEntity="App\Entity\Campus", inversedBy="sorties")
     */
    private $siteOrganisateur;

    /**
     * @var Lieu
     * @ORM\ManyToOne(targetEntity="App\Entity\Lieu", inversedBy="sorties")
     */
    private $lieu;

    /**
     * @var ArrayCollection
     * @ORM\JoinTable(name="ville")
     */
    private $villes;

    /**
     * @return ArrayCollection
     */
    public function getVilles(): ?ArrayCollection
    {
        return $this->villes;
    }

    /**
     * @param ArrayCollection $villes
     */
    public function setVilles(ArrayCollection $villes)
    {
        $this->villes = $villes;
    }

    /**
     * @var Participant
     * @ORM\ManyToOne(targetEntity="App\Entity\Participant", inversedBy="sortiesOrganisees")
     */
    private $participantOrganisateur;

    /**
     * @var ArrayCollection
     * *@ORM\ManyToMany(targetEntity="App\Entity\Participant", inversedBy="inscriptionsSorties")
     * @ORM\JoinTable(name="Inscriptions")
     */
    private $participantsInscrits;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $motifAnnulation;

    /**
     * @return mixed
     */
    public function getMotifAnnulation()
    {
        return $this->motifAnnulation;
    }

    /**
     * @param mixed $motifAnnulation
     */
    public function setMotifAnnulation($motifAnnulation)
    {
        $this->motifAnnulation = $motifAnnulation;
    }

    /**
     * Sortie constructor.
     */
    public function __construct()
    {
        $this->participantsInscrits = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getParticipantsInscrits()
    {
        return $this->participantsInscrits;
    }

    /**
     * @param ArrayCollection $participantsInscrits
     */
    public function setParticipantsInscrits($participantsInscrits)
    {
        $this->participantsInscrits = $participantsInscrits;
    }

    /**
     * @ORM\Column(type="boolean")
     */
    private $isPublished;

    /**
     * @return mixed
     */
    public function getIsPublished()
    {
        return $this->isPublished;
    }

    /**
     * @param mixed $isPublished
     */
    public function setIsPublished($isPublished)
    {
        $this->isPublished = $isPublished;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomSortie(): ?string
    {
        return $this->nom_sortie;
    }

    public function setNomSortie(string $nom_sortie): self
    {
        $this->nom_sortie = $nom_sortie;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(?int $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getDateCloture(): ?\DateTimeInterface
    {
        return $this->dateCloture;
    }

    public function setDateCloture(\DateTimeInterface $dateCloture): self
    {
        $this->dateCloture = $dateCloture;

        return $this;
    }

    public function getNbinscriptionsmax(): ?int
    {
        return $this->nbinscriptionsmax;
    }

    public function setNbinscriptionsmax(int $nbinscriptionsmax): self
    {
        $this->nbinscriptionsmax = $nbinscriptionsmax;

        return $this;
    }

    public function getDescriptioninfos(): ?string
    {
        return $this->descriptioninfos;
    }

    public function setDescriptioninfos(?string $descriptioninfos): self
    {
        $this->descriptioninfos = $descriptioninfos;

        return $this;
    }


    public function getUrlPhoto(): ?string
    {
        return $this->urlPhoto;
    }

    public function setUrlPhoto(?string $urlPhoto): self
    {
        $this->urlPhoto = $urlPhoto;

        return $this;
    }

    /**
     * @return etat
     */
    public function getEtat(): ?etat
    {
        return $this->etat;
    }

    /**
     * @param etat $etat
     */
    public function setEtat(etat $etat)
    {
        $this->etat = $etat;
    }

    /**
     * @return Lieu
     */
    public function getLieu(): ?Lieu
    {
        return $this->lieu;
    }

    /**
     * @param Lieu $lieu
     */
    public function setLieu(Lieu $lieu)
    {
        $this->lieu = $lieu;
    }




    /**
     * @return Participant
     */
    public function getParticipantOrganisateur(): Participant
    {
        return $this->participantOrganisateur;
    }

    /**
     * @param Participant $participantOrganisateur
     */
    public function setParticipantOrganisateur(Participant $participantOrganisateur)
    {
        $this->participantOrganisateur = $participantOrganisateur;
    }

    /**
     * @return Campus
     */
    public function getSiteOrganisateur(): ?Campus
    {
        return $this->siteOrganisateur;
    }

    /**
     * @param Campus $siteOrganisateur
     */
    public function setSiteOrganisateur(Campus $siteOrganisateur)
    {
        $this->siteOrganisateur = $siteOrganisateur;
    }


}
