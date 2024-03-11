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
        foreach($requete->fetchAll() as $acteur) { ?>
            <tr>
                <td><?= $acteur["acteur_actrice"] ?></td>
                <td><?= $acteur["sexe_personne"] ?></td>
                <td><?= $acteur["date_naissance_personne"] ?></td>
                <td><?= $acteur["pays_naissance"] ?></td>
                <td><?= $acteur["lieu_habitation"] ?></td>
                <td><?= $acteur["informations_personnelles"] ?></td>
            </tr>
    <?php } ?>
    </tbody>
</table>

<?php

$titre = "Information concernant " . $acteur["acteur_actrice"] ;
$titre_secondaire = "Détail de " . $acteur["acteur_actrice"] ;
$contenu = ob_get_clean();

require "view/template.php";