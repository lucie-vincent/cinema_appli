<?php ob_start(); ?>

<p> Il y a <?= $requete->rowCount() ?> réalisateurs </p>

<table>
    <thead>
        <tr>
            <th>Prénom Nom</th>
            <th>date de naissance</th>
        <tr>
    </thead>
    <tbody>
        <?php
        foreach($requete->fetchAll() as $realisateur) { ?>
            <tr>
                <td><?= $realisateur["realisateur_realisatrice"] ?></td>
                <td><?= $realisateur["date_naissance_personne"] ?></td>
            </tr>
    <?php } ?>
    </tbody>
</table>


<?php

$titre = "Liste de réalisateurs";
$titre_secondaire = "Liste de réalisateurs";
$contenu = ob_get_clean();

require "view/template.php";