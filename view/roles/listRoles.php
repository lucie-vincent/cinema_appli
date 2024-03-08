<?php ob_start(); ?>

<p> Il y a <?= $requete->rowCount() ?> rôles </p>

<table>
    <thead>
        <tr>
            <th>Acteur/Actrice</th>
            <th>Nom du personnage</th>
            <th>Film</th>
        <tr>
    </thead>
    <tbody>
        <?php
        foreach($requete->fetchAll() as $role) { ?>
            <tr>
                <td><?= $role["acteur_actrice"] ?></td>
                <td><?= $role["nom_personnage"] ?></td>
                <td><?= $role["titre_film"] ?></td>
            </tr>
    <?php } ?>
    </tbody>
</table>


<?php

$titre = "Liste de réalisateurs";
$titre_secondaire = "Liste de réalisateurs";
$contenu = ob_get_clean();

require "view/template.php";