<?php

ob_start();
?>

<form action="index.php?action=AjouterActeur" method="POST" >
    <label for="prenom">Prénom :</label><br>
    <input type="text" name="prenom" id="prenom" required ><br>

    <label for="nom">Nom :</label><br>
    <input type="text" name="nom" id="nom" required ><br>

    <legend>Genre :</legend>
    <input type="radio" name="genre" id="genreFeminin" value="Féminin" checked >
    <label for="genreFeminin">Féminin</label><br>
    <input type="radio" name="genre" id="genreMasculin" value="Masculin">
    <label for="genreMasculin">Masculin</label><br>

    <label for="dateNaissance">Date de naissance :</label><br>
    <input type="date" name="dateNaissance" id="dateNaissance" ><br>

    <label for="pays">Pays de naissance :</label><br>
    <input type="text" name="pays" id="pays" ><br>

    <label for="adresse">Lieu d'habitation :</label><br>
    <input type="text" name="adresse" id="adresse" ><br>

    <label for="infos">Informations personnelles :</label><br>
    <textarea name="infos" id="infos" cols="30" rows="10"></textarea><br>

    <input type="submit" value="Ajouter" >

</form>


<?php
$titre = "Ajouter un acteur";
$titre_secondaire = "Ajouter un acteur";
$contenu = ob_get_clean();

require "view/template.php";
