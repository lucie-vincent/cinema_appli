<?php
ob_start();

$genres = $requeteGenres->fetchAll();
$film = $requeteFilm->fetch();

?>

<form action="index.php?action=associerGenre" method="POST" >
    <select name="genres" id="genres" required >
        <?php
            foreach($genres as $genre){ ?>
                <option value="<?= $genre["id_genre"] ?>">
                    <?= $genre["nom_genre"] ?>
                </option>
        <?php } ?>
    </select><br>

    <select name="films" id="films" required >
        <?php
            foreach($film as $filmSelected){ ?>
                <option value="<?= $filmSelected["id_film"] ?>">
                    <?= $filmSelected["titre_film"] ?>
                </option>
        <?php } ?>
    </select><br>

    <input type="submit" name="submit" value="Associer" >
</form>


<?php
$titre = "Associer un genre";
$titre_secondaire = "Associer un genre";
$contenu = ob_get_clean();

require "view/template.php";