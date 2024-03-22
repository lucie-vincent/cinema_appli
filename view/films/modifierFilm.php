<?php
ob_start();

$infosFilm = $requeteInfos->fetch();
$realisateurs = $requeteRealisateurs->fetchAll();
$genres = $requeteGenres->fetchAll();
$acteursFilm = $requeteActeursFilm->fetchAll();
$acteurs = $requeteActeurs->fetchAll();
?>

<form action="index.php?action=modifierFilm&id=<?= $infosFilm["id_film"] ?>" method="POST" >
    <label for="titre" >Titre :</label>
    <input type="text" name="titre" id="titre" value="<?= $infosFilm["titre_film"] ?>" ><br>

    <label for="dateSortie" >Date de sortie en France :</label>
    <input type="date" name="dateSortie" id="dateSortie" value="<?= $infosFilm["date_sortie_france_film"] ?>" ><br>

    <label for="duree" >Durée en minutes :</label>
    <input type="text" name="duree" id="duree" value="<?= $infosFilm["duree_mn_film"] ?>" ><br>

    <label for="synopsis" >Synopsis :</label>
    <textarea name="synopsis" id="synopsis" cols="30" rows="10">
        <?= $infosFilm["synopsis_film"] ?>
    </textarea><br>

    <label for="note" >Note sur 5 :</label>
    <input type="number" name="note" id="note" min="1" max="5" value="<?= $infosFilm["note_film"] ?>" ><br>

    <label for="realisateur">Réalisateur-trice :</label>
    <select name="realisateur" id="realisateur" required >
        <?php
            foreach($realisateurs as $realisateur){ ?>
                    <?php 
                        $isSelected = ($infosFilm["id_realisateur"] == $realisateur["id_realisateur"]) ? 'selected' : ''
                    ?> 
                <option value="<?= $infosFilm["id_realisateur"] ?>" <?= $isSelected ?>>
                    <?= $realisateur["realisateur_realisatrice"] ?> 
                </option>

       <?php  } ?>     
    </select><br>

    <legend>Genre(s) :</legend>
    <?php
        foreach($genres as $genre) { ?>
            <?php $isChecked = ($infosFilm["nom_genre"] == $genre["nom_genre"]) ? 'checked' : '' ?> 
            <input type="checkbox" name="genres[]" 
                    id="<?= $genre["nom_genre"] ?>"
                    value="<?= $genre["id_genre"] ?>" 
                    <?= $isChecked ?> >
            <label for="<?= $genre["nom_genre"] ?>">
                    <?= $genre["nom_genre"] ?>
            </label><br>
    <?php    } ?>

    <div>
        <p>Casting : </p>
        <?php
            foreach($acteursFilm as $acteurCast) { ?>
        <ul>
            <a href="index.php?action=detailActeur&id=<?= $acteurCast["id_acteur"]?>"> <?= $acteurCast["acteur_actrice"] ?> </a> - <a 
            href="index.php?action=detailRole&id=<?= $acteurCast["id_role"] ?>"> <?= $acteurCast["nom_role"] ?> </a>
        </ul>
        <?php } ?>
    </div>

    <div>
        <p>Ajouter un-e acteur-trice : </p>
        <label for="acteur">Acteur-trice :</label>
        <select name="acteur" id="acteur" required >
            <?php
                foreach($acteurs as $acteur){ ?>
                    <option value="<?= $acteur["id_acteur"] ?>">
                        <?= $acteur["acteur_actrice"] ?>
                    </option>

        <?php  } ?>     
        </select><br>
    </div>

    <br>
    <input type="submit" name="submit" value="Ajouter" >
</form>

<?php
$titre = "Modifier un film";
$titre_secondaire = "Modifier un film";
$contenu = ob_get_clean();

require "view/template.php";
