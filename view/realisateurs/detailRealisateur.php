<!-- on commence et on termine la vue par ob_start() et ob_get_clean() 
on met en place la temporisation de sortie :
on va stocker tout ce qui est entre ces deux fonctions, tout le contenu dans une variable $contenu-->
<?php  
ob_start(); 

$infosRealisateur = $requeteRealisateur->fetch();
?>

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
        <tr>
            <td><?= $infosRealisateur["realisateur_realisatrice"] ?></td>
            <td><?= $infosRealisateur["sexe_personne"] ?></td>
            <td><?= $infosRealisateur["date_naissance"] ?></td>
            <td><?= $infosRealisateur["pays_naissance"] ?></td>
            <td><?= $infosRealisateur["lieu_habitation"] ?></td>
            <td><?= $infosRealisateur["informations_personnelles"] ?></td>
        </tr>
    </tbody>
</table>

<h2> Filmographie </h2>

<ul>
    <?php foreach($requeteFilmographie->fetchAll() as $filmographie) { ?>
        <li>
            <a href="index.php?action=detailFilm&id=<?=$filmographie['id_film']?>"> <?= $filmographie["titre_film"] ?> (<?= $filmographie["annee_sortie"] ?>) </a>
        </li>
        <?php } ?>
</ul>

<?php

$titre = "Information concernant " . $infosRealisateur["realisateur_realisatrice"] ;
$titre_secondaire = "Détail de " . $infosRealisateur["realisateur_realisatrice"] ;
$contenu = ob_get_clean();

require "view/template.php";