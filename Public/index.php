<?php

use App\Autoloader;
use App\Core\Main;


//on definit une constante contenant le dossier racine du projet
define('ROOT', dirname(__DIR__));


//on importe l'autoloader
require_once ROOT.'./Autoloader.php';
Autoloader::register();


// on instancie Main (notre routeur)
$app = new Main();


//ondemarre l'application dans le routeur (Main)
$app->start();






// $model = new UsersModel;

// $user = $model->setEmail('stephanesonkin7@gmail.com')
//     ->setPassword(password_hash('azerty', PASSWORD_ARGON2I));


// $model->create($user);

// var_dump($model);

// $donnees = [
//     'titre' => 'Annonces modifiée',
//     'description' => 'Description de l\'annonce modifiée',
//     'actif' => 1
// ];

// $annonces = $model->hydrate($donnees);

// $model->delete(5);

// var_dump($annonces); 

// var_dump($model->findAll());