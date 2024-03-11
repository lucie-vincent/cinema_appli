<?php ob_start(); ?>

<p> Il y a <?= $requete->rowCount() ?> réalisateurs </p>

<table>
    <thead>
        <tr>
            <th>Prénom Nom</th>
            <th>date de naissance</th>
            <th>Genre</th>
        <tr>
    </thead>
    <tbody>
        <?php
        foreach($requete->fetchAll() as $realisateur) { ?>
            <tr>
                <td> <a href="index.php?action=detailRealisateur&id=<?=$realisateur['id_realisateur']?>"> <?= $realisateur["realisateur_realisatrice"] ?> </a></td>
                <td><?= $realisateur["date_naissance_personne"] ?></td>
                <td><?= $realisateur["sexe_personne"] ?></td>
            </tr>
    <?php } ?>
    </tbody>
</table>


<?php

$titre = "Liste de réalisateurs";
$titre_secondaire = "Liste de réalisateurs";
$contenu = ob_get_clean();

require "view/template.php";