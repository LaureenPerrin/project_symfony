<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Form\ParticipantType;
use App\Repository\ParticipantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;


class ParticipantController extends Controller
{

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * @Route("/", name="login")
     * @param AuthenticationUtils $authUtils
     * @return Response
     */
    public function login(AuthenticationUtils $authUtils)
    {
        $error = $authUtils->getLastAuthenticationError();
        $lastUsername = $authUtils->getLastUsername();


        return $this->render('main/login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,

        ));
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout(){}


    /**
     * @Route("/participant_index", name="participant_index", methods={"GET"})
     */
    public function index(ParticipantRepository $participantRepository): Response
    {
        return $this->render('participant/index.html.twig', [
            'participants' => $participantRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="participant_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $participant = new Participant();
        $form = $this->createForm(ParticipantType::class, $participant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($participant);
            $entityManager->flush();

            return $this->redirectToRoute('participant_index');
        }

        return $this->render('participant/new.html.twig', [
            'participant' => $participant,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="participant_show", methods={"GET"})
     */
    public function show(EntityManagerInterface $em, Participant $participant): Response
    {
        $participantRepo = $em->getRepository(Participant::class);
        $userPseudo = $this->getUser()->getUsername();
        $userConnecte = $participantRepo->findOneByPseudo($userPseudo);

        return $this->render('participant/show.html.twig', [
            'participant' => $participant,
            'userConnecte' => $userConnecte,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="participant_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Participant $participant): Response
    {

        $form = $this->createForm(ParticipantType::class, $participant);
        $form->handleRequest($request);

        $plainPassword =  $participant->getPassword();
        $encoded = $this->encoder->encodePassword($participant, $plainPassword);
        $participant->setPassword($encoded);

        if ($form->isSubmitted() && $form->isValid()) {
            $error = false;
            //file
            try{
                $file = $form->get('fileTemp')->getData();
                //fichier optionnel
                if($file != null){
                    $extension = strtolower($file->getClientOriginalExtension());
                    $fileDownload = md5(uniqid(mt_rand(), true)).'.'.$extension;
                    //$file->move($this->getParameter('path_dir').'download/', $fileDownload);
                    $file->move($this->getParameter('download_dir'), $fileDownload);
                    $participant->setFile($fileDownload);
                }
            }
            catch (\Exception $e) {
                //Si erreur bloquer l'insertion
                dump( $e->getMessage());

                //Ajout d'une erreur depuis le controller
                $form->get('fileTemp')->addError(new FormError("Une erreur est survenue avec le fichier"));
                $error = true;
            }
            if(!$error) {

                $this->getDoctrine()->getManager()->flush();

                $this->addFlash("success", "Idea successfully saved!");
                //Redirection
                return $this->redirectToRoute('home');
            }


        }

        return $this->render('participant/edit.html.twig', [
            'participant' => $participant,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="participant_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Participant $participant): Response
    {
        if ($this->isCsrfTokenValid('delete'.$participant->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($participant);
            $entityManager->flush();
        }

        return $this->redirectToRoute('home');
    }
}
