<?php

namespace App\Controller;

use App\Entity\Campus;
use App\Entity\Participant;
use App\Entity\Sortie;
use App\Repository\CampusRepository;
use App\Repository\SortieRepository;
use App\Repository\ParticipantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;




class MainController extends Controller
{

    /**
     * @Route("/home", name="home")
     */
    public function home(EntityManagerInterface $em, Request $request) : Response
    {

        $sortieRepository= $em->getRepository(Sortie::class);
        $campusRepository = $em->getRepository(Campus::class);
        $participantRepository = $em->getRepository(Participant::class);

        $site = $request->get("campus");

        $nomSortie = $request->get("nomSortie");
        $dateDebut = $request->get("date_debut");
        $dateFin = $request->get("date_fin");
        $organisateur = $request->get("estOrganisateur");
        $inscrit = $request->get("estInscrit");
        $nonInscrit = $request->get("nestPasInscrit");
        $sortiesPassees = $request->get("sortiesPassees");
        $idInscrit = null;
        $idNonInscrit = null;
        $idOrganisateur = null;

        if(($site != null) or ($nomSortie != null) or ($dateDebut != null) or ($dateFin != null) or ($organisateur != null) or ($inscrit != null) or ($nonInscrit != null) or ($sortiesPassees !=null)){
            if($organisateur != null){
                $organisateurId = $participantRepository->findOneByPseudo($organisateur);
                $idOrganisateur = $organisateurId->getId();
            }

            if($inscrit != null){
                $participantinscrit = $participantRepository->findOneByPseudo($inscrit);
                $idInscrit = $participantinscrit->getId();
            }

            if($nonInscrit != null){
                $particpant = $participantRepository->findOneByPseudo($nonInscrit);
                $idNonInscrit = $particpant->getId();
            }
            //Retourne la liste des sorties en fonction des critères :
            $sorties = $sortieRepository->sortiesByCriteres($site, $nomSortie, $dateDebut, $dateFin, $idOrganisateur, $idInscrit, $idNonInscrit, $sortiesPassees);
        } else {
            $sorties = $sortieRepository->findAll();
        }


        $userPseudo = $this->getUser()->getUsername();
        $participant = $participantRepository->findOneByPseudo($userPseudo);

        return $this->render("main/home.html.twig", [
            'sites' => $campusRepository->findAll(),
            'sorties' => $sorties,
            'participant' => $participant,
        ]);
    }

}
