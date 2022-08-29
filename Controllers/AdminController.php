<?php

namespace App\Controllers;

use App\models\AnnoncesModel;

class AdminController extends Controller {

    public function index() {

        // on verifie si on est admin
        if($this->isAdmin()) {

            $this->render('admin/index', [], 'admin');

        }
    }

/**
 * Affiche la liste des annonces sous forme de tableau
 *
 * @return void
 */
    public function annonces() {

        if($this->isAdmin()){
            $annoncesModel = new AnnoncesModel;

            $annonces = $annoncesModel->findAll();

            $this->render('admin/annonces', compact('annonces'), 'admin');
        }

    }

/**
 * Supprime une annonce si on est admin
 *
 * @param int $id
 * @return void
 */
    public function supprimerAnnonce(int $id) {

        if($this->isAdmin()) {

            $annonce = new AnnoncesModel;

            $annonce->delete($id);

            header('Location : /POO_BD/Public/index.php/admin/annonces');
        }
    }



    /**
     * Active et désactive les annonces
     *
     * @param [type] $id
     * @return void
     */
    public function activeAnnonce($id) {

        if($this->isAdmin()) {
            $annoncesModel = new AnnoncesModel;

            $annonceArray = $annoncesModel->find($id);

            if($annonceArray) {
                $annonce = $annoncesModel->hydrate($annonceArray);

                $annonce->setActif($annonce->getActif() ? 0 :1);

                $annonce->update();
            }
        }
    }

    /**
     * On verifie si on l'utilisateur est admin
     *
     * @return boolean
     */
    private function isAdmin(){

        // On vérifie si on est connecté et si "ROLE_ADMIN" est dans nos rôles
        if(isset($_SESSION['user']) && in_array('ROLE_ADMIN', $_SESSION['user']['roles'])){
            // On est admin
            return true;
        }else{
            // On n'est pas admin
            $_SESSION['erreur'] = "Vous n'avez pas accès à cette zone";
            header('Location: /');
            exit;
        }
    }
}