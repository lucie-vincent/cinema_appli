<?php
// on déclare le namespace ("dossier")
namespace Controller;
// permet d'utiliser la classe d'un autre "dossier" : la classe Connect dans le namespace Model
use Model\Connect;

class CinemaController {
    // lister les films
    public function listFilms() {
        // on fait appel à la fonction seConnecter dans le namespace Connect (=Connect.php)
        $pdo = Connect::seConnecter();
        // on exécute la requête
        $requete = $pdo->query("
            SELECT titre_film, annee_sortie_film 
            FROM film
        ");
        // on relie la vue qui nous intéresse, dans le dossier view
        require "view/listFilms.php";
    }

    // lister les genres
    public function listGenres() {

        $pdo = Connect::seConnecter();
        $requete = $pdo->query("
            SELECT nom_genre
            FROM genre_film
        ");

        require "view/listGenres.php";
    }

    // lister les acteurs
    public function listActeurs() {

        $pdo = Connect::seConnecter();
        $requete = $pdo->query("
            SELECT	CONCAT(personne.prenom_personne, ' ', personne.nom_personne) AS acteur_actrice
            FROM personne
                INNER JOIN acteur ON personne.id_personne = acteur.id_personne
        ");

        require "view/listActeurs.php";
    }

    // lister les réalisateurs
    public function listRealisateurs() {

        $pdo = Connect::seConnecter();
        $requete = $pdo->query("
            SELECT	CONCAT(personne.prenom_personne, ' ', personne.nom_personne) AS acteur_actrice
            FROM personne
                INNER JOIN acteur ON personne.id_personne = acteur.id_acteur
        ");

        require "view/listRealisateurs.php";
    }

    // lister les rôles
    public function listRoles() {

        $pdo = Connect::seConnecter();
        $requete = $pdo->query("
            SELECT nom_personnage
            FROM role
        ");

        require "view/listRoles.php";
    }

}