<?php
// ceci est notre ROUTEUR principal

namespace App\Core;

use App\Controllers\MainController;


/**
 * Routeur principal
 */
class Main {

    public function start() {

        // on retire le "traling slash" éventuel de l'URL
        // on recupere l'URL
        $uri = $_SERVER['REQUEST_URI'];

        // on verifie que uri n'est pas vide et se termine par un /
        if (!empty($uri) && $uri != '/' && $uri[-1] === "/") {

            // on enleve le /
            $uri = substr($uri, 0, -1);
            // on envoie un code de redirection permanente
            http_response_code(301);

            // // on redirige vers l'URL sans /
            header('Location: '.$uri);
        }

        $params = [];
        if (isset($_GET['p'])) {

            $params = explode('/', $_GET['p']);
        }
        if (isset($params[0])) {
            
            // on a au moins un parametre
            // on recupere le nom du controleur à instancier
            // on met une majuscule en 1ere lettre, on ajoute le namespace
            // complet avant et on ajoute "controller" apres
            $controller = '\\App\\Controllers\\'.ucfirst(array_shift($params)).
            'Controller';

            // on instancie le controleur
            $controller = new $controller();

            // on recupere le 2eme parametre de l'URL
            $action = (isset($params[0])) ? array_shift($params) : 'index';

            if(method_exists($controller, $action)) {

                // si il reste des parametres on les passe à la methode
                (isset($params[0])) ? call_user_func_array([$controller, $action],
                $params) : $controller->$action();
            }else{
                http_response_code(404);
                echo "la page recherchée n'existe pas";
            }


        }else{
            // on a pas de parametres
            // on instancie le controleur par defaut
            $controller = new MainController;

            // on appelle la methode index
            $controller->index();
        } 
    }
}