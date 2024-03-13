<!-- on commence et on termine la vue par ob_start() et ob_get_clean() 
on met en place la temporisation de sortie :
on va stocker tout ce qui est entre ces deux fonctions, tout le contenu dans une variable $contenu-->
<?php  
ob_start(); ?>


<table>
    <thead>
        <tr>
            <th>NOM DU PERSONNAGE</th>
            <th>INFOS</th>
            <th>ACTEUR/ACTRICE</th>
            <th>FILM</th>

        </tr>
        <tr>
    </thead>
    <tbody>
        <?php
        foreach($requete->fetchAll() as $role) { ?>
            <tr>
                <td><?= $role["nom_role"] ?></td>
                <td><?= $role["description_role"] ?></td>
                <td><a href="index.php?action=detailActeur&id=<?=$role['id_acteur']?>"> <?= $role["acteur_actrice"]?> </a></td>
                <td><a href="index.php?action=detailFilm&id=<?=$role['id_film']?>"> <?= $role["titre_film"]?> (<?= $role["annee_sortie"]?>) </a></td>
            </tr>
    <?php } ?>
    </tbody>
</table>


<?php

$titre = "Détail de " . $role["nom_role"] ;
$titre_secondaire = "Détail de " . $role["nom_role"];
$contenu = ob_get_clean();

require "view/template.php";