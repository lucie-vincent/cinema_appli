<?php
namespace Controller;
use Model\Connect;

class ActeurController {
    // lister les acteurs
    public function listActeurs() {
        $pdo = Connect::seConnecter();
        $requete = $pdo->query("
            SELECT DATE_FORMAT(date_naissance_personne, '%d-%m-%Y') AS date_naissance, sexe_personne, id_acteur, CONCAT(personne.prenom_personne, ' ', personne.nom_personne) AS acteur_actrice
            FROM personne
            INNER JOIN acteur ON personne.id_personne = acteur.id_personne
            ORDER BY acteur_actrice ASC
        ");

        require "view/acteurs/listActeurs.php";
    }

    // --------------------------------------------------

    // détail d'un acteur
    public function detailActeur($id) {
        $pdo = Connect::seConnecter();
        // la requête pour afficher le détail de l'acteur
        $requeteActeurs = $pdo->prepare("
            SELECT  CONCAT(personne.prenom_personne, ' ', personne.nom_personne) AS 
                    acteur_actrice, personne.sexe_personne,  
                    DATE_FORMAT(personne.date_naissance_personne, '%d-%m-%Y') AS date_naissance,
                    personne.pays_naissance, personne.lieu_habitation, personne.informations_personnelles,
                    acteur.id_acteur
            FROM personne
                INNER JOIN acteur ON personne.id_personne = acteur.id_personne
            WHERE acteur.id_acteur =  :id
        ");
        $requeteActeurs->execute([":id"=>$id]);

        // la requête pour afficher la filmographie de l'acteur
        $requeteFilms = $pdo->prepare("
            SELECT  film.titre_film, film.id_film, 
                    YEAR(film.date_sortie_france_film) AS annee_sortie,
                    acteur.id_acteur
            FROM film
                INNER JOIN jouer ON film.id_film = jouer.id_film
                INNER JOIN acteur ON jouer.id_acteur = acteur.id_acteur
            WHERE acteur.id_acteur = :id
            ORDER BY film.date_sortie_france_film DESC 
        ");
        $requeteFilms->execute([":id"=>$id]);

        require "view/acteurs/detailActeur.php";
    }

    // --------------------------------------------------

    // ajouter acteur 
    public function ajouterActeur() {
        if(isset($_POST["submit"])){
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
                        ":nom" => $nom,
                        ":genre" => $genre,
                        ":dateNaissance" => $dateNaissance,
                        ":pays" => $pays,
                        ":habitation" => $habitation,
                        ":infos" => $infos
                    ]);

                    $id_personne = $pdo->lastInsertId();
                    $requeteAjoutActeur = $pdo->prepare(
                        "INSERT INTO acteur (id_personne)
                        VALUES (:id_personne)"
                    );
                    $requeteAjoutActeur->execute([
                        ":id_personne" => $id_personne
                    ]);

                    header('Location:index.php?action=listActeurs');
                    die();
                }
        }
        require "view/acteurs/ajouterActeur.php";
    }

    // --------------------------------------------------

    // modifier un acteur
    public function modifierActeur($id) {
        $pdo = Connect::seConnecter();

        $requeteInfosActeur = $pdo->prepare("
            SELECT  personne.prenom_personne, personne.nom_personne, personne.sexe_personne, personne.date_naissance_personne, 
                    personne.pays_naissance, personne.lieu_habitation, personne.informations_personnelles,
                    acteur.id_acteur
            FROM personne
                    INNER JOIN acteur ON personne.id_personne = acteur.id_personne
            WHERE acteur.id_acteur = :id
        ");

        $requeteInfosActeur->execute([
            ":id" => $id
        ]);

        if(isset($_POST["submit"])) {
            $prenom         = filter_input(INPUT_POST,"prenom", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $nom            = filter_input(INPUT_POST,"nom", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $genre          = filter_input(INPUT_POST,"genre", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $dateNaissance  = filter_input(INPUT_POST,"dateNaissance", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $pays           = filter_input(INPUT_POST,"pays", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $habitation     = filter_input(INPUT_POST,"habitation", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $infos          = filter_input(INPUT_POST,"infos", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if($prenom && $nom && $genre && $dateNaissance && $pays && $habitation && $infos) {
                $requeteModifActeur = $pdo->prepare("
                    UPDATE personne AS p
                        INNER JOIN acteur a ON p.id_personne = a.id_personne
                    SET 	p.prenom_personne = :prenom,
                        p.nom_personne = :nom,
                        p.sexe_personne = :genre, 
                        p.date_naissance_personne = :dateNaissance, 
                        p.pays_naissance = :pays, 
                        p.lieu_habitation = :habitation, 
                        p.informations_personnelles = :infos
                    WHERE a.id_acteur = :id
                ");

                $requeteModifActeur->execute([
                    ":prenom" => $prenom,
                    ":nom" => $nom,
                    ":genre" => $genre,
                    ":dateNaissance" => $dateNaissance,
                    ":pays" => $pays,
                    ":habitation" => $habitation,
                    ":infos" => $infos,
                    ":id" => $id
                ]);
            }

            header("Location:index.php?action=listActeurs");
            die();
        }

        require "view/acteurs/modifierActeur.php";
    }

    // --------------------------------------------------

    //  supprimer un acteur
    public function supprimerActeur($id) {
        $pdo = Connect::seConnecter();

        // on supprime de la table jouer à cause des contraintes
        $requeteDeleteJouer = $pdo->prepare("
            DELETE FROM jouer
            WHERE id_acteur = :id
        ");

        $requeteDeleteJouer->execute([
            ":id" => $id
        ]);

        // on supprime de la table acteur
        $requeteDeleteActeur = $pdo->prepare("
            DELETE FROM acteur
            WHERE id_acteur = :id
        ");

        $requeteDeleteActeur->execute([
            ":id" => $id
        ]);

        header('Location:index.php?action=listActeurs');
        
        require "view/acteurs/detailActeur.php";
    }
}