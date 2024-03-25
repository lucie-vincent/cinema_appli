<?php

namespace Controller;
use Model\Connect;

class CastingController{
    // ajout d'un casting
    public function ajouterCasting() {
        // on se connecte à la BDD
        $pdo = Connect::seConnecter();
        // on fait les requêtes pour sortir les listes de roles, acteurs et films et pourvoir les insérer dans les select + options
        $requeteRoles = $pdo->query("
            SELECT role.id_role, role.nom_role
            FROM role
            ORDER BY role.nom_role
        ");

        $requeteActeurs = $pdo->query("
            SELECT	acteur.id_acteur, acteur.id_personne,
                    CONCAT(personne.prenom_personne, ' ', personne.nom_personne) 
                    AS acteur_actrice
            FROM acteur
                INNER JOIN personne ON acteur.id_personne = personne.id_personne
            ORDER BY personne.nom_personne
        ");

        $requeteFilms = $pdo->query("
            SELECT film.id_film, film.titre_film
            FROM film
            ORDER BY film.titre_film
        ");
        
        // on traite les données soumises
        if(isset($_POST["submit"])) { 
            // on assainit
            $roles = filter_input(INPUT_POST, "roles", FILTER_VALIDATE_INT);
            $acteurs = filter_input(INPUT_POST, "acteurs", FILTER_VALIDATE_INT);
            $films = filter_input(INPUT_POST, "films", FILTER_VALIDATE_INT);

            // une fois assainit, on implémente la requête d'insertion
            if($roles && $acteurs && $films){

                // on prépare la requête comme il y a des paramètres
                $requeteAjoutCasting = $pdo->prepare("
                    INSERT INTO jouer (id_role, id_acteur, id_film)
                    VALUES (:roles, :acteurs, :films)
                ");
                // on exécute la requête
                $requeteAjoutCasting->execute([
                    "roles"=>$roles,
                    "acteurs"=>$acteurs,
                    "films"=>$films
                ]);
            }

            header('Location: index.php?action=listRoles');
            die();
        }

        require "view/casting/ajouterCasting.php";

    }

    // ----------------------------------------------------------------------------------

    // supprimer un casting
    public function supprimerCasting($id) {
        // var_dump($id);die;
        // on se connecte à la BDD
        $pdo = Connect::seConnecter();
        
        $arrayIds = explode(',',$id);
        $id_film = $arrayIds[0];
        $id_acteur = $arrayIds[1];
        $id_role = $arrayIds[2];

        // on prépare et on exécute la requête de suppression
        $requeteDeleteCasting = $pdo->prepare("
            DELETE FROM jouer
            WHERE id_film = :id_film 
            AND id_acteur = :id_acteur
            AND id_role = :id_role
        ");

        $requeteDeleteCasting->execute([
            "id_film" => $id_film,
            "id_acteur" => $id_acteur,
            "id_role" => $id_role
        ]);
        
        require "view/films/modifierFilm.php";
    }
  
}