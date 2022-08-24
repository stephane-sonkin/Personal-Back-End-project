<?php

namespace App\Controllers;

use App\Core\Form;
use App\Models\UsersModel;

class UsersController extends Controller {


    /**
     * Users connexion
     *
     * @return void
     */
    public function login() {
        
        // on verifie si le formulaire est complet
        if (Form::validate($_POST, ['email', 'password'])) {
            // le formulaire est complet
            // on va chercher dans la base de données l'utilisateur avec l'email entré
            $userModel = new UsersModel;
            $userArray = $userModel->findOneByEmail(strip_tags($_POST['email']));

            // si l'utilisateur n'existe pas
            if(!$userArray) {

                // on envoie un message de session
                $_SESSION['erreur'] = "L'adresse e-mail et/ou le mot de passe est incorect";
            }

            // ici l'utilisateur existe
            $user = $userModel->hydrate($userArray);
            
            // on verifie si le mot de passe est correct
            if(password_verify($_POST['password'], $user->getPassword())){
                // le mot de passe est bon
                // on crée la session
                $user->setSession();
                header('Location : POO_BD/Public/index.php/annonces/');
                exit;
            }else{

                //mauvais mot de passe
                $_SESSION['erreur'] = "L'adresse e-mail et/ou le mot de passe est incorect";
                exit;
            }

        }

        
        $form = new Form;

        $form->debutForm()
            ->ajoutLabelFor('email', 'E-mail :')
            ->ajoutInput('email', 'email', ['class' => 'form-control', 'id' => 'email'])
            ->ajoutLabelFor('pass', 'Mot de passe :')
            ->ajoutInput('password', 'password', ['id' => 'pass', 'class' => 
            'form-control'])
            ->ajoutBouton('Me connecter', ['class' => 'btn btn-primary'])
            ->finForm();

        $this->render('users/login', ['loginForm' => $form->create()]);
    }


    /**
     * Users registration
     *
     * @return void
     */
    public function register() {

        // On verifie si le formulaire est valide
        if(Form::validate($_POST, ['email', 'password'])) {

            // Le formulaire est valide
            // On "nettoie" l'adresse mail
            $email = strip_tags($_POST['email']);

            // on choffre le mot de passe
            $pass = password_hash($_POST['password'], PASSWORD_ARGON2I);

            // on hydrate l'utilisateur
            $user = new UsersModel;

            $user->setEmail($email)
                ->setPassword($pass);

            // on stocke l'utilisateur
            $user->create();

        }

        $form = new Form;

        $form->debutForm()
            ->ajoutLabelFor("email", "E-mail :")
            ->ajoutInput('email', 'email', ['id' => 'mail', 'class' => 'form-control'])
            ->ajoutLabelFor('pass', 'Mot de passe :')
            ->ajoutInput('password', 'password', ['id' => 'pass', 'class' => 'form-control'])
            ->ajoutBouton("M'inscrire", ['class' => 'btn btn-primary'])
            ->finForm();

            $this->render('users/register', ['registerForm' => $form->create()]);

    }


    /**
     * Déconnexion de l'utilisateur
     *
     * @return exit
     */
    public function logout() {
        unset($_SESSION['user']);
        header('Location : '. $_SERVER['HTTP_REFERER']);
        exit;
    }
}