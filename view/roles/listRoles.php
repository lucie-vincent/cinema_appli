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
                <td> <a href="index.php?action=detailActeur&id=<?=$role['id_acteur']?>"> <?= $role["acteur_actrice"] ?> </a> </td>
                <td> <a href="index.php?action=detailRole&id=<?=$role['id_role']?>"> <?= $role["nom_personnage"] ?> </a></td>
                <td> <a href="index.php?action=detailFilm&id=<?=$role['id_film']?>"> <?= $role["titre_film"] ?> </a></td>
            </tr>
    <?php } ?>
    </tbody>
</table>

<br>

<a href="index.php?action=ajoutRole">Ajouter un rôle</a>


<?php

$titre = "Liste de rôles";
$titre_secondaire = "Liste de rôles";
$contenu = ob_get_clean();

require "view/template.php";