<?php
// on déclare le namespace 
namespace Controller;
// on use le namespace Model pour pouvoir se connecter à la BDD
use Model\Connect;

class FilmController{
    // lister les films
    public function listFilms() {
        // on fait appel à la fonction seConnecter dans le namespace Connect (=Connect.php)
        $pdo = Connect::seConnecter();
        // on exécute la requête
        // on peut utiliser le query car comme il n'y a pas de variables il n'ya pas
        // d'injections possible
        
        // on pense à récupérer l'id dans la requete car permet d'afficher les bonnes pages dans les URL
        $requete = $pdo->query("
            SELECT id_film, titre_film, YEAR(date_sortie_france_film) AS annee_sortie
            FROM film
            ORDER BY film.titre_film ASC
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
            SELECT film.titre_film, DATE_FORMAT(date_sortie_france_film, '%d-%m-%Y') AS dateFilm, film.duree_mn_film,
            film.synopsis_film, film.note_film, film.id_film
            FROM film
            WHERE film.id_film = :id
        ");
        // on exécute la requête
        $requetefilm->execute([":id" => $id]);

        //afficher le genre
        $requetefilmGenre = $pdo->prepare("
            SELECT genre_film.nom_genre, genre_film.id_genre
            FROM genre_film
                INNER JOIN definir ON genre_film.id_genre = definir.id_genre
                INNER JOIN film ON definir.id_film = film.id_film
            WHERE film.id_film = :id
            ORDER BY genre_film.nom_genre ASC
        ");

        $requetefilmGenre->execute([":id" => $id]);

        //afficher le casting
        $requeteCasting = $pdo->prepare("
            SELECT  role.nom_role, role.id_role,
                    CONCAT(personne.prenom_personne, ' ', personne.nom_personne) AS acteur_actrice,
                    acteur.id_acteur
            FROM role
                INNER JOIN jouer ON role.id_role = jouer.id_role
                INNER JOIN film ON jouer.id_film = film.id_film
                INNER JOIN acteur ON jouer.id_acteur = acteur.id_acteur
                INNER JOIN personne ON acteur.id_personne = personne.id_personne
            WHERE film.id_film = :id
            ORDER BY role.nom_role DESC
        ");
        // on exécute la requête
        $requeteCasting->execute([":id" => $id]);


        // on relie la vue qui nous intéresse dans le dossier view
        require "view/films/detailFilm.php";
    }
}