<?php
ob_start(); ?>

<h2>
    Saisir le nom du rôle à ajouter
</h2>

<form action="index.php?action=ajouterRole" method="POST" >
    <label for="nomRole">Nom du personnage :</label>
    <input type="text" name="nomRole" id="nomRole" placeholder="Marguerite de CARROUGES" required >
    <br>
    <label for="desc">Description :</label>
    <textarea name="" id="desc" cols="30" rows="10"></textarea>
    <input type="submit" name="submit" value="Ajouter" >

</form>

<?php
$titre = "Ajouter un rôle";
$titre_secondaire = "";
$contenu = ob_get_clean();

require "view/template.php";

