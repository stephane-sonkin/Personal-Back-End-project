<?php

namespace App\Controllers;

use App\Core\Form;
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

        // on va chercher toutes les annonces actives
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


    /**
     * Ajouter une annonce
     *
     * @return void
     */
    public function ajouter() {
        
        // on verifie si l'utilisateur est connecté
        if(isset($_SESSION['user']) && !empty($_SESSION['user']['id'])) {

            // l'utilisateur est connecté
            // on verifie si le formulaire est complet
            if(Form::validate($_POST, ['titre', 'description'])) {

                // ici le formulaire est complet
                // on se protege contre les failles XSS
                $titre = strip_tags($_POST['titre']);
                $description = strip_tags($_POST['description']);

                // on instancie notre modèle
                $annonce = new AnnoncesModel;

                // on hydrate
                $annonce->setTitre($titre)
                    ->setDescription($description)
                    ->setUsers_id($_SESSION['user']['id']);

                    // on enregistre
                    $annonce->create();

                    // on redirige
                    $_SESSION['message'] = "Votre annonce a été enregistrée 
                    avec succès";
                    header('Location : POO_BD/Public/index.php');
                    exit;
            }else{
                // le formulaire est incomplet
                $_SESSION['erreur'] = !empty($_POST) ? "Le formulaire est incomplet" : '';
                $titre = isset($_POST['titre']) ? strip_tags($_POST['titre']) : '';
                $description = isset($_POST['description']) ? 
                strip_tags($_POST['description']) : '';
            }




            $form = new Form;

            $form->debutForm()
                ->ajoutLabelFor('titre', 'Titre de l\'annonce')
                ->ajoutInput('text', 'titre', [
                    'id' => 'titre', 
                    'class' => 'form-control',
                    'value' => $titre
                ])
                ->ajoutLabelFor('description', 'Texte de l\'annonce')
                ->ajoutTextArea('description', $description, [
                    'id' => 'description', 
                    'class' => 'form-control'
                ])
                ->ajoutBouton('Publier', ['class' => 'btn btn-primary'])
                ->finForm();

                $this->render('annonces/ajouter', ['form_annonces' => $form->create()]);

        }else{
            // là l'utilisateur n'est pas connecté
            $_SESSION['erreur'] = "Vous devez etre connecté pour acceder
            à cette page";
            header('Location : POO_BD/Views/users/login');
            exit;
        }
    }


    /**
     * Modifier une annonce
     * @param int $id
     */
    public function modifier(int $id) {

        // on verifie si l'utilisateur est connecté
        if(isset($_SESSION['user']) && !empty($_SESSION['user']['id'])) {

            // on va verifier si l'annonce existe dans la base
            // on va instancier notre modèle
            $annoncemodel = new AnnoncesModel;

            // on cherche l'annonce avec l'id $id
            $annonce = $annoncemodel->find($id);

            // si l'annonce n'existe pas, on retourne à la liste des annonces
            if(!$annonce) {
                http_response_code(404);
                $_SESSION['erreur'] = "l'annonce recherchée n'existe pas";
                header('Location : POO_BD/Public/index.php/annonces');
                exit;
            }

            // on verifie si l'utilisateur est propriétaire de l'annonce ou admin
            if ($annonce->users_id !== $_SESSION['user']['id']){

                if(!in_array('ROLE_ADMIN', $_SESSION['user']['roles'])) {

                    $_SESSION['erreur'] = "Vous n'avez pas accès à cette page";
                    header('Location : POO_BD/Public/index.php/annonces');
                    exit;
                }
            }
            

            // on traite le formulaire
            if (Form::validate($_POST, ['titre', 'description'])) {

                // on se protège contre les failles XSS
                $titre = strip_tags($_POST['titre']);
                $description = strip_tags($_POST['description']);

                // on va stocker l'annonce
                $annonceModif = new AnnoncesModel;

                // on hydrate
                $annonceModif->setId($annonce->id)
                    ->setTitre($titre)
                    ->setDescription($description);

                // on met à jour l'annonce
                $annonceModif->update();

                // on redirige
                $_SESSION['message'] = "Votre annonce a été modifiée 
                avec succès";
                header('Location : POO_BD/Public/index');
                exit;

            }

            $form = new Form;

            $form->debutForm()
                ->ajoutLabelFor('titre', 'Titre de l\'annonce')
                ->ajoutInput('text', 'titre', [
                    'id' => 'titre', 
                    'class' =>'form-control',
                    'value' => $annonce->titre
                ])
                ->ajoutLabelFor('description', 'Texte de l\'annonce')
                ->ajoutTextArea('description', $annonce->description, [
                    'id' => 'description', 
                    'class' => 'form-control'
                ])
                ->ajoutBouton('Modifier', ['class' => 'btn btn-primary'])
                ->finForm()
            ;

                // on envoie à la vue
                $this->render('annonces/modifier', ['form_edit' => $form->create()]);

        }else{
            // là l'utilisateur n'est pas connecté
            $_SESSION['erreur'] = "Vous devez etre connecté pour acceder
            à cette page";
            header('Location : POO_BD/Views/users/login');
            exit;
        }
        
    }
}