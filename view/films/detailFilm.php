<!-- on commence et on termine la vue par ob_start() et ob_get_clean() 
on met en place la temporisation de sortie :
on va stocker tout ce qui est entre ces deux fonctions, tout le contenu dans une variable $contenu-->
<?php  
ob_start(); ?>


<table>
    <thead>
        <tr>
            <th>TITRE</th>
            <th>ANNEE SORTIE</th>
            <th>DUREE</th>
            <th>SYNOPSIS</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach($requetefilm->fetchAll() as $film) { ?>
            <tr>
                <td><?= $film["titre_film"] ?></td>
                <td><?= $film["annee_sortie_film"] ?></td>
                <td><?= $film["duree_mn_film"] ?></td>
                <td><?= $film["synopsis_film"] ?></td>
            </tr>
    <?php } ?>
    </tbody>
</table>

<table>
    <thead>
            <tr>
                <th>PERSONNAGE</th>
                <th>ACTEUR/ACTRICE</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach($requeteCasting->fetchAll() as $casting) { ?>
                <tr>
                    <td><?= $casting["nom_personnage"] ?></td>
                    <td><?= $casting["acteur_actrice"] ?></td>
                </tr>
        <?php } ?>
        </tbody>
</table>


<?php

$titre = "Détail de " . $film["titre_film"] ;
$titre_secondaire = "Détail de " . $film["titre_film"];
$contenu = ob_get_clean();

require "view/template.php";