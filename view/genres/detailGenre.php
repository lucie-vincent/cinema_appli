<!-- on commence et on termine la vue par ob_start() et ob_get_clean() 
on met en place la temporisation de sortie :
on va stocker tout ce qui est entre ces deux fonctions, tout le contenu dans une variable $contenu-->
<?php  
ob_start();

$infosGenre = $requeteGenre->fetch();
$listeFilms = $requeteFilms->fetchAll();

if(count($listeFilms) == 0) {
    echo "Pas de films associés à ce genre";
} else {

?>

<table>
    <thead>
        <tr>
            <th>NOM DU GENRE</th>
            <th>DESCRPTION</th>
        </tr>
        <tr>
    </thead>
    <tbody>
        <tr>
            <td><?= $infosGenre["nom_genre"] ?></td>
            <td><?= $infosGenre["genre_description"] ?></td>
        </tr>    
</tbody>
</table>

<h2> Liste des films </h2>

<ul>
    <?php foreach($listeFilms as $filmographie) { ?>
        <li>
            <a href="index.php?action=detailFilm&id=<?=$filmographie['id_film']?>"> <?= $filmographie["titre_film"] ?> (<?= $filmographie['anneeFilm']?>)</a>
        </li>
        <?php } ?>
</ul>

<?php

}

?>

<?php

$titre = "Détail de " . $infosGenre["nom_genre"] ;
$titre_secondaire = "Détail de " . $infosGenre["nom_genre"];
$contenu = ob_get_clean();

require "view/template.php";