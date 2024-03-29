<!-- on commence et on termine la vue par ob_start() et ob_get_clean() 
on met en place la temporisation de sortie :
on va stocker tout ce qui est entre ces deux fonctions, tout le contenu dans une variable $contenu-->
<?php  
ob_start(); ?>


<p>
    Il y a <?= $requete->rowCount() ?> films
</p>

<table>
    <thead>
        <tr>
            <th>TITRE</th>
            <th>DATE DE SORTIE</th>
        <tr>
    </thead>
    <tbody>
        <?php
        foreach($requete->fetchAll() as $film) { ?>
            <tr>
                <td><a href="index.php?action=detailFilm&id=<?=$film['id_film']?>"> <?= $film["titre_film"] ?> </a></td>
                <td><?= $film["annee_sortie"] ?></td>
            </tr>
    <?php } ?>
    </tbody>
</table>

<br>
<a href="index.php?action=ajouterFilm">Ajouter un film </a>

<?php
$titre = "Liste de films";
$titre_secondaire = "Liste des films";
$contenu = ob_get_clean();

require "view/template.php";