<!-- on commence et on termine la vue par ob_start() et ob_get_clean() 
on met en place la temporisation de sortie :
on va stocker tout ce qui est entre ces deux fonctions, tout le contenu dans une variable $contenu-->
<?php  
ob_start(); ?>


<table>
    <thead>
        <tr>
            <th>TITRE</th>
            <th>DATE SORTIE (France)</th>
            <th>DUREE (mn)</th>
            <th>SYNOPSIS</th>
            <th>NOTE</th>

        </tr>
    </thead>
    <tbody>
        <?php
        foreach($requetefilm->fetchAll() as $film) { ?>
            <tr>
                <td><?= $film["titre_film"] ?></td>
                <td><?= $film["dateFilm"] ?></td>
                <td><?= $film["duree_mn_film"] ?></td>
                <td><?= $film["synopsis_film"] ?></td>
                <td><?= $film["note_film"] ?></td>
            </tr>
    <?php } ?>
    </tbody>
</table>

<table>
    <thead>
            <tr>
                <th>GENRE(S)</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach($requetefilmGenre->fetchAll() as $genre) { ?>
                <tr>
                    <td> <a href="index.php?action=detailGenre&id=<?=$genre['id_genre'] ?> "> <?= $genre["nom_genre"] ?> </a></td>
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
                    <td> <a href="index.php?action=detailRole&id=<?=$casting['id_role']?>" > <?= $casting["nom_role"] ?> </a></td>
                    <td> <a href="index.php?action=detailActeur&id=<?=$casting['id_acteur']?>" > <?= $casting["acteur_actrice"]?> </a></td>
                </tr>
        <?php } ?>
        </tbody>
</table>


<?php

$titre = "Détail de " . $film["titre_film"] ;
$titre_secondaire = "Détail de " . $film["titre_film"];
$contenu = ob_get_clean();

require "view/template.php";