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
