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

    // --------------------------------------------------

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
            SELECT	film.id_film, film.titre_film, 
                    DATE_FORMAT(date_sortie_france_film, '%d-%m-%Y') AS dateFilm, 
                    film.duree_mn_film, film.synopsis_film, film.note_film, film.id_realisateur,
                    CONCAT(personne.prenom_personne, ' ', personne.nom_personne) AS realisateur_realisatrice	
            FROM film
                INNER JOIN realisateur ON film.id_realisateur = realisateur.id_realisateur
                INNER JOIN personne ON realisateur.id_personne = personne.id_personne
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

    // --------------------------------------------------

    // ajouter un film
    public function ajouterFilm(){
        // on se connecte à la BDD
        $pdo = Connect::seConnecter();
        // on effectue la requête pour lister les réalisateurs
        $requeteRealisateurs = $pdo->query("
            SELECT realisateur.id_realisateur, 
                    CONCAT(personne.prenom_personne, ' ', personne.nom_personne) 
                        AS realisateur_realisatrice
            FROM realisateur
                INNER JOIN personne ON realisateur.id_personne = personne.id_personne 
            ORDER BY realisateur_realisatrice ASC 
        ");
        // on effectue la requête pour lister les genres
        $requeteGenres = $pdo->query("
            SELECT genre_film.id_genre, genre_film.nom_genre
            FROM genre_film
            ORDER BY genre_film.nom_genre ASC 
        ");

        // on vérifie la soumission
        if(isset($_POST["submit"])){
            // on traite les données soumises
            $titre = filter_input(INPUT_POST,"titre", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $dateSortie = filter_input(INPUT_POST, "dateSortie", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $duree = filter_input(INPUT_POST, "duree", FILTER_VALIDATE_INT);
            $synopsis = filter_input(INPUT_POST, "synopsis", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $note = filter_input(INPUT_POST, "note", FILTER_VALIDATE_INT);
            $realisateur = filter_input(INPUT_POST, "realisateur", FILTER_VALIDATE_INT);
            // les genres sont transmis sous forme de tableau, d'où les filtres
            $genres = filter_input(INPUT_POST, "genres", FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            // on vérifie la réussite des filtres
            if($titre && $dateSortie && $duree && $synopsis && 
                $note && $realisateur && $genres){
                    // on prépare la requête pour l'ajout dans la table film
                    $requeteFilm = $pdo->prepare("
                        INSERT INTO film (titre_film, date_sortie_france_film, 
                                        duree_mn_film, synopsis_film, note_film, 
                                        id_realisateur, affiche_film)
                        VALUES ( :titre, :dateSortie, :duree, :synopsis, :note,
                                :realisateur, '')
                    ");

                    $requeteFilm->execute([
                        ":titre" => $titre,
                        ":dateSortie" => $dateSortie,
                        ":duree" => $duree,
                        ":synopsis" => $synopsis,
                        ":note" => $note,
                        ":realisateur" => $realisateur
                    ]);

                    // on prépare la requête pour l'ajout dans la table film
                    // on utilise lastInsertId car on veut récupérer l'id du film ajouté
                    // précédemment
                    $id_film = $pdo->lastInsertId();

                    foreach($genres as $genre) {
                        $requeteGenres = $pdo->prepare("
                            INSERT INTO definir (id_film, id_genre)
                            VALUES (:id_film, :id_genre)
                        ");

                        $requeteGenres->execute([
                            ":id_film" => $id_film,
                            ":id_genre" => $genre
                        ]);

                    }

                }
                
                header('Location:index.php?action=listFilms');
                die();
        }

        require "view/films/ajouterFilm.php";
    }

    // --------------------------------------------------

    public function modifierFilm($id) {
        $pdo = Connect::seConnecter();
        // requête pour afficher les infos du film
        $requeteInfos = $pdo->prepare("
            SELECT	film.id_film, film.titre_film, film.date_sortie_france_film, 
                    film.duree_mn_film, film.synopsis_film, film.note_film, film.id_realisateur,
                    CONCAT(personne.prenom_personne, ' ', personne.nom_personne) AS realisateur_realisatrice,
                    genre_film.nom_genre
            FROM film
                INNER JOIN realisateur ON film.id_realisateur = realisateur.id_realisateur
                INNER JOIN personne ON realisateur.id_personne = personne.id_personne
                INNER JOIN definir ON film.id_film = definir.id_film
                INNER JOIN genre_film ON definir.id_genre = genre_film.id_genre
            WHERE film.id_film = :id
        ");

        $requeteInfos->execute([
            ":id" => $id
        ]);

        // requête pour lister les réalisateur
        $requeteRealisateurs = $pdo->query("
            SELECT realisateur.id_realisateur, CONCAT(personne.prenom_personne, ' ', personne.nom_personne) AS realisateur_realisatrice, personne.id_personne
            FROM realisateur
                INNER JOIN personne ON realisateur.id_personne = personne.id_personne
        ");

        // requête pour lister les genres
        $requeteGenres = $pdo->query("
            SELECT genre_film.id_genre, genre_film.nom_genre
            FROM genre_film
        ");

        // requête pour lister les acteurs + rôles du film
        $requeteActeursFilm = $pdo->prepare("
            SELECT  CONCAT(personne.prenom_personne, ' ', personne.nom_personne) AS acteur_actrice,
                    acteur.id_acteur,
                    role.nom_role, role.id_role
            FROM personne
                INNER JOIN acteur ON personne.id_personne = acteur.id_personne
                INNER JOIN jouer ON acteur.id_acteur = jouer.id_acteur
                INNER JOIN film ON jouer.id_film = film.id_film
                INNER JOIN role ON jouer.id_role = role.id_role
            WHERE film.id_film = :id
        ");
        $requeteActeursFilm->execute([
            ":id" => $id
        ]);

        // requête pour lister tous les acteurs
        // $requeteActeurs = $pdo->query("
        //     SELECT  CONCAT(personne.prenom_personne, ' ', personne.nom_personne) AS acteur_actrice,
        //             acteur.id_acteur, personne.id_personne
        //     FROM personne
        //         INNER JOIN acteur ON personne.id_personne = acteur.id_personne
        // ");

        if(isset($_POST["submit"])) {
            $titre = filter_input(INPUT_POST,"titre", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $dateSortie = filter_input(INPUT_POST,"dateSortie", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $duree = filter_input(INPUT_POST,"duree", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $synopsis = filter_input(INPUT_POST,"synopsis", FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
            $note = filter_input(INPUT_POST,"note", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $realisateur = filter_input(INPUT_POST,"realisateur", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            // les genres cochés sont transmis sous forme de tableau : 
                //d'où les filtres + le foreach par la suite
            $genres = filter_input(INPUT_POST, "genres", FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            
            // on fait les modifications des infos
            if( $titre && $dateSortie && $duree && $synopsis && $note && $realisateur && $genres) {
                // requete pour les infos
                $requeteModifsInfos = $pdo->prepare("
                    UPDATE film
                        INNER JOIN realisateur ON film.id_realisateur = realisateur.id_realisateur
                        INNER JOIN personne ON realisateur.id_personne = personne.id_personne
                    SET	titre_film = :titre,
                        date_sortie_france_film = :dateSortie,
                        duree_mn_film = :duree,
                        synopsis_film = :synopsis,
                        note_film = :note,
                        film.id_realisateur = :realisateur
                    WHERE id_film = :id
                ");

                $requeteModifsInfos->execute([
                    ":titre" => $titre,
                    ":dateSortie" => $dateSortie,
                    ":duree" => $duree,
                    ":synopsis" => $synopsis,
                    ":note" => $note,
                    ":realisateur" => $realisateur,
                    ":id" => $id
                ]);

                // requetes pour les genres 
                // requete pour supprimer les genres
                $requeteReinitialiserGenre = $pdo->prepare("
                    DELETE FROM definir
                    WHERE id_film = :id
                ");

                $requeteReinitialiserGenre->execute([
                    ":id" => $id
                ]);

                // requete pour ajouter les genres
                foreach($genres as $genre) {
                    $requeteModifGenre = $pdo->prepare("
                        INSERT INTO definir (id_film, id_genre)
                        VALUES (:id_film, :id_genre)
                    ");

                    $requeteModifGenre->execute([
                        ":id_film" => $id,
                        ":id_genre" => $genre
                    ]);

                }

            }

            header("Location:index.php?action=detailFilm&id=". $id);
            die();

        }

        require "view/films/modifierFilm.php";
    }

    // --------------------------------------------------

    // supprimer un film
    public function supprimerFilm($id) {
        $pdo = Connect::seConnecter();

        // on supprime de la table définir 
        $requeteDeleteDefinir = $pdo->prepare("
            DELETE FROM definir
            WHERE id_film = :id
        ");

        $requeteDeleteDefinir->execute([
            ":id" => $id
        ]);

        // on supprime de la table film 
        $requeteDeleteFilm = $pdo->prepare("
            DELETE FROM film
            WHERE id_film = :id
        ");

        $requeteDeleteFilm->execute([
            ":id" => $id
        ]);

        header('Location:index.php?action=listFilms');
        die();

    }
    

}