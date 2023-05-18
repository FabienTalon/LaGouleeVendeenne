<?php

namespace App\Controller;

use App\Form\ConnexionFormType;
use App\Form\ReservationFormType;
use PDOException;
use App\Form\InscriptionFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
require_once 'DataBaseProvider.php';

class Formules extends AbstractController
{
    #[Route('/formules', name: 'formules')]
    public function afficherFormules(Request $request, SessionInterface $session): Response
    {

        // Vérifiez si l'utilisateur est connecté en vérifiant la session
        $userConnected = $session->has('user');
        $user = $session->get('user');

        //Instanciation des formulaires
        $formInscription = $this->createForm(InscriptionFormType::class);
        $formInscription->handleRequest($request);

        $form = $this->createForm(ConnexionFormType::class);
        $form->handleRequest($request);

        $formReservation = $this->createForm(ReservationFormType::class);
        $formReservation->handleRequest($request);

        //Initialisation des variables
        $formules = null;
        $dataBaseProvider = null;

        //Récupération des formules
        try {
            $dataBaseProvider = new DataBaseProvider();
            $formules = $dataBaseProvider->getFormules();
        }
        catch (PDOException $PDOException) {
            echo'Impossible de se connecter à la base de données';
            echo $PDOException->getMessage()  ;
        }

        //Submit du formulaire d'inscription
        if ($formInscription->isSubmitted() && $formInscription->isValid()) {
            $userExist = $dataBaseProvider->userExist($formInscription->get('email')->getData());
            if (!$userExist){
                $dataBaseProvider->createUser(
                    $formInscription->get('nom')->getData(),
                    $formInscription->get('prenom')->getData(),
                    $formInscription->get('email')->getData(),
                    $formInscription->get('plainPassword')->getData(),
                    false);
                $errorInscription = '';
            } else {
                $errorInscription = 'Votre profil existe déja, vérifiez vos données de connection';
            }


            return $this->render('formules.html.twig', [
                'formules' => $formules,
                'showLoginModal' => true,
                'showRegistrationModal' => false,
                'errorInscription' => $errorInscription,
                'form' => $form->createView(),
                'formInscription' => $formInscription->createView(),
                'formReservation' => $formReservation->createView(),
            ]);
        }

        //Gestion de l'affichage du formulaire d'inscription non valide
        $showRegistrationModal = false;
        if ($formInscription->isSubmitted() && !$formInscription->isValid()){
            $showRegistrationModal = true;
        }

        //Submit du formulaire de connection
        if ($form->isSubmitted() && $form->isValid()) {
            $connexionUser = $dataBaseProvider->dataUser($form->get('email')->getData());
            if ($connexionUser->getEmail() == null) {
                $errorInscription = 'Profil de connexion inexistant';
                $showLoginModal = true;
            } else if (!hash_equals($connexionUser->getMotDePasse(), crypt($form->get('password')->getData(), $connexionUser->getMotDePasse()))) {
                $errorInscription = 'Mot de passe invalide';
                $showLoginModal = true;
            } else {
                $errorInscription = '';
                $showLoginModal = false;
                $userConnected = true;

                // Create session and store user information
                $session->set('user', $connexionUser);
            }


            return $this->render('formules.html.twig', [
                'formules' => $formules,
                'showLoginModal' => $showLoginModal,
                'showRegistrationModal' => false,
                'user' => $connexionUser,
                'errorInscription' => $errorInscription,
                'form' => $form->createView(),
                'formInscription' => $formInscription->createView(),
                'formReservation' => $formReservation->createView(),
                'userConnected' => $userConnected,
            ]);
        }

        //Gestion de l'affichage du formulaire de connection non valide
        $showLoginModal = false;
        if ($form->isSubmitted() && !$form->isValid()){
            $showLoginModal = true;
        }

        //Affichage de l'écran des formules
        return $this->render('formules.html.twig', [
            'formules' => $formules,
            'showLoginModal' => $showLoginModal,
            'showRegistrationModal' => $showRegistrationModal,
            'errorInscription' => '',
            'form' => $form->createView(),
            'formInscription' => $formInscription->createView(),
            'formReservation' => $formReservation->createView(),
            'userConnected' => $userConnected,
            'user' => $user,
        ]);
    }
}