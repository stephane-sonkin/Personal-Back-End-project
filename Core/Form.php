<?php

namespace App\Core;

class Form {

    private $formCode = '';


    /**
     * genère le formulaire HTML
     *
     * @return string
     */
    public function create() {

        return $this->formCode;
    }


    /**
     * valide si tous les champs proposés sont remplis
     *
     * @param array $form tableau issu du formulaire ($_POST, $_GET)
     * @param array $champs tableau lisant des champs obligatoires
     * @return bool
     */
    public static function validate(array $form, array $champs) {

        // parcourt les champs
        foreach($champs as $champ) {

            // si le champs est vide ou absent dans le formulaire
            if(!isset($form[$champ]) || empty($form[$champ])){

                // on sort en retournant false
                return false;
            }
        }
        return true;
    }


    /**
     * Ajoute les attributs envoyés à la balise
     *
     * @param array $attribut tableau associatif ['class' => 'form-control', 
     * 'required' => true]
     * @return string chaine de caracteres générée
     */
    private function aujoutAttribut(array $attributs):string {

        // on initialise une chaine de caracteres
        $str = '';

        // on liste les attributs "courts"
        $court = ['checked', 'disabled', 'readonly', 'multiple', 
        'autofocus', 'novalidate', 'formnovalidate'];

        // on boucle sur le tableau d'attributs
        foreach($attributs as $attribut => $valeur) {

            // si l'attribut est dans la liste des attributs courts
            if(in_array($attribut, $court) && $valeur == true) {

                $str .= " $attribut";
            }else{

                // on ajoute attribut = "valeur"
                $str .= " $attribut=\"$valeur\"";
            }
        }

        return $str;

    }


    /**
     * Balise d'ouverture du formulaire
     *
     * @param string $method methode du formulaire ('POST' ou 'GET')
     * @param string $action action du formulaire 
     * @param array $attributs attributs
     * @return form
     */
    public function debutForm(string $method = 'post', string $action = '#', 
    array $attributs = []):self {

        // on cree la balise form 
        $this->formCode .= "<form action='$action' method='$method'";

        // on ajoute les attributs eventuels
        $this->formCode .= $attributs ? $this->aujoutAttribut($attributs).'>' : '>';


        return $this;
    }



    /**
     * Balise de fermeture du formulaire
     *
     * @return form
     */
    public function finForm():self{

        $this->formCode .= '</form>';
        return $this;
    }


    /**
     * Ajout de label
     *
     * @param string $for
     * @param string $text
     * @param array $attributs
     * @return self
     */
    public function ajoutLabelFor(string $for, string $text, array $attributs = []):self{

        // on ouvre la balise
        $this->formCode .= "<label for='$for'";

        // on ajoute les attributs
        $this->formCode .= $attributs ? $this->aujoutAttribut($attributs) : '';

        // on ajoute le texte
        $this->formCode .= ">$text</label>";

        return $this;
    }



    /**
     * Ajout d'un champ input
     *
     * @param string $type
     * @param string $nom
     * @param array $attributs
     * @return Form
     */
    public function ajoutInput(string $type, string $nom, array $attributs = []):self {

        // on ouvre la balise
        $this->formCode .= "<input type='$type' name='$nom'";

        // on ajoute les attributs
        $this->formCode .= $attributs ? $this->aujoutAttribut($attributs).'>' : '>';
        return $this;
    }



    /**
     * Ajoute un textarea
     *
     * @param string $nom
     * @param string $valeur
     * @param array $attributs
     * @return self
     */
    public function ajoutTextArea(string $nom, string $valeur = '', array $attributs = [])
    :self{

        // on ouvre la balise
        $this->formCode .= "<textarea name='$nom'";

        // on ajoute les attributs
        $this->formCode .= $attributs ? $this->aujoutAttribut($attributs) : '';

        // on ajoute le texte
        $this->formCode .= ">$valeur</textarea>";

        return $this;
    }



    /**
     * Ajoute une liste déroulante
     *
     * @param string $nom Nom du champ
     * @param array $options Liste des options (tableau associatif)
     * @param array $attributs
     * @return Form
     */
    public function ajoutSelect(string $nom, array $options, array $attributs = [])
    :self{

        // on cree le select
        $this->formCode .= "<select name='$nom'";

        // on ajoute les attributs
        $this->formCode .= $attributs ? $this->aujoutAttribut($attributs).'>' : '>';

        // on  ajoute les options
        foreach($options as $valeur => $text) {

            $this->formCode .= "<option value=\"$valeur\">$text</option>";
        }

        // on ferme le select
        $this->formCode .= "</select>";
        
        return $this;
    }



    /**
     * Ajoute un bouton
     *
     * @param string $text
     * @param array $attributs
     * @return Form
     */
    public function ajoutBouton(string $text, array $attributs = [])
    : self {

        // on ouvre le bouton
        $this->formCode .= '<button ';

        // on ajoute les attributs
        $this->formCode .= $attributs ? $this->aujoutAttribut($attributs) : '';

        // on ajoute le text et on ferme
        $this->formCode .= ">$text</button>";

        return $this;
    }
}