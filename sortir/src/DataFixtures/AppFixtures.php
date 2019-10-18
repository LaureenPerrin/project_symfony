<?php

namespace App\DataFixtures;

use App\Entity\Campus;
use App\Entity\Etat;
use App\Entity\Lieu;
use App\Entity\Participant;
use App\Entity\Sortie;
use App\Entity\Ville;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $etatCree = new Etat();
        $etatCree->setLibelle('Créée');
        $manager->persist($etatCree);

        $etatOuverte = new Etat();
        $etatOuverte->setLibelle('Ouverte');
        $manager->persist($etatOuverte);

        $etatCloturee = new Etat();
        $etatCloturee->setLibelle('Clôturée');
        $manager->persist($etatCloturee);

        $etatActiviteEnCours= new Etat();
        $etatActiviteEnCours->setLibelle('Activité en cours');
        $manager->persist($etatActiviteEnCours);

        $etatPassee= new Etat();
        $etatPassee->setLibelle('Passée');
        $manager->persist($etatPassee);

        $etatAnnulee= new Etat();
        $etatAnnulee->setLibelle('Annulée');
        $manager->persist($etatAnnulee);

        $manager->flush();

        $Paris = new Ville();
        $Paris->setNomVille('Paris');
        $Paris->setCodePostal('75000');
        $manager->persist($Paris);

        $Niort = new Ville();
        $Niort->setNomVille('Niort');
        $Niort->setCodePostal('79000');
        $manager->persist($Niort);

        $Lyon = new Ville();
        $Lyon->setNomVille('Lyon');
        $Lyon->setCodePostal('69000');
        $manager->persist($Lyon);

        $Nantes = new Ville();
        $Nantes->setNomVille('Nantes');
        $Nantes->setCodePostal('44000');
        $manager->persist($Nantes);

        $manager->flush();

        $Lieu1 = new Lieu();
        $Lieu1->setNomLieu("nom lieu 1");
        $Lieu1->setRue("rue lieu 1");
        $Lieu1->setLatitude('48.866667');
        $Lieu1->setLongitude('2.333333');
        $Lieu1->setVille($Paris);
        $manager->persist($Lieu1);

        $Lieu2 = new Lieu();
        $Lieu2->setNomLieu("nom lieu 2");
        $Lieu2->setRue("rue lieu 2");
        $Lieu2->setLatitude('85.866667');
        $Lieu2->setLongitude('6.333333');
        $Lieu2->setVille($Niort);
        $manager->persist($Lieu2);

        $Lieu3 = new Lieu();
        $Lieu3->setNomLieu("nom lieu 3");
        $Lieu3->setRue("rue lieu 4");
        $Lieu3->setLatitude('15.866667');
        $Lieu3->setLongitude('1.333333');
        $Lieu3->setVille($Nantes);
        $manager->persist($Lieu3);

        $Lieu4 = new Lieu();
        $Lieu4->setNomLieu("nom lieu 4");
        $Lieu4->setRue("rue lieu 4");
        $Lieu4->setLatitude('65.866667');
        $Lieu4->setLongitude('4.333333');
        $Lieu4->setVille($Niort);
        $manager->persist($Lieu4);

        $manager->flush();

        $CampusNiort = new Campus();
        $CampusNiort->setNomCampus('Campus de Niort');
        $manager->persist($CampusNiort);

        $CampusNantes = new Campus();
        $CampusNantes->setNomCampus('Campus de Nantes');
        $manager->persist($CampusNantes);

        $CampusParis = new Campus();
        $CampusParis->setNomCampus('Campus de Paris');
        $manager->persist($CampusParis);

        $manager->flush();

        $ParticipantStagiaireActif = new Participant();
        $ParticipantStagiaireActif->setCampus($CampusNantes);
        $ParticipantStagiaireActif->setNomParticipant('dupont');
        $ParticipantStagiaireActif->setUsername('dupont');
        $ParticipantStagiaireActif->setPrenom('pierre');
        $ParticipantStagiaireActif->setTelephone('0612569884');
        $ParticipantStagiaireActif->setEmail('dupontpierre@gmail.com');
        $password1 = $this->encoder->encodePassword($ParticipantStagiaireActif, 'pierredupont');
        $ParticipantStagiaireActif->setPassword($password1);
        $ParticipantStagiaireActif->setAdministrateur(false);
        $ParticipantStagiaireActif->setActif(true);
        $ParticipantStagiaireActif->setRoles(['ROLE_USER']);
       // $manager->persist($ParticipantStagiaireActif);

        $ParticipantStagiaireNonActif = new Participant();
        $ParticipantStagiaireNonActif->setCampus($CampusNiort);
        $ParticipantStagiaireNonActif->setNomParticipant('dupuis');
        $ParticipantStagiaireNonActif->setUsername('dupuis');
        $ParticipantStagiaireNonActif->setPrenom('paul');
        $ParticipantStagiaireNonActif->setTelephone('0612569884');
        $ParticipantStagiaireNonActif->setEmail('dupuispaul@gmail.com');
        $password2 = $this->encoder->encodePassword($ParticipantStagiaireNonActif, 'pauldupuis');
        $ParticipantStagiaireNonActif->setPassword($password2);
        $ParticipantStagiaireNonActif->setAdministrateur(false);
        $ParticipantStagiaireNonActif->setActif(false);
        $ParticipantStagiaireNonActif->setRoles(['ROLE_USER']);
        //$manager->persist($ParticipantStagiaireNonActif);

        $ParticipantAdministrateur = new Participant();
        $ParticipantAdministrateur->setCampus($CampusNiort);
        $ParticipantAdministrateur->setNomParticipant('admin');
        $ParticipantAdministrateur->setUsername('admin');
        $ParticipantAdministrateur->setPrenom('admin');
        $ParticipantAdministrateur->setTelephone('0612569884');
        $ParticipantAdministrateur->setEmail('admin@gmail.com');
        $password3 = $this->encoder->encodePassword($ParticipantAdministrateur, 'admin');
        $ParticipantAdministrateur->setPassword($password3);
        $ParticipantAdministrateur->setAdministrateur(true);
        $ParticipantAdministrateur->setActif(true);
        $ParticipantAdministrateur->setRoles(['ROLE_ADMIN']);
        //$manager->persist($ParticipantAdministrateur);

        $ParticipantStagiaireActif2 = new Participant();
        $ParticipantStagiaireActif2->setCampus($CampusParis);
        $ParticipantStagiaireActif2->setNomParticipant('martin');
        $ParticipantStagiaireActif2->setUsername('martin');
        $ParticipantStagiaireActif2->setPrenom('toto');
        $ParticipantStagiaireActif2->setTelephone('0612569884');
        $ParticipantStagiaireActif2->setEmail('martintoto@gmail.com');
        $password4 = $this->encoder->encodePassword($ParticipantStagiaireActif2, 'totomartin');
        $ParticipantStagiaireActif2->setPassword($password4);
        $ParticipantStagiaireActif2->setAdministrateur(false);
        $ParticipantStagiaireActif2->setActif(true);
        $ParticipantStagiaireActif2->setRoles(['ROLE_USER']);
        //$manager->persist($ParticipantStagiaireActif2);

        $manager->flush();

        $SortieArt = new Sortie();
        $SortieArt->setNomSortie('nom sortie art');
        $SortieArt->setDateDebut(new \DateTime('2019-10-20 20:30:00'));
        $SortieArt->setDuree(3);
        $SortieArt->setDateCloture(new \DateTime('2019-10-19 10:00:00'));
        $SortieArt->setNbinscriptionsmax(2);
        $SortieArt->setDescriptioninfos(null);
        $SortieArt->setEtat($etatCree);
        $SortieArt->setSiteOrganisateur($CampusNiort);
        $SortieArt->setLieu($Lieu2);
        $SortieArt->setParticipantOrganisateur($ParticipantStagiaireNonActif);
        $SortieArt->setUrlPhoto(null);
        $SortieArt->setIsPublished(false);
        $manager->persist($SortieArt);


        $SortieMusique = new Sortie();
        $SortieMusique->setNomSortie('nom sortie musique');
        $SortieMusique->setDateDebut(new \DateTime('2019-10-22 20:00:00'));
        $SortieMusique->setDuree(5);
        $SortieMusique->setDateCloture(new \DateTime('2019-10-21 20:00:00'));
        $SortieMusique->setNbinscriptionsmax(3);
        $SortieMusique->setDescriptioninfos(null);
        $SortieMusique->setEtat($etatCree);
        $SortieMusique->setSiteOrganisateur($CampusNantes);
        $SortieMusique->setLieu($Lieu3);
        $SortieMusique->setParticipantOrganisateur($ParticipantStagiaireActif);
        $SortieMusique->setUrlPhoto(null);
        $SortieMusique->setIsPublished(false);
        $manager->persist($SortieMusique);

        $SortieCuisine = new Sortie();
        $SortieCuisine->setNomSortie('nom sortie cuisine');
        $SortieCuisine->setDateDebut(new \DateTime('2019-10-18 20:30:00'));
        $SortieCuisine->setDuree(4);
        $SortieCuisine->setDateCloture(new \DateTime('2019-10-17 20:30:00'));
        $SortieCuisine->setNbinscriptionsmax(3);
        $SortieCuisine->setDescriptioninfos(null);
        $SortieCuisine->setEtat($etatCree);
        $SortieCuisine->setSiteOrganisateur($CampusNiort);
        $SortieCuisine->setLieu($Lieu4);
        $SortieCuisine->setParticipantOrganisateur($ParticipantStagiaireNonActif);
        $SortieCuisine->setUrlPhoto(null);
        $SortieCuisine->setIsPublished(false);
        $manager->persist($SortieCuisine);

        $SortieDeco = new Sortie();
        $SortieDeco->setNomSortie('nom sortie décoration');
        $SortieDeco->setDateDebut(new \DateTime('2019-10-30 20:30:00'));
        $SortieDeco->setDuree(1);
        $SortieDeco->setDateCloture(new \DateTime('2019-10-29 20:30:00'));
        $SortieDeco->setNbinscriptionsmax(2);
        $SortieDeco->setDescriptioninfos('Description de la sortie décoration sur Nantes');
        $SortieDeco->setEtat($etatPassee);
        $SortieDeco->setSiteOrganisateur($CampusNantes);
        $SortieDeco->setLieu($Lieu3);
        $SortieDeco->setParticipantOrganisateur($ParticipantStagiaireActif);
        $SortieDeco->setUrlPhoto(null);
        $SortieDeco->setIsPublished(false);
        $manager->persist($SortieDeco);

        $ParticipantStagiaireNonActif->setInscriptionsSorties([$SortieArt, $SortieCuisine]);
        $ParticipantAdministrateur->setInscriptionsSorties([$SortieArt, $SortieCuisine]);

        $manager->persist($ParticipantStagiaireActif);
        $manager->persist($ParticipantStagiaireNonActif);
        $manager->persist($ParticipantAdministrateur);
        $manager->persist($ParticipantStagiaireActif2);

        $manager->flush();

    }
}
