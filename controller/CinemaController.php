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
        
        // on pense à récupérer l'id dans la requete car permet d'afficher les bonnes pages dans les URL
        $requete = $pdo->query("
            SELECT id_film, titre_film, DATE_FORMAT(date_sortie_france_film, '%d-%m-%Y') AS dateFilm
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
            SELECT film.titre_film, film.date_sortie_france_film, film.duree_mn_film,
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
        ");
        // on exécute la requête
        $requeteCasting->execute([":id" => $id]);


        // on relie la vue qui nous intéresse dans le dossier view
        require "view/films/detailFilm.php";
    }

            // --------------
            // --- genres ---
            // --------------

    // lister les genres
    public function listGenres() {
        $pdo = Connect::seConnecter();
        $requete = $pdo->query("
            SELECT genre_film.nom_genre, genre_film.id_genre
            FROM genre_film
        ");

        require "view/genres/listGenres.php";
    }

    // détail d'un genre 
    public function detailGenre($id) {
        $pdo = Connect::seConnecter();
        $requete = $pdo->prepare("
            SELECT genre_film.nom_genre, genre_film.genre_description, genre_film.id_genre
            FROM genre_film
            WHERE genre_film.id_genre = :id
        ");
        $requete->execute([":id"=>$id]);

        require "view/genres/detailGenre.php";

    }

            // ---------------
            // --- acteurs ---
            // ---------------

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
            SELECT CONCAT(personne.prenom_personne, ' ', personne.nom_personne) AS 
                    realisateur_realisatrice, personne.sexe_personne, personne.date_naissance_personne,
                    realisateur.id_realisateur
            FROM realisateur
            INNER JOIN personne ON realisateur.id_personne = personne.id_personne
        ");

        require "view/realisateurs/listRealisateurs.php";
    }

    // détail d'un réalisateur
    public function detailRealisateur($id) {
        $pdo = Connect::seConnecter();
        // infos réalisateurs
        $requeteRealisateur = $pdo->prepare("
            SELECT  CONCAT(personne.prenom_personne, ' ', personne.nom_personne) AS 
                    realisateur_realisatrice,
                    personne.sexe_personne, personne.date_naissance_personne,
                    personne.pays_naissance, personne.lieu_habitation, 
                    personne.informations_personnelles,
                    realisateur.id_realisateur
            FROM personne
	            INNER JOIN realisateur ON personne.id_personne = realisateur.id_personne
            WHERE realisateur.id_realisateur = :id
        ");
        $requeteRealisateur->execute([":id"=>$id]);

        //filmographie
        $requeteFilmographie = $pdo->prepare("
            SELECT  film.titre_film, film.id_film
            FROM film
                INNER JOIN realisateur ON film.id_realisateur = realisateur.id_realisateur
            WHERE realisateur.id_realisateur = :id
        ");
        $requeteFilmographie->execute([":id"=>$id]);

        require "view/realisateurs/detailRealisateur.php";
    }

            // -------------
            // --- rôles ---
            // -------------

    // lister les rôles
    public function listRoles() {
        $pdo = Connect::seConnecter();
        $requete = $pdo->query("
            SELECT * FROM role
        ");

        require "view/roles/listRoles.php";
    }

    // détail d'un rôle
    public function detailRole($id) {
        $pdo = Connect::seConnecter();
        $requete = $pdo->prepare("
            SELECT  role.nom_role, role.description_role, role.id_role, film.titre_film, 
                    film.id_film, acteur.id_acteur,
                    CONCAT(personne.prenom_personne, ' ', personne.nom_personne) AS acteur_actrice
            FROM role
                INNER JOIN jouer ON role.id_role = jouer.id_role
                INNER JOIN acteur ON jouer.id_acteur = acteur.id_acteur
                INNER JOIN personne ON acteur.id_personne = personne.id_personne
                INNER JOIN film ON jouer.id_film = film.id_film
            WHERE role.id_role =:id


        ");
        $requete->execute([":id"=>$id]);

        require "view/roles/detailRole.php";
    }

    // ajout d'un rôle
    public function ajouterRole() {
        
        // si on détecte le submit '$_POST["submit"])
        if(isset($_POST["submit"])) {
            // alors on se connecte à la base de données
            $pdo = Connect::seConnecter();
            
            // on filtre le champ rôle du formulaire (filter_input)
            $nomRole = filter_input(INPUT_POST, "nomRole", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            // $descriptionRole = filter_input(INPUT_POST, "descriptionRole", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            
            // si le filtre est valide
            if($nomRole) {
                // on prépare la requête d'insertion (INSERT INTO...VALUES)
                $requeteNomRole = $pdo->prepare("
                    INSERT INTO role (nom_role)
                    VALUES (:nomRole);
                ");
                
                // on exécute la requête en faisant passer le tableau d'arguments
                $requeteNomRole->execute([":nomRole"=>$nomRole]);
                
                // on fait la redirection vers la liste des roles (header("Location: index.php..."))
                header('Location: index.php?action=listRoles');
                die();
            }

            // if($descriptionRole) {
            //     $requeteDescriptionRole = $pdo->prepare("
            //     INSERT INTO role (description_role)
            //     VALUES (:descriptionRole);
            //     ");

            //     $requeteDescriptionRole->execute(["descriptionRole"=>$descriptionRole]);
            
            //     header('Location: index.php?action=listRoles');
            //     die();
            // }
        }
        // on relie la vue qui nous intéresse dans le dossier view
        require "view/roles/ajouterRole.php";
    }

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

        require "view/roles/ajouterCasting.php";

    }
  


}