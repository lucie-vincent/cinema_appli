<?php

namespace Controller;
use Model\Connect;

class RealisateurController{
     // lister les réalisateurs
     public function listRealisateurs() {
        $pdo = Connect::seConnecter();
        $requete = $pdo->query("
            SELECT CONCAT(personne.prenom_personne, ' ', personne.nom_personne) AS 
                    realisateur_realisatrice, personne.sexe_personne, DATE_FORMAT(personne.date_naissance_personne, '%d-%m-%Y') AS date_naissance,
                    realisateur.id_realisateur
            FROM realisateur
            INNER JOIN personne ON realisateur.id_personne = personne.id_personne
            ORDER BY personne.nom_personne ASC
        ");

        require "view/realisateurs/listRealisateurs.php";
    }

    // --------------------------------------------------

    // détail d'un réalisateur
    public function detailRealisateur($id) {
        $pdo = Connect::seConnecter();
        // infos réalisateurs
        $requeteRealisateur = $pdo->prepare("
            SELECT  CONCAT(personne.prenom_personne, ' ', personne.nom_personne) AS 
                    realisateur_realisatrice,
                    personne.sexe_personne, DATE_FORMAT(personne.date_naissance_personne, '%d-%m-%Y') AS date_naissance,
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
            SELECT  film.titre_film, YEAR(film.date_sortie_france_film) AS annee_sortie, 
                    film.id_film
            FROM film
                INNER JOIN realisateur ON film.id_realisateur = realisateur.id_realisateur
            WHERE realisateur.id_realisateur = :id
            ORDER BY film.date_sortie_france_film DESC
        ");
        $requeteFilmographie->execute([":id"=>$id]);

        require "view/realisateurs/detailRealisateur.php";
    }

    // --------------------------------------------------

    // ajouter un réalisateur
    public function ajouterRealisateur(){
        if(isset($_POST["submit"])) {
            $pdo = Connect::seConnecter();

            $prenom         = filter_input(INPUT_POST,"prenom", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $nom            = filter_input(INPUT_POST,"nom", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $genre          = filter_input(INPUT_POST,"genre", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $dateNaissance  = filter_input(INPUT_POST,"dateNaissance", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $pays           = filter_input(INPUT_POST,"pays", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $habitation     = filter_input(INPUT_POST,"habitation", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $infos          = filter_input(INPUT_POST,"infos", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            
            if($prenom && $nom && $genre && $dateNaissance 
                && $pays && $habitation && $infos) {
                    $requeteAjoutPersonne = $pdo->prepare("
                        INSERT INTO personne (prenom_personne, nom_personne, 
                                        sexe_personne, date_naissance_personne, 
                                        pays_naissance, lieu_habitation, 
                                        informations_personnelles)
                            VALUES (:prenom, :nom, :genre, :dateNaissance,
                                    :pays, :habitation, :infos)
                    ");

                    $requeteAjoutPersonne->execute([
                        ":prenom" => $prenom,
                        ":nom"  => $nom,
                        ":genre" => $genre,
                        ":dateNaissance" => $dateNaissance,
                        ":pays" => $pays,
                        ":habitation" => $habitation,
                        ":infos" => $infos
                    ]);

                    $id_personne = $pdo->lastInsertId();

                    $requeteAjoutRealisateur = $pdo->prepare("
                        INSERT INTO realisateur (id_personne)
                            VALUES (:id_personne)
                    ");

                    $requeteAjoutRealisateur->execute([
                        ":id_personne" => $id_personne
                    ]);

                    // header('Location:index.php?action=listRealisateurs');
                    // die();

                }

        }
        require "view/realisateurs/ajouterRealisateur.php";
    }
}