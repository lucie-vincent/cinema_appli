<?php
ob_start();
$genre = $requeteInfosGenre->fetch();
?>

<form action="index.php?action=modifierGenre&id=<?= $genre["id_genre"] ?>" method="POST" >

    <label for="nomGenre">Nom du genre :</label>
    <input type="text" name="nomGenre" id="nomGenre" value="<?= $genre["nom_genre"] ?>"><br>

    <label for="descriptionGenre">Description du genre :</label>
    <textarea name="descriptionGenre" id="descriptionGenre" cols="30" rows="10" >
        <?= $genre["description_genre"] ?>
    </textarea>
    <br>
    
    <input type="submit" name="submit" value="Modifier" >
</form>


<?php
$titre = "Modifier le genre";
$titre_secondaire = "Modifier le genre";
$contenu = ob_get_clean();

require "view/template.php";
?>