<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;



/**
 * @UniqueEntity(fields={"mail"}, message="Ce mail existe déjà !")
 * @UniqueEntity(fields={"pseudo"}, message="Ce pseudo existe déjà !")
/**
 * @ORM\Entity(repositoryClass="App\Repository\ParticipantRepository")
 */
class Participant implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank(message="Votre pseudo doit être renseigné.")
     *  * @Assert\Length(
     *      min = 4,
     *      max = 30,
     *      minMessage = "Votre pseudo doit être composé de {{ limit }} caractères minimum",
     *      maxMessage = "Votre pseudo doit être composé de {{ limit }} caractères maximum"
     * )
     *
     * @ORM\Column(type="string", length=30, unique=true)
     */
    private $pseudo;

    /**
     * @return mixed
     */
    public function getPseudo()
    {
        return $this->pseudo;
    }

    /**
     * @param mixed $pseudo
     */
    public function setPseudo($pseudo)
    {
        $this->pseudo = $pseudo;
    }

    /**
     * @return mixed
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * @param mixed $mail
     */
    public function setMail($mail)
    {
        $this->mail = $mail;
    }

    /**
     * @return mixed
     */
    public function getMotDePasse()
    {
        return $this->mot_de_passe;
    }

    /**
     * @param mixed $mot_de_passe
     */
    public function setMotDePasse($mot_de_passe)
    {
        $this->mot_de_passe = $mot_de_passe;
    }

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $nom_participant;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     */
    private $telephone;

    /**
     * @Assert\NotBlank(message="Votre email doit être renseigné.")
     * @Assert\Email(message="Votre email n'est pas valide.")
     *
     * @ORM\Column(type="string", length=200, unique=true)
     */
    private $mail;

    /**
     * @Assert\NotBlank(message="Votre mot de passe doit être renseigné.")
     * @Assert\Length(
     *      min = 6,
     *      max = 50,
     *      minMessage = "Votre mot de passe doit contenir {{ limit }} caractères minimum.",
     *      maxMessage = "Votre mot de passe doit contenir {{ limit }} caractères maximum"
     * )
     * @ORM\Column(type="string", length=200)
     */
    private $mot_de_passe;

    /**
     * @ORM\Column(type="boolean")
     */
    private $administrateur;

    /**
     * @ORM\Column(type="boolean")
     */
    private $actif;

    /**
     * @var Campus
     * @ORM\ManyToOne(targetEntity="App\Entity\Campus", inversedBy="participants")
     */
    private $campus;

    /**
     *@ORM\ManyToMany(targetEntity="App\Entity\Sortie", mappedBy="participantsInscrits")
     */
    private $inscriptionsSorties;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="App\Entity\Sortie", mappedBy="participantOrganisateur", cascade={"remove"})
     */
    private $sortiesOrganisees;

    /**
     * @ORM\Column(type="json_array")
     */
    private $roles = [];


    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $file;

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param mixed $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * @Assert\File(
     *     maxSize = "10Mi",
     *     uploadErrorMessage="Le fichier n'a pas été téléchargé",
     *     maxSizeMessage ="Le fichier est trop lourd : {{ limit }} {{ suffix }}",
     * )
     */
    private $fileTemp;

    /**
     * @return mixed
     */
    public function getFileTemp()
    {
        return $this->fileTemp;
    }

    /**
     * @param mixed $fileTemp
     */
    public function setFileTemp($fileTemp)
    {
        $this->fileTemp = $fileTemp;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Returns the pseudo used to authenticate the participant.
     *
     * @return string The pseudo
     */
    public function getUsername()
    {
        return $this->getPseudo();
    }

    /**
     * @return mixed
     */
    public function getNomParticipant()
    {
        return $this->nom_participant;
    }

    /**
     * @return mixed
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @return mixed
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->mail;
    }


    public function getPassword()
    {
        return $this->getMotDePasse();
    }

    /**
     * @return mixed
     */
    public function getAdministrateur()
    {
        return $this->administrateur;
    }


    /**
     * @return mixed
     */
    public function getActif()
    {
        return $this->actif;
    }

    /**
     * @return Campus
     */
    public function getCampus(): Campus
    {
        return $this->campus;
    }

    /**
     * @return mixed
     */
    public function getInscriptionsSorties()
    {
        return $this->inscriptionsSorties;
    }

    /**
     * @return ArrayCollection
     */
    public function getSortiesOrganisees(): ArrayCollection
    {
        return $this->sortiesOrganisees;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function getSalt(){return null;}
    public function eraseCredentials(){}

    /**
     * @param mixed $pseudo
     */
    public function setUsername($pseudo)
    {
        $this->pseudo = $pseudo;
    }

    /**
     * @param mixed $nom_participant
     */
    public function setNomParticipant($nom_participant)
    {
        $this->nom_participant = $nom_participant;
    }


    /**
     * @param mixed $prenom
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }

    /**
     * @param mixed $telephone
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
    }

    /**
     * @param mixed $mail
     */
    public function setEmail($mail)
    {
        $this->mail = $mail;
    }



    /**
     * @param mixed $mot_de_passe
     */
    public function setPassword($mot_de_passe)
    {
        $this->mot_de_passe = $mot_de_passe;
    }


    /**
     * @param mixed $administrateur
     */
    public function setAdministrateur($administrateur)
    {
        $this->administrateur = $administrateur;
    }

    /**
     * @param mixed $actif
     */
    public function setActif($actif)
    {
        $this->actif = $actif;
    }


    /**
     * @param Campus $campus
     */
    public function setCampus(Campus $campus)
    {
        $this->campus = $campus;
    }


    /**
     * @param mixed $inscriptionsSorties
     */
    public function setInscriptionsSorties($inscriptionsSorties)
    {
        $this->inscriptionsSorties = $inscriptionsSorties;
    }

    /**
     * @param ArrayCollection $sortiesOrganisees
     */
    public function setSortiesOrganisees(ArrayCollection $sortiesOrganisees)
    {
        $this->sortiesOrganisees = $sortiesOrganisees;
    }

    public function setRoles($roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function addRole($role): self
    {

        $roles = $this->roles;
        $roles[] = $role;
        $this->roles = array_unique($roles);

        return $this;
    }


}
