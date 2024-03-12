<?php
ob_start(); ?>

<h2>
    Saisir le nom du rôle à ajouter
</h2>

<form action="index.php?action=ajouterRole" method="POST" >
    <label for="nomRole">Nom du personnage :</label>
    <input type="text" name="nomRole" id="nomRole" placeholder="Marguerite de CARROUGES" required >
    <br>
    <!-- <label for="">Description :</label>
    <input type="text" name="descriptionRole" id="descriptionRole" placeholder="Une femme noble et ..." required >
    <br> -->
    <input type="submit" name="submit" value="Ajouter" >

</form>

<?php
$titre = "Ajouter un rôle";
$titre_secondaire = "";
$contenu = ob_get_clean();

require "view/template.php";

