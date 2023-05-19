<?php

namespace App\Controller;

use App\Form\ReservationFormType;
use App\Form\ConnexionFormType;
use App\Form\InscriptionFormType;
use App\Form\EditInfosFormType;
use PDOException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

require_once 'DataBaseProvider.php';

class InfosPratiquesAdmin extends AbstractController
{

    #[Route('/infos-pratiques', name: '/infos-pratiques')]
    public function infosPratiquesAdmin(Request $request, SessionInterface $session): Response
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

        if ($userConnected == true){
            $formReservation->get('email')->setData($user->getEmail());
        }

        $formReservation->handleRequest($request);


        //Initialisation des variables
        $entrees = null;
        $dataBaseProvider = null;
        $errorInscription = '';
        $infosPratiques = null;


        //Récupération des plats
        try {
            $dataBaseProvider = new DataBaseProvider();
            $entrees = $dataBaseProvider->getEntrees();
            $infosPratiques = $dataBaseProvider->getDataInfosPratiques();
        }
        catch (PDOException $PDOException) {
            echo 'Impossible de se connecter à la base de données';
            echo $PDOException->getMessage();
        }

        $formInfosPratiques = $this->createForm(EditInfosFormType::class);
        $formInfosPratiques->get('horairesmatinsemaine')->setData($infosPratiques[0]['horairesmatin']);
        $formInfosPratiques->get('horairessoirsemaine')->setData($infosPratiques[0]['horairessoir']);
        $formInfosPratiques->get('horairesmatinwk')->setData($infosPratiques[1]['horairesmatin']);
        $formInfosPratiques->get('horairessoirwk')->setData($infosPratiques[1]['horairessoir']);

        $formInfosPratiques->handleRequest($request);

        if ($formInfosPratiques->isSubmitted() && $formInfosPratiques->isValid()) {
            $dataBaseProvider->majInfosPratiques(
                0,
                $formInfosPratiques->get('horairesmatinsemaine')->getData(),
                $formInfosPratiques->get('horairessoirsemaine')->getData()
            );
            $dataBaseProvider->majInfosPratiques(
                1,
                $formInfosPratiques->get('horairesmatinwk')->getData(),
                $formInfosPratiques->get('horairessoirwk')->getData()
            );
            $infosPratiques = $dataBaseProvider->getDataInfosPratiques();
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

            return $this->render('infosPratiquesAdmin.html.twig', [
                'entrees' => $entrees,
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

                // Create session and store user information
                $session->set('user', $connexionUser);
                $formReservation->get('email')->setData($connexionUser->getEmail());
                $formReservation->handleRequest($request);
            }


            return $this->render('infosPratiquesAdmin.html.twig', [
                'entrees' => $entrees,
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

            return $this->render('infosPratiquesAdmin.html.twig', [
                'entrees' => $entrees,
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

        //Affichage de l'écran des entrées
        if ($userConnected == true && $user->getEstAdmin()) {
            return $this->render('infosPratiquesAdmin.html.twig', [
                'entrees' => $entrees,
                'showLoginModal' => $showLoginModal,
                'showRegistrationModal' => $showRegistrationModal,
                'errorInscription' => '',
                'form' => $form->createView(),
                'formInscription' => $formInscription->createView(),
                'formReservation' => $formReservation->createView(),
                'formInfosPratiques' => $formInfosPratiques->createView(),
                'userConnected' => $userConnected,
                'infosPratiques' => $infosPratiques,
                'user' => $user,
            ]);
        } else {
            return $this->render('acceuil.html.twig', [
                'entrees' => $entrees,
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
}

