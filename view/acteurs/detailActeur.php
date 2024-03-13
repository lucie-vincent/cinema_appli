<!-- on commence et on termine la vue par ob_start() et ob_get_clean() 
on met en place la temporisation de sortie :
on va stocker tout ce qui est entre ces deux fonctions, tout le contenu dans une variable $contenu-->
<?php  
ob_start(); 

$infosActeur = $requeteActeurs->fetch();
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
            <td><?= $infosActeur["acteur_actrice"] ?></td>
            <td><?= $infosActeur["sexe_personne"] ?></td>
            <td><?= $infosActeur["date_naissance"] ?></td>
            <td><?= $infosActeur["pays_naissance"] ?></td>
            <td><?= $infosActeur["lieu_habitation"] ?></td>
            <td><?= $infosActeur["informations_personnelles"] ?></td>
        </tr>
    </tbody>
</table>

<h2> Filmographie </h2>

<ul>
    <?php foreach($requeteFilms->fetchAll() as $filmographie) { ?>
        <li>
            <a href="index.php?action=detailActeur&id=<?=$filmographie['id_acteur']?>"> <?= $filmographie["titre_film"] ?> (<?= $filmographie["annee_sortie"] ?>) </a>
        </li>
        <?php } ?>
</ul>


<?php

$titre = "Informations concernant " . $infosActeur["acteur_actrice"] ;
$titre_secondaire = "Détail de " . $infosActeur["acteur_actrice"] ;
$contenu = ob_get_clean();

require "view/template.php";