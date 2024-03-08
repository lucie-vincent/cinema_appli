<!-- on commence et on termine la vue par ob_start() et ob_get_clean() 
on met en place la temporisation de sortie :
on va stocker tout ce qui est entre ces deux fonctions, tout le contenu dans une variable $contenu-->
<?php  
ob_start(); ?>


<table>
    <thead>
        <tr>
            <th>NOM DU GENRE</th>
            <!-- <th>INFOS</th> -->

        </tr>
        <tr>
    </thead>
    <tbody>
        <?php
        foreach($requete->fetchAll() as $genre) { ?>
            <tr>
                <td><?= $genre["nom_genre"] ?></td>
                <!-- <td><?= $film["infos_genre"] ?></td> -->
            </tr>
    <?php } ?>
    </tbody>
</table>


<?php

$titre = "Détail de " . $genre["nom_genre"] ;
$titre_secondaire = "Détail de " . $genre["nom_genre"];
$contenu = ob_get_clean();

require "view/template.php";