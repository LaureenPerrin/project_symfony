<?php

namespace App\Controller;

use App\Entity\Campus;
use App\Entity\Etat;
use App\Entity\Lieu;
use App\Entity\Participant;
use App\Entity\Sortie;
use App\Entity\Ville;
use App\Form\SortieType;
use App\Repository\SortieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/sortie")
 */
class SortieController extends Controller
{
    /**
     * @Route("/inscription/{id}", name="sortie_inscription")
     */
    public function inscription(EntityManagerInterface $em, Sortie $sortie): Response
    {

        $sortieRepository= $em->getRepository(Sortie::class);
        $campusRepository = $em->getRepository(Campus::class);
        $participantRepo = $em->getRepository(Participant::class);
        $userPseudo = $this->getUser()->getUsername();
        $participant = $participantRepo->findOneByPseudo($userPseudo);
        $sorties = $sortieRepository->findAll();

        $tableauParticipant = $sortie->getParticipantsInscrits();

        $tableauParticipant->add($participant);

        $sortie->setParticipantsInscrits($tableauParticipant);
        dump($sortie->getParticipantsInscrits());


        $this->getDoctrine()->getManager()->persist($sortie);
        $this->getDoctrine()->getManager()->flush();

        return $this->render('main/home.html.twig', [
            'sites' => $campusRepository->findAll(),
            'sortie' => $sortie,
            'sorties' => $sorties,
            'participant' => $participant,
        ]);
    }

    /**
     * @Route("/desinscription/{id}", name="sortie_desinscription")
     */
    public function desinscription(EntityManagerInterface $em, Sortie $sortie): Response
    {

        $sortieRepository= $em->getRepository(Sortie::class);
        $campusRepository = $em->getRepository(Campus::class);
        $participantRepo = $em->getRepository(Participant::class);
        $userPseudo = $this->getUser()->getUsername();
        $participant = $participantRepo->findOneByPseudo($userPseudo);
        $sorties = $sortieRepository->findAll();

        $tableauParticipant[] = $sortie->getParticipantsInscrits();

        unset($tableauParticipant[array_search($participant, $tableauParticipant)]);
        dump($tableauParticipant);

        $sortie->setParticipantsInscrits($tableauParticipant);

        $this->getDoctrine()->getManager()->persist($sortie);
        $this->getDoctrine()->getManager()->flush();

        return $this->render('main/home.html.twig', [
            'sites' => $campusRepository->findAll(),
            'sortie' => $sortie,
            'sorties' => $sorties,
            'participant' => $participant,
        ]);
    }

    /**
     * @Route("/annulation/{id}", name="sortie_annulation")
     */
    public function annuler(EntityManagerInterface $em, Sortie $sortie, Request $request): Response
    {

        $etatRepo = $em->getRepository(Etat::class);

        $motifAnnulationSortie = $request->get("motif");



        if ($motifAnnulationSortie != null) {
            $tableauParticipant = new ArrayCollection();
            $sortie->setParticipantsInscrits($tableauParticipant);
            $sortie->setMotifAnnulation($motifAnnulationSortie);
            $etatAnnule = $etatRepo->findOneByLibelle("Annulée");
            $sortie->setEtat($etatAnnule);
            $this->getDoctrine()->getManager()->persist($sortie);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('sortie/annuler.html.twig', [
            'sortie' => $sortie,
        ]);

    }

    /**
     * @Route("/new", name="sortie_new", methods={"GET","POST"})
     */
    public function new(EntityManagerInterface $em,Request $request): Response
    {
        $etatRepo = $em->getRepository(Etat::class);
        $villesRepo = $em->getRepository(Ville::class);
        $villes = $villesRepo->findAll();

        $participantRepo = $em->getRepository(Participant::class);
        $userPseudo = $this->getUser()->getUsername();
        $participant = $participantRepo->findOneByPseudo($userPseudo);

        $sortie = new Sortie();
        $form = $this->createForm(SortieType::class, $sortie);
        $form->handleRequest($request);
        $action = $request->get("action");

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();

            //gestion état :
            $etatCreee = $etatRepo->findOneByLibelle("Créée");
            $etatPubliee = $etatRepo->findOneByLibelle("Ouverte");

            //gestion ville :
            $nomVilleRecuperee = $request->get("ville");
            $villeTrouvee = $villesRepo->findOneBySomeField($nomVilleRecuperee);

                 //création ville si elle n'éxiste pas :
            if($villeTrouvee == null){

                $villeTrouvee = new Ville();
                $villeTrouvee->setNomVille($nomVilleRecuperee);
                $villeTrouvee->setCodePostal($request->get("code_postal"));
                $entityManager->persist($villeTrouvee);
            }

            //gestion lieu :
            $Lieu = new Lieu();
            $Lieu->setNomLieu($request->get("lieu"));
            $Lieu->setRue($request->get("rue"));
            $Lieu->setLatitude($request->get("latitude"));
            $Lieu->setLongitude($request->get("longitude"));
            $Lieu->setVille($villeTrouvee);
            $entityManager->persist($Lieu);

            //gestion campus :
            $campusRepo = $em->getRepository(Campus::class);
            $nomCampusRecupere = $participant->getCampus()->getNomCampus();
            $campusTrouve = $campusRepo->findOneBySomeField($nomCampusRecupere);
            dump($action);

            if($action == 'enregistrer'){
                $sortie->setEtat($etatCreee);
                $sortie->setIsPublished(false);
            }

            if($action == 'publier'){
                $sortie->setEtat($etatPubliee);
                $sortie->setIsPublished(true);
            }

            $sortie->setLieu($Lieu);
            $sortie->setSiteOrganisateur($campusTrouve);
            $sortie->setParticipantOrganisateur($participant);
            $entityManager->persist($sortie);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('sortie/new.html.twig', [
            'sortie' => $sortie,
            'participant' => $participant,
            'villes' => $villes,
            'form' => $form->createView(),

        ]);
    }

    /**
     * @Route("/{id}", name="sortie_show", methods={"GET"})
     */
    public function show(Sortie $sortie): Response
    {

        return $this->render('sortie/show.html.twig', [
            'sortie' => $sortie,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="sortie_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Sortie $sortie): Response
    {
        $form = $this->createForm(SortieType::class, $sortie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sortie_index');
        }

        return $this->render('sortie/edit.html.twig', [
            'sortie' => $sortie,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="sortie_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Sortie $sortie): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sortie->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($sortie);
            $entityManager->flush();
        }

        return $this->redirectToRoute('sortie_index');
    }
}
