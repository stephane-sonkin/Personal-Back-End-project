<?php

namespace App\models;

use App\Core\DB;

class Model extends DB {
    //Table de la base de donées
    protected $table;

    //instance de db
    private $db;

    public function findAll() {

        $query = $this->requette('SELECT * FROM '. $this->table);
        return $query->fetchAll();
    }


    public function findBy(array $criteres) {

        $champs = [];
        $valeurs = [];

        // on boucle pour éclater le table
        foreach($criteres as $champ => $valeur) {
            // SELECT * FROM annonces WHERE actif = ? , AND signale = 0
            // bindValue(1, valeur)
            $champs[] = "$champ = ?";
            $valeurs[] = $valeur;
        }

        // on transforme le tableau "champs" en une chaine de caractères
        $liste_champs = implode(' AND ' , $champs);

        // on execute la requette
        return $this->requette('SELECT * FROM '.$this->table.' WHERE '. $liste_champs, 
        $valeurs)->fetchAll();
    }


    public function find (int $id) {

        return $this->requette("SELECT * FROM  $this->table WHERE id = $id")->
        fetch();
    }


    public function create () {

        $champs = [];
        $inter = [];
        $valeurs = [];

        // on boucle pour éclater le tableau
        foreach($this as $champ => $valeur) {
            // INSERT INTO annonces  (titre, description, actif) VALUES (?, ?, ?)
            // bindValue(1, valeur)
            if ($valeur !== null && $champ != 'db' && $champ != 'table') {

                $champs[] = $champ;
                $inter [] = "?";
                $valeurs[] = $valeur;
            }
        }

        // on transforme le tableau "champs" en une chaine de caractères
        $liste_champs = implode(' , ' , $champs);
        $liste_inter = implode(', ', $inter);


        // on execute la requette
        return $this->requette('INSERT INTO '.$this->table.' ('. $liste_champs. ')
        VALUES('.$liste_inter.')', $valeurs); 

    }

    
    public function update () {
        $champs = [];
        $valeurs = [];

        // on boucle pour éclater le table
        foreach($this as $champ => $valeur) {
            // UPDATE annonces  SET titre = ?, description = ?, actif = ? WHERE id = ?
            if ($valeur != null && $champ != 'db' && $champ != 'table') {

                $champs[] = "$champ = ?";
                $valeurs[] = $valeur;
            }
        }

        $valeurs[] = $this->id;

        // on transforme le tableau "champs" en une chaine de caractères
        $liste_champs = implode(' , ' , $champs);


        // on execute la requette
        return $this->requette('UPDATE '.$this->table.' SET '. $liste_champs. 
        'WHERE id = ?', $valeurs);

    }


    public function delete (int $id) {

        return $this->requette("DELETE FROM {$this->table} WHERE id = ?", [$id]);
    }

    public function requette(string $sql, array $attributs = null) {

        //on recupere l'instance de db
        $this->db = DB::getInstance();

        //on verifie si on a des attributs
        if ($attributs !== null) {

            //requette préparée
            $query = $this->db->prepare($sql);
            $query->execute($attributs);
            return $query;
        }else {

            //requete simple
            return $this->db->query($sql);
        }
    }


    public function hydrate ($donnees) {

        foreach ($donnees as $key => $value) {

            // on recupere le nom du setter correspondant à la clé (key)
            // titre -> setTitre
            $setter = 'set'.ucfirst($key);

            // on verifie si le setter existe
            if (method_exists($this, $setter)) {

                // on appelle le setter
                $this->$setter($value);
            }
        }

        return $this;
    }

}