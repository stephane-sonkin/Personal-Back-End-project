<?php

namespace App\Controllers;

use App\models\AnnoncesModel;

class AnnoncesController extends Controller {

    /**
     * cette methode listera toutes les anonces de la BD
     *
     * @return void
     */
    public function index () {

        // on instancie le model correspondant à la table 'annonces' de la BD
        $annoncesModel = new AnnoncesModel;

        // on va chercher toutes les annonces
        $annonces = $annoncesModel->findBy(['actif' => 1]);

        // on genere la vue
        $this->render('annonces/index', compact('annonces'));
    }


    /**
     * Affiche une annonce
     * @param integer $id Id de l'annonce
     * @return void
     */
    public function lire (int $id) {

        // on instancie le model
        $annoncesModel = new AnnoncesModel;

        // on va chercher une annonce
        $annonce = $annoncesModel->find($id);

        // on envoie à la vue
        $this->render('annonces/lire', compact('annonce'));
    }
}