<?php ob_start(); ?>

<p> Il y a <?= $requete->rowCount() ?> genres </p>


<ul>
    <?php foreach($requete->fetchAll() as $genre) { ?>
        <li>
            <a href="index.php?action=detailGenre&id=<?=$genre['id_genre']?>"> <?= $genre["nom_genre"] ?> </a>
        </li>
        <?php } ?>
</ul>

<?php

$titre = "Liste des genres";
$titre_secondaire = "Liste des genres";
$contenu = ob_get_clean();

require "view/template.php";