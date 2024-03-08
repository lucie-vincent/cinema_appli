<?php 
ob_start(); ?>

<p> Il y a <?= $requete->rowCount() ?> acteurs </p>

<table>
    <thead>
        <tr>
            <th>Prénom Nom</th>
            <th>date de naissance</th>
            <tr>
                </thead>
                <tbody>
                    <?php
        foreach($requete->fetchAll() as $acteur) { ?>
            <tr>
                <td><?= $acteur["acteur_actrice"] ?></td>
                <td><?= $acteur["date_naissance_personne"] ?></td>
            </tr>
            <?php } ?>
        </tbody>
</table>
    
    
<?php

$titre = "Liste d'acteurs";
$titre_secondaire = "Liste d'acteurs";
$contenu = ob_get_clean();

require "view/template.php";