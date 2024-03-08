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
            SELECT * 
            FROM film
        ");

        // on relie la vue qui nous intéresse, dans le dossier view
        require "view/listFilms.php";
    }

    // détail d'un film
    public function detailFilm($id) {
        // on fait appel à la fonction seConnecter dans le nameSpace Connect (=Connect.php)
        $pdo = Connect::seConnecter();
        // on prepare la requête 
        $requete = $pdo->prepare("
        SELECT  film.titre_film, film.annee_sortie_film, film.duree_mn_film, 
		        film.synopsis_film
        FROM film
        WHERE id_film = :id
        ");
        // on exécute la requête
        $requete->execute(["id" => $id]);

        // on relie la vue qui nous intéressen dans le dossier view
        require "view/films/detailFilm.php";
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
        SELECT	* , CONCAT(personne.prenom_personne, ' ', personne.nom_personne) AS acteur_actrice
        FROM personne
        INNER JOIN acteur ON personne.id_personne = acteur.id_personne
        ");

        require "view/listActeurs.php";
    }

    // lister les réalisateurs
    public function listRealisateurs() {

        $pdo = Connect::seConnecter();
        $requete = $pdo->query("
            SELECT	*, CONCAT(personne.prenom_personne, ' ', personne.nom_personne) AS realisateur_realisatrice
            FROM personne
                INNER JOIN acteur ON personne.id_personne = acteur.id_acteur
        ");

        require "view/listRealisateurs.php";
    }

    // lister les rôles
    public function listRoles() {

        $pdo = Connect::seConnecter();
        $requete = $pdo->query("
        SELECT role.nom_personnage, film.titre_film, CONCAT(personne.prenom_personne, ' ', personne.nom_personne) AS acteur_actrice
            FROM role
					 INNER JOIN jouer ON role.id_role = jouer.id_role
                INNER JOIN acteur ON jouer.id_acteur = acteur.id_acteur
                INNER JOIN personne ON acteur.id_personne = personne.id_personne
                INNER JOIN film ON jouer.id_film = film.id_film
        ");

        require "view/listRoles.php";
    }

}