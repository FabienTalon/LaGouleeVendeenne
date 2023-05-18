<?php

namespace App\Controller;

use App\Form\ReservationFormType;
use App\Form\ConnexionFormType;
use App\Form\InscriptionFormType;
use PDOException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

require_once 'DataBaseProvider.php';

class Acceuil extends AbstractController
{

    #[Route('/', name: '/')]
    public function index(Request $request, SessionInterface $session): Response
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
        $entrees = null;
        $dataBaseProvider = null;
        $errorInscription = '';


        //Récupération des plats
        try {
            $dataBaseProvider = new DataBaseProvider();
            $entrees = $dataBaseProvider->getEntrees();
        }
        catch (PDOException $PDOException) {
            echo 'Impossible de se connecter à la base de données';
            echo $PDOException->getMessage();
        }

        //Submit du formulaire d'inscription
        if ($formInscription->isSubmitted() && $formInscription->isValid()) {
            $userExist = $dataBaseProvider->userExist($formInscription->get('email')->getData());
            if (!$userExist) {
                $dataBaseProvider->createUser(
                    $formInscription->get('nom')->getData(),
                    $formInscription->get('prenom')->getData(),
                    $formInscription->get('email')->getData(),
                    $formInscription->get('plainPassword')->getData(),
                    false);
            } else {
                $errorInscription = 'Votre profil existe déja, vérifiez vos données de connection';
            }

            return $this->render('acceuil.html.twig', [
                'entrees' => $entrees,
                'showLoginModal' => true,
                'showRegistrationModal' => false,
                'errorInscription' => $errorInscription,
                'form' => $form->createView(),
                'formInscription' => $formInscription->createView(),
                'formReservation' => $formReservation->createView(),
                'userConnected' => $userConnected,
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
                $showLoginModal = false;
                $userConnected = true;

                // Create session and store user information
                $session->set('user', $connexionUser);
            }


            return $this->render('acceuil.html.twig', [
                'entrees' => $entrees,
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


        if ($formReservation->isSubmitted() && $formReservation->isValid()) {
            // Récupérer les données soumises du formulaire de réservation
            $reservation = $formReservation->getData();

            try {
                // Enregistrer la réservation dans la base de données en utilisant la fonction createReservation
                $dataBaseProvider->createReservation(
                    $reservation->get('date')->getDate(),
                    $reservation->get('heure')->getHeure(),
                    $reservation->get('nombre_personnes')->getNombrePersonnes(),
                    $reservation->get('allergie')->getAllergie(),
                    $reservation->get('email')->getEmailReservation()
                );

                // Autres actions (redirection, affichage de messages, etc.)
            } catch (PDOException $PDOException) {
                echo 'Impossible d\'enregistrer la réservation dans la base de données';
                echo $PDOException->getMessage();
            }
        }

// ...

        return $this->render('acceuil.html.twig', [
            'entrees' => $entrees,
            'showLoginModal' => false,
            'showRegistrationModal' => $showRegistrationModal,
            'errorInscription' => '',
            'form' => $form->createView(),
            'formInscription' => $formInscription->createView(),
            'formReservation' => $formReservation->createView(),
            'userConnected' => $userConnected,
            'user' => $user,
        ]);



        //Gestion de l'affichage du formulaire de connection non valide
        $showLoginModal = false;
        if ($form->isSubmitted() && !$form->isValid()){
            $showLoginModal = true;
        }

        //Affichage de l'écran des entrées
        return $this->render('acceuil.html.twig', [
            'entrees' => $entrees,
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

