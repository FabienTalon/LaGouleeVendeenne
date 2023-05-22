# LaGouleeVendeenne

ECF - La Goullée Vendéenne :

La Goulée Vendéenne est une application web de restaurant traditionnel présentant des spécialités Vendéennes.

Procédure d'accès à l'application web : 

Posséder Xampp ou le télécharger;

Création du dossier apps dans le dossier Xampp;

Création du dossier symfony dans le dossier apps;

Accedez au depot GiiHub de mon projet : https://github.com/FabienTalon/LaGouleeVendeenne.git;

Télécharger le fichier ZIP du projet;

Extraire le contenu du dossier LaGouleeVendeenne-master dans le dossier Xampp\apps\symfony;

Dans le pannel de contrôle de Xampp, ouvrir le fichier my.ini et remplacer le port 3306 par le port 3307
sous les lignes :

    '# password       = your_password'

et

    '# The MySQL server'
    default-character-set=utf8mb4
    [mysqld]

Dans ce même pannel de contrôle de Xampp, ouvrir le fichier httpd-xampp.conf et rajouter ces lignes à la fin du fichier :

    <VirtualHost *:80>
    ServerName laGouleeVendeenne.localhost

    DocumentRoot "C:/xampp/apps/symfony/public"
    DirectoryIndex index.php

    <Directory "C:/xampp/apps/symfony/public">

    Require all granted

        FallbackResource /index.php
    </Directory>
    </VirtualHost>

Idem pour le fichier config.inc.php où il faut remplacer les lignes sous /* Authentication type and info */ :

    $cfg['Servers'][$i]['auth_type'] = 'config';
    $cfg['Servers'][$i]['user'] = 'root';
    $cfg['Servers'][$i]['password'] = '';
    $cfg['Servers'][$i]['extension'] = 'mysqli';
    $cfg['Servers'][$i]['AllowNoPassword'] = true;
    $cfg['Lang'] = '';

    /* Bind to the localhost ipv4 address and tcp */
    $cfg['Servers'][$i]['host'] = 'localhost:3307';
    $cfg['Servers'][$i]['connect_type'] = 'tcp';

Pour la suite, ouvrir un bloc note en mode Administrateur et éditer le fichier C:\Windows\System32\drivers\etc\hosts :

rajouter la ligne suivante : 127.0.0.1       laGouleeVendeenne.localhost

Démarrer Apache et MySQL sur le pannel de contrôle de Xampp.

Initialisation et configuration de la base de données dans phpmyAdmin en important le fichier lagouleevendeenne.sql 
présent dans le dossier symfony\ConfigurationDataBase.

Rentrer l'URL pour accéder à l'application Web : http://lagouleevendeenne.localhost  

Pour la création d'un administrateur pour le back-office de l'application Web :  
    - Inscrivez-vous via l'application web;
    - Dans phpmyAdmin, dans la table user, éditez la ligne contenant vos informations personnelles et passez la colonne
est_admin à 1.
    - Vous pouvez désormais bénéficier des privilèges admin dans l'application web.

Have Fun !
