<?php

namespace App\Controllers;


/**
 * Controleur principal
 */

abstract class Controller {

    public function render (string $fichier, array $données = [], string $template = 'default') {
    
        // on va extraire le contenu des données
        extract($données);

        // on demare le buffer de sortie
        ob_start();
        // a partir de ce point toute sortie est concervee en memoire
                
        // ici on cree le chemin d'acces vers la vue
        require_once ROOT.'/Views/'.$fichier.'.php';
        
        // on transfere le buffer dans $contenu
        $contenu = ob_get_clean();

        // template de page
        require_once ROOT.'/Views/'.$template.'.php';

    }

}