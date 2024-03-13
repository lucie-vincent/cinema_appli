<!-- on commence et on termine la vue par ob_start() et ob_get_clean() 
on met en place la temporisation de sortie :
on va stocker tout ce qui est entre ces deux fonctions, tout le contenu dans une variable $contenu-->
<?php  
ob_start(); ?>

<table>
    <thead>
        <tr>
            <th>PRENOM NOM</th>
            <th>GENRE</th>
            <th>DATE DE NAISSANCE</th>
            <th>PAYS DE NAISSANCE</th>
            <th>LIEU D'HABITATION</th>
            <th>INFORMATIONS PERSONNELLES</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach($requeteRealisateur->fetchAll() as $realisateur) { ?>
            <tr>
                <td><?= $realisateur["realisateur_realisatrice"] ?></td>
                <td><?= $realisateur["sexe_personne"] ?></td>
                <td><?= $realisateur["date_naissance"] ?></td>
                <td><?= $realisateur["pays_naissance"] ?></td>
                <td><?= $realisateur["lieu_habitation"] ?></td>
                <td><?= $realisateur["informations_personnelles"] ?></td>
            </tr>
    <?php } ?>
    </tbody>
</table>

<h2> Filmographie </h2>

<ul>
    <?php foreach($requeteFilmographie->fetchAll() as $filmographie) { ?>
        <li>
            <a href="index.php?action=detailGenre&id=<?=$filmographie['id_film']?>"> <?= $filmographie["titre_film"] ?> (<?= $filmographie["annee_sortie"] ?>) </a>
        </li>
        <?php } ?>
</ul>

<?php

$titre = "Information concernant " . $realisateur["realisateur_realisatrice"] ;
$titre_secondaire = "Détail de " . $realisateur["realisateur_realisatrice"] ;
$contenu = ob_get_clean();

require "view/template.php";