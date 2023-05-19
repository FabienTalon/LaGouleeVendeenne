<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Entity\User;
use PDO;

class DataBaseProvider
{
    public function connect(): PDO
    {
        $mysqlDsn = 'mysql:host=localhost;port=3307;dbname=lagouleevendeenne';
        return new PDO($mysqlDsn, 'root', '');
    }

    public function getEntrees(): bool|array
    {
        $pdo = $this->connect();
        $entrees = $pdo->query('SELECT * FROM plats WHERE nature_plats = "entrees" ');
        return $entrees->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPlats(): bool|array
    {
        $pdo = $this->connect();
        $plats = $pdo->query('SELECT * FROM plats WHERE nature_plats = "plats" ');
        return $plats->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDesserts(): bool|array
    {
        $pdo = $this->connect();
        $desserts = $pdo->query('SELECT * FROM plats WHERE nature_plats = "desserts"');
        return $desserts->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBoissons(): bool|array
    {
        $pdo = $this->connect();
        $boissons = $pdo->query('SELECT * FROM plats WHERE nature_plats = "boissons"');
        return $boissons->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getFormules(): bool|array
    {
        $pdo = $this->connect();
        $formules = $pdo->query('SELECT * FROM plats WHERE nature_plats = "formules"');
        return $formules->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createUser($nom, $prenom, $email, $motDePasse, $estAdmin): void
    {
        //$this->userExist($email);

        $user = new User();
        $user->setNom($nom);
        $user->setPrenom($prenom);
        $user->setEmail($email);
        $user->setMotDePasse($motDePasse);
        $user->setEstAdmin($estAdmin);

        $salt = 'random string';
        $hashedPassword = crypt($user->getMotDePasse(), $salt);

        $pdo = $this->connect();

        $stmt = $pdo->prepare('INSERT INTO user (nom, prenom, email, mot_de_passe, est_admin) VALUES (:nom, :prenom, :email, :mot_de_passe, :est_admin)');
        $stmt->execute([
            'nom' => $user->getNom(),
            'prenom' => $user->getPrenom(),
            'email' => $user->getEmail(),
            'mot_de_passe' => $hashedPassword,
            'est_admin' => $user->getEstAdmin(),
        ]);
    }
    public function userExist($email): bool
    {
        $pdo = $this->connect();
        $user = $pdo->prepare('SELECT * FROM user WHERE email = :email');
        $user->execute(['email' => $email]);
        if ($user->fetchAll(PDO::FETCH_ASSOC)== null){
            $userExist = false;
        } else {
            $userExist = true;
        }
        return $userExist;
    }

    public function dataUser($email): User{
        $pdo = $this->connect();
        $user = $pdo->prepare('SELECT * FROM user WHERE email = :email');
        $user->execute(['email' => $email]);
        $userData = $user->fetch(PDO::FETCH_ASSOC);

        if ($userData === false) {
            $connexionUser = new User();
            $connexionUser->setNom('');
            $connexionUser->setPrenom('');
            $connexionUser->setEmail('');
            $connexionUser->setMotDePasse('');
            $connexionUser->setEstAdmin('');
        } else {
            $connexionUser = new User();
            $connexionUser->setNom($userData['nom']);
            $connexionUser->setPrenom($userData['prenom']);
            $connexionUser->setEmail($userData['email']);
            $connexionUser->setMotDePasse($userData['mot_de_passe']);
            $connexionUser->setEstAdmin($userData['est_admin']);
        }

        return $connexionUser;
    }

   public function createReservation($date, $heure, $nombrePersonnes, $allergie, $emailReservation): void
    {
        $reservation = new Reservation();
        $reservation->setDate($date);
        $reservation->setHeure($heure);
        $reservation->setNombrePersonnes($nombrePersonnes);
        $reservation->setAllergie($allergie);
        $reservation->setEmailReservation($emailReservation);

        $pdo = $this->connect();

        $stmt = $pdo->prepare('INSERT INTO reservation (date, email, heure, nombre_personnes, allergie) VALUES (:date, :email, :heure, :nombre_personnes, :allergie)');
        $stmt->execute([
            'date' => $reservation->getDate(),
            'email' => $reservation->getEmailReservation(),
            'heure' => $reservation->getHeure(),
            'nombre_personnes' => $reservation->getNombrePersonnes(),
            'allergie' => $reservation->getAllergie(),
        ]);
    }

    public function getDataInfosPratiques(): bool|array
    {
        $pdo = $this->connect();
        $infosPratiques = $pdo->query('SELECT * FROM infospratiques ');
        return $infosPratiques->fetchAll(PDO::FETCH_ASSOC);
    }

    public function majInfosPratiques($weekend_day, $horairesmatin, $horairessoir): void
    {
        $pdo = $this->connect();
        $stmt = $pdo->prepare('UPDATE infospratiques SET horairesmatin = :horairesmatin, horairessoir = :horairessoir WHERE weekend_day = :weekend_day');
        $stmt->execute([
            'horairesmatin' => $horairesmatin,
            'horairessoir' => $horairessoir,
            'weekend_day' => $weekend_day,
        ]);
    }
}

