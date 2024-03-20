<?php

namespace Controller;
use Model\Connect;

class RoleController{
    // lister les rôles
    public function listRoles() {
        $pdo = Connect::seConnecter();
        $requete = $pdo->query("
            SELECT * FROM role
            ORDER BY role.nom_role
        ");

        require "view/roles/listRoles.php";
    }

    // --------------------------------------------------

    // détail d'un rôle
    public function detailRole($id) {
        $pdo = Connect::seConnecter();

        $requeteRole = $pdo->prepare("
            SELECT * FROM role
            WHERE id_role = :id
        ");

        $requeteRole->execute([
            "id" => $id
        ]);

        $requeteCasting = $pdo->prepare("
            SELECT  role.description_role, role.id_role, film.titre_film,
                    YEAR(date_sortie_france_film) AS annee_sortie,
                    film.id_film, acteur.id_acteur,
                    CONCAT(personne.prenom_personne, ' ', personne.nom_personne) AS acteur_actrice
            FROM role
                INNER JOIN jouer ON role.id_role = jouer.id_role
                INNER JOIN acteur ON jouer.id_acteur = acteur.id_acteur
                INNER JOIN personne ON acteur.id_personne = personne.id_personne
                INNER JOIN film ON jouer.id_film = film.id_film
            WHERE role.id_role =:id


        ");
        $requeteCasting->execute([":id"=>$id]);

        require "view/roles/detailRole.php";
    }

    // --------------------------------------------------

    // ajout d'un rôle
    public function ajouterRole() {
        
        // si on détecte le submit '$_POST["submit"])
        if(isset($_POST["submit"])) {
            // alors on se connecte à la base de données
            $pdo = Connect::seConnecter();
            
            // on filtre le champ rôle du formulaire (filter_input) = on assainit
            $nomRole = filter_input(INPUT_POST, "nomRole", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $descriptionRole = filter_input(INPUT_POST, "descriptionRole", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            
            // si le filtre est valide
            if($nomRole && $descriptionRole) {
                // on prépare la requête d'insertion (INSERT INTO...VALUES) du nom + description
                $requeteNomRole = $pdo->prepare("
                    INSERT INTO role (nom_role, description_role)
                    VALUES (:nomRole, :descriptionRole);
                ");
                
                // on exécute la requête en faisant passer le tableau d'arguments
                $requeteNomRole->execute([
                    ":nomRole"=>$nomRole,
                    ":descriptionRole"=>$descriptionRole
                ]);
            
                header('Location: index.php?action=listRoles');
                die();
            }

        }
        // on relie la vue qui nous intéresse dans le dossier view
        require "view/roles/ajouterRole.php";
    }

    // --------------------------------------------------

    public function modifierRole($id) {
        $pdo = Connect::seConnecter();
        $requeteInfosRole = $pdo->prepare("
            SELECT nom_role, description_role, id_role
            FROM role 
            WHERE id_role = :id
        ");
        $requeteInfosRole->execute([
            ":id" => $id
        ]);
        

        if(isset($_POST["submit"])) {
            $nomRole = filter_input(INPUT_POST, "nomRole", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $descriptionRole = filter_input(INPUT_POST, "descriptionRole", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            
            if($nomRole && $descriptionRole) {
                $requeteModifRole = $pdo->prepare("
                    UPDATE role
                    SET nom_role = :nomRole,
                        description_role = :descriptionRole
                    WHERE id_role = :id
                ");

                $requeteModifRole->execute([
                    ":nomRole" => $nomRole,
                    ":descriptionRole" => $descriptionRole,
                    ":id" => $id
                ]);
            }
        
            header("Location:index.php?action=listRoles");
            die();
        
        }

        require "view/roles/modifierRole.php";
    }

}