<!-- on commence et on termine la vue par ob_start() et ob_get_clean() 
on met en place la temporisation de sortie :
on va stocker tout ce qui est entre ces deux fonctions, tout le contenu dans une variable $contenu-->
<?php  
ob_start(); 
$roleInfos = $requeteRole->fetch();
$casting = $requeteCasting->fetchAll();

?>

<h1><?= $roleInfos["nom_role"] ?></h1>

<?php
    if(count($casting) == 0) {
        echo "Pas de casting pour ce rôle";
    } else { 
?>

    <table>
        <thead>
            <tr>
                <th>INFOS</th>
                <th>ACTEUR/ACTRICE</th>
                <th>FILM</th>

            </tr>
            <tr>
        </thead>
        <tbody>
            <?php
            foreach($casting as $role) { ?>
                <tr>
                    <td><?= $role["description_role"] ?></td>
                    <td><a href="index.php?action=detailActeur&id=<?=$role['id_acteur']?>"> <?= $role["acteur_actrice"]?> </a></td>
                    <td><a href="index.php?action=detailFilm&id=<?=$role['id_film']?>"> <?= $role["titre_film"]?> (<?= $role["annee_sortie"]?>) </a></td>
                </tr>
        <?php } ?>
        </tbody>
    </table>

<?php 
    }
?>

<br>
<a href="index.php?action=modifierRole&id=<?=$roleInfos["id_role"] ?>">Modifier le rôle</a>

<?php

$titre = "Détail de " . $roleInfos["nom_role"] ;
$titre_secondaire = "";
$contenu = ob_get_clean();

require "view/template.php";