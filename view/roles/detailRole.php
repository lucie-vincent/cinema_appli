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
            <th>FILM</th>

        </tr>
        <tr>
    </thead>
    <tbody>
        <?php
        foreach($requete->fetchAll() as $role) { ?>
            <tr>
                <td><?= $role["nom_personnage"] ?></td>
                <td><?= $role["description"] ?></td>
                <td><a href="index.php?action=detailFilm&id=<?=$role['id_film']?>"> <?= $role["titre_film"] ?> </a></td>
            </tr>
    <?php } ?>
    </tbody>
</table>


<?php

$titre = "Détail de " . $role["nom_personnage"] ;
$titre_secondaire = "Détail de " . $role["nom_personnage"];
$contenu = ob_get_clean();

require "view/template.php";