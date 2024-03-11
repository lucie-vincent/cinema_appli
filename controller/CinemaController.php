<?php
// on déclare le namespace ("dossier")
namespace Controller;
// permet d'utiliser la classe d'un autre "dossier" : la classe Connect dans le namespace Model
use Model\Connect;

class CinemaController {

    // -------------
    // --- films ---
    // -------------

    // lister les films
    public function listFilms() {
        // on fait appel à la fonction seConnecter dans le namespace Connect (=Connect.php)
        $pdo = Connect::seConnecter();
        // on exécute la requête
        // on peut utiliser le query car comme il n'y a pas de variables il n'ya pas
        // d'injections possible
        $requete = $pdo->query("
            SELECT * 
            FROM film
        ");

        // on relie la vue qui nous intéresse, dans le dossier view
        require "view/films/listFilms.php";
    }

    // détail d'un film
    public function detailFilm($id) {
        // on fait appel à la fonction seConnecter dans le nameSpace Connect (=Connect.php)
        $pdo = Connect::seConnecter();
        // afficher les infos du films
        // on prepare la requête 
        // cette fois on a besoin de préparer puis d'exécuter la requête pour éviter
        // les injections SQL. Il peut y avoir une injection car une variable est utilisée 
        // ":id"
        $requetefilm = $pdo->prepare("
        SELECT  film.titre_film, film.date_sortie_france_film, film.duree_mn_film, 
                film.synopsis_film, film.note_film,
                genre_film.nom_genre
        FROM film
            INNER JOIN definir ON film.id_film = definir.id_film
            INNER JOIN genre_film ON definir.id_genre = genre_film.id_genre
        WHERE film.id_film = :id
        ");
        // on exécute la requête
        $requetefilm->execute([":id" => $id]);

        //afficher le genre
        $requetefilmGenre = $pdo->prepare("
        SELECT genre_film.nom_genre
        FROM genre_film
	        INNER JOIN definir ON genre_film.id_genre = definir.id_genre
	        INNER JOIN film ON definir.id_film = film.id_film
        WHERE film.id_film = :id
        ");

        $requetefilmGenre->execute([":id" => $id]);

        //afficher le casting
        $requeteCasting = $pdo->prepare("
            SELECT  role.nom_personnage, 
                    CONCAT(personne.prenom_personne, ' ', personne.nom_personne) AS acteur_actrice
            FROM role
                INNER JOIN jouer ON role.id_role = jouer.id_role
                INNER JOIN film ON jouer.id_film = film.id_film
                INNER JOIN acteur ON jouer.id_acteur = acteur.id_acteur
                INNER JOIN personne ON acteur.id_personne = personne.id_personne
            WHERE film.id_film = :id
        ");
        // on exécute la requête
        $requeteCasting->execute([":id" => $id]);


        // on relie la vue qui nous intéressent dans le dossier view
        require "view/films/detailFilm.php";
    }

    // -------------
    // --- genres ---
    // -------------

    // lister les genres
    public function listGenres() {
        $pdo = Connect::seConnecter();
        $requete = $pdo->query("
            SELECT nom_genre
            FROM genre_film
        ");

        require "view/genres/listGenres.php";
    }

    // détail d'un genre 
    public function detailGenre($id) {
        $pdo = Connect::seConnecter();
        $requete = $pdo->prepare("
            SELECT genre_film.nom_genre
            FROM genre_film
            WHERE genre_film.id_genre = :id
        ");
        $requete->execute([":id"=>$id]);

        require "view/genres/detailGenre.php";

    }

    // -------------
    // --- acteurs ---
    // -------------

    // lister les acteurs
    public function listActeurs() {
        $pdo = Connect::seConnecter();
        $requete = $pdo->query("
        SELECT	* , CONCAT(personne.prenom_personne, ' ', personne.nom_personne) AS acteur_actrice
        FROM personne
        INNER JOIN acteur ON personne.id_personne = acteur.id_personne
        ");

        require "view/acteurs/listActeurs.php";
    }

    // détail d'un acteur
    public function detailActeur($id) {
        $pdo = Connect::seConnecter();
        $requete = $pdo->prepare("
            SELECT  CONCAT(personne.prenom_personne, ' ', personne.nom_personne) AS 
                    acteur_actrice, personne.sexe_personne, personne.date_naissance_personne,
                    personne.pays_naissance, personne.lieu_habitation, personne.informations_personnelles
            FROM personne
                INNER JOIN acteur ON personne.id_personne = acteur.id_personne
            WHERE acteur.id_acteur =  :id
        ");
        $requete->execute([":id"=>$id]);

        require "view/acteurs/detailActeur.php";
    }

    // --------------------
    // --- réalisateurs ---
    // --------------------


    // lister les réalisateurs
    public function listRealisateurs() {
        $pdo = Connect::seConnecter();
        $requete = $pdo->query("
            SELECT	*, CONCAT(personne.prenom_personne, ' ', personne.nom_personne) AS realisateur_realisatrice
            FROM personne
                INNER JOIN acteur ON personne.id_personne = acteur.id_acteur
        ");

        require "view/realisateurs/listRealisateurs.php";
    }

    // détail d'un réalisateur
    public function detailRealisateur($id) {
        $pdo = Connect::seConnecter();
        $requete = $pdo->prepare("
            SELECT  CONCAT(personne.prenom_personne, ' ', personne.nom_personne) AS 
                    realisateur_realisatrice,
                    personne.sexe_personne, personne.date_naissance_personne,
                    personne.pays_naissance, personne.lieu_habitation, 
                    personne.informations_personnelles
            FROM personne
	            INNER JOIN realisateur ON personne.id_personne = realisateur.id_personne
            WHERE realisateur.id_realisateur = :id
        ");
        $requete->execute([":id"=>$id]);

        require "view/realisateurs/detailRealisateur.php";
    }

    // -------------
    // --- rôles ---
    // -------------

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

        require "view/roles/listRoles.php";
    }

    // détail d'un rôle
    public function detailRole($id) {
        $pdo = Connect::seConnecter();
        $requete = $pdo->prepare("
            SELECT role.nom_personnage, film.titre_film
            FROM role
                INNER JOIN jouer ON role.id_role = jouer.id_role
                INNER JOIN film ON jouer.id_film = film.id_film
            WHERE role.id_role = :id
        ");
        $requete->execute([":id"=>$id]);

        require "view/roles/detailRole.php";
    }

    // ajout d'un rôle
    public function ajouterRole() {
        // echo "test";
        $pdo = Connect::seConnecter();
        $requete = $pdo->prepare("
        // requete
        ");
        // $requete->execute();

        require "view/roles/ajoutRole.php";
    }
  

}