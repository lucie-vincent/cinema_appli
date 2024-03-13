<!-- on commence et on termine la vue par ob_start() et ob_get_clean() 
on met en place la temporisation de sortie :
on va stocker tout ce qui est entre ces deux fonctions, tout le contenu dans une variable $contenu-->
<?php  
ob_start(); ?>


<table>
    <thead>
        <tr>
            <th>NOM DU GENRE</th>
            <th>DESCRPTION</th>
        </tr>
        <tr>
    </thead>
    <tbody>
        <?php
        foreach($requeteGenre->fetchAll() as $genre) { ?>
            <tr>
                <td><?= $genre["nom_genre"] ?></td>
                <td><?= $genre["genre_description"] ?></td>
            </tr>
    <?php } ?>
    </tbody>
</table>

<h2> Liste des films </h2>

<ul>
    <?php foreach($requeteFilms->fetchAll() as $filmographie) { ?>
        <li>
            <a href="index.php?action=detailFilm&id=<?=$filmographie['id_film']?>"> <?= $filmographie["titre_film"] ?> (<?= $filmographie['anneeFilm']?>)</a>
        </li>
        <?php } ?>
</ul>


<?php

$titre = "Détail de " . $genre["nom_genre"] ;
$titre_secondaire = "Détail de " . $genre["nom_genre"];
$contenu = ob_get_clean();

require "view/template.php";