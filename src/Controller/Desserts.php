<?php

namespace App\Controller;

use App\Form\ConnexionFormType;
use App\Form\InscriptionFormType;
use App\Form\ReservationFormType;
use PDOException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Response;

require_once 'DataBaseProvider.php';

class Desserts extends AbstractController
{
    #[Route('/desserts', name: 'desserts')]
    public function afficherDesserts(Request $request, SessionInterface $session): Response
    {

        $userConnected = $session->has('user');
        $user = $session->get('user');

        //Instanciation des formulaires
        $formInscription = $this->createForm(InscriptionFormType::class);
        $formInscription->handleRequest($request);

        $form = $this->createForm(ConnexionFormType::class);
        $form->handleRequest($request);

        //Initialisation des variables
        $desserts = null;
        $dataBaseProvider = null;
        $errorInscription = '';
        $infosPratiques = null;

        //Récupération des plats
        try {
            $dataBaseProvider = new DataBaseProvider();
            $desserts = $dataBaseProvider->getDesserts();
            $infosPratiques = $dataBaseProvider->getDataInfosPratiques();
        }
        catch (PDOException $PDOException) {
            echo 'Impossible de se connecter à la base de données';
            echo $PDOException->getMessage();
        }

        $formReservation = $this->createForm(ReservationFormType::class);

        if ($userConnected == true){
            $formReservation->get('email')->setData($user->getEmail());
            $formReservation->get('allergies')->setData($dataBaseProvider->getUserAllergie($user->getEmail()));
        }

        $formReservation->handleRequest($request);

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
            } else {
                $errorInscription = 'Votre profil existe déja, vérifiez vos données de connection';
            }


            return $this->render('desserts.html.twig', [
                'desserts' =>$desserts,
                'showLoginModal' => true,
                'showRegistrationModal' => false,
                'errorInscription' => $errorInscription,
                'form' => $form->createView(),
                'formInscription' => $formInscription->createView(),
                'formReservation' => $formReservation->createView(),
                'userConnected' => $userConnected,
                'infosPratiques' => $infosPratiques,
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

                // Enregistrement du user en session
                $session->set('user', $connexionUser);

                //Initialisation du formulaire de reservation avec les données du user
                $formReservation->get('email')->setData($connexionUser->getEmail());
                $formReservation->get('allergies')->setData($dataBaseProvider->getUserAllergie($connexionUser->getEmail()));
                $formReservation->handleRequest($request);
            }


            return $this->render('desserts.html.twig', [
                'desserts' => $desserts,
                'showLoginModal' => $showLoginModal,
                'showRegistrationModal' => false,
                'user' => $connexionUser,
                'errorInscription' => $errorInscription,
                'form' => $form->createView(),
                'formInscription' => $formInscription->createView(),
                'formReservation' => $formReservation->createView(),
                'userConnected' => $userConnected,
                'infosPratiques' => $infosPratiques,
            ]);
        }

        if ($formReservation->isSubmitted() && $formReservation->isValid()) {

            $dateValue = $formReservation->get('date')->getData();
            $dateString = $dateValue->format('d-m-Y');

            // Enregistrer la réservation dans la base de données en utilisant la fonction createReservation
            $dataBaseProvider->createReservation(
                $dateString,
                $formReservation->get('heure')->getData(),
                $formReservation->get('nombre_couverts')->getData(),
                $formReservation->get('allergies')->getData(),
                $formReservation->get('email')->getData(),
            );

            return $this->render('desserts.html.twig', [
                'desserts' => $desserts,
                'showLoginModal' => false,
                'showRegistrationModal' => $showRegistrationModal,
                'errorInscription' => '',
                'form' => $form->createView(),
                'formInscription' => $formInscription->createView(),
                'formReservation' => $formReservation->createView(),
                'userConnected' => $userConnected,
                'infosPratiques' => $infosPratiques,
                'user' => $user,
            ]);
        }

        //Gestion de l'affichage du formulaire de connection non valide
        $showLoginModal = false;
        if ($form->isSubmitted() && !$form->isValid()){
            $showLoginModal = true;
        }

        //Affichage de l'écran des desserts
        return $this->render('desserts.html.twig', [
            'desserts' => $desserts,
            'showLoginModal' => $showLoginModal,
            'showRegistrationModal' => $showRegistrationModal,
            'errorInscription' => '',
            'form' => $form->createView(),
            'formInscription' => $formInscription->createView(),
            'formReservation' => $formReservation->createView(),
            'userConnected' => $userConnected,
            'infosPratiques' => $infosPratiques,
            'user' => $user,
        ]);
    }
}

