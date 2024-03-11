<?php 
ob_start(); ?>

<p> Il y a <?= $requete->rowCount() ?> acteurs </p>

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
        foreach($requete->fetchAll() as $acteur) { ?>
            <tr>
                <td><a href="index.php?action=detailActeur&id=<?=$acteur['id_acteur']?>"> <?= $acteur["acteur_actrice"] ?> </a></td>
                <td><?= $acteur["date_naissance_personne"] ?></td>
                <td><?= $acteur["sexe_personne"] ?></td>
            </tr>
            <?php } ?>
        </tbody>
</table>
    
    
<?php

$titre = "Liste d'acteurs";
$titre_secondaire = "Liste d'acteurs";
$contenu = ob_get_clean();

require "view/template.php";