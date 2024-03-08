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
            <!-- <th>INFOS PERSONNELLES</th> -->
        </tr>
    </thead>
    <tbody>
        <?php
        foreach($requete->fetchAll() as $realisateur) { ?>
            <tr>
                <td><?= $realisateur["realisateur_realisatrice"] ?></td>
                <td><?= $realisateur["sexe_personne"] ?></td>
                <td><?= $realisateur["date_naissance_personne"] ?></td>
            </tr>
    <?php } ?>
    </tbody>
</table>

<?php

$titre = "Information concernant " . $realisateur["realisateur_realisatrice"] ;
$titre_secondaire = "Détail de " . $realisateur["realisateur_realisatrice"] ;
$contenu = ob_get_clean();

require "view/template.php";