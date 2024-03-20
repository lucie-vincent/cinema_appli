<?php

ob_start();

?>

<h2>
    Saisir le nom du genre à ajouter
</h2>

<form action="index.php?action=ajouterGenre" method="POST" >
    <label for="nomGenre">Nom du genre :</label>
    <input type="text" name="nomGenre" id="nomGenre" placeholder="Documentaire"><br>

    <label for="descriptionGenre">Description du genre :</label>
    <textarea name="descriptionGenre" id="descriptionGenre" cols="30" rows="10" 
    placeholder="Un genre de film basé sur la réalité, utilisant des images réelles et des témoignages pour explorer des sujets variés..." ></textarea>
    <br>
    
    <input type="submit" name="submit" value="Ajouter" >
</form>



<?php
$titre = "Ajouter un genre";
$titre_secondaire = "";
$contenu = ob_get_clean();

require "view/template.php";