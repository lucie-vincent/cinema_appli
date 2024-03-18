<?php
namespace Controller;
use Model\Connect;

class GenreController{
    // lister les genres
    public function listGenres() {
        $pdo = Connect::seConnecter();
        $requete = $pdo->query("
            SELECT genre_film.nom_genre, genre_film.id_genre
            FROM genre_film
            ORDER BY genre_film.nom_genre ASC
        ");

        require "view/genres/listGenres.php";
    }

    // détail d'un genre 
    public function detailGenre($id) {
        $pdo = Connect::seConnecter();
        // afficher les détails du genre
        $requeteGenre = $pdo->prepare("
            SELECT genre_film.nom_genre, genre_film.description_genre, genre_film.id_genre
            FROM genre_film
            WHERE genre_film.id_genre = :id
        ");
        $requeteGenre->execute([":id"=>$id]);

        // afficher la liste des films de ce genre
        $requeteFilms = $pdo->prepare("
            SELECT	genre_film.id_genre, genre_film.nom_genre, 
                film.id_film, film.titre_film, YEAR(film.date_sortie_france_film) AS anneeFilm
            FROM film
                INNER JOIN definir ON film.id_film = definir.id_film
                INNER JOIN genre_film ON  definir.id_genre = genre_film.id_genre
            WHERE genre_film.id_genre = :id
            ORDER BY date_sortie_france_film desc 
        ");
        $requeteFilms->execute([":id"=>$id]);

        require "view/genres/detailGenre.php";

    }

    // ajouter un genre
    public function ajouterGenre()  {
        // si on détecte le submit if(isset($_POST["submit"]))
        if(isset($_POST["submit"])) {
            // alors on se connecte à la base de données
            $pdo = Connect::seConnecter();

            // on assainit les données transmises
            $nomGenre = filter_input(INPUT_POST, "nomGenre", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $descriptionGenre = filter_input(INPUT_POST, "descriptionGenre", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // si le filtre est valide, on fait les requêtes
            if($nomGenre && $descriptionGenre) {
                // on prépare la requête
                $requeteAjoutGenre =$pdo->prepare("
                INSERT INTO genre_film (nom_genre, description_genre)
                VALUES (:nomGenre, :descriptionGenre)
                ");
                $requeteAjoutGenre->execute([
                    ":nomGenre" => $nomGenre,
                    ":descriptionGenre" => $descriptionGenre
                ]);
            }
        }

        require "view/genres/ajouterGenre.php";
    }

}