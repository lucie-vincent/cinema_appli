<?php
ob_start();
$realisateurs = $requeteRealisateurs->fetchAll();
$genres = $requeteGenres->fetchAll();
?>

<form action="index.php?action=ajouterFilm" method="POST" >
    <label for="titre" >Titre :</label>
    <input type="text" name="titre" id="titre"><br>

    <label for="dateSortie" >Date de sortie en France :</label>
    <input type="date" name="dateSortie" id="dateSortie" ><br>

    <label for="duree" >Durée en minutes :</label>
    <input type="text" name="duree" id="duree" ><br>

    <label for="synopsis" >Synopsis :</label>
    <textarea name="synopsis" id="synopsis" cols="30" rows="10"></textarea><br>

    <label for="note" >Note sur 5 :</label>
    <input type="number" name="note" id="note" min="1" max="5"><br>

    <label for="realisateur">Réalisateur :</label>
    <select name="realisateur" id="realisateur" required >
        <?php
            foreach($realisateurs as $realisateur){ ?>
                <option value="<?= $realisateur["id_realisateur"] ?>">
                    <?= $realisateur["realisateur_realisatrice"] ?>
                </option>

       <?php  } ?>     
    </select><br>

    <legend>Genre(s) :</legend>
        <?php
            foreach($genres as $genre) { ?>
                <input type="checkbox" name="genres[]" 
                        id="<?= $genre["nom_genre"] ?>"
                        value="<?= $genre["id_genre"] ?> ">
                <label for="<?= $genre["nom_genre"] ?>">
                        <?= $genre["nom_genre"] ?>
                </label><br>
        <?php    } ?>
</form>

<?php
$titre = "Ajouter un film";
$titre_secondaire = "Ajouter un film";
$contenu = ob_get_clean();

require "view/template.php";
