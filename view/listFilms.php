<!-- on commence et on termine la vue par ob_start() et ob_get_clean() 
on met en place la temporisation de sortie :
on va stocker tout ce qui est entre ces deux fonctions, tout le contenu dans une variable $contenu-->
<?php  ob_start(); ?>


<p class="uk-label uk-label-warning">
    Il y a <?= $requetes->rowCount() ?> films
</p>

<table class="uk-table uk-table-stripped">
    <thead>
        <tr>
            <th>TITRE</th>
            <th>ANNEE SORTIE</th>
        <tr>
    </thead>
    <tbody>
        <?php
        foreach($requete->fetchAll() as $film) { ?>
            <tr>
                <td><?= $film["titre_film"] ?></td>
                <td><?= $film["anne_sortie_film"] ?></td>
            </tr>
    <?php } ?>
    </tbody>
</table>


<?php

$titre = "Liste de films";
$titre_secondaire = "Liste des films";
$contenu = ob_get_clean();

require "view/template.php";