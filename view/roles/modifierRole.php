<?php
ob_start();
$role = $requeteInfosRole->fetch();
?>

<form action="index.php?action=modifierRole&id=<?= $role["id_role"] ?>" method="POST" >
    <label for="nomRole">Nom du personnage :</label>
    <input type="text" name="nomRole" id="nomRole" value="<?= $role["nom_role"] ?>" >
    <br>

    <label for="descriptionRole">Description :</label>
    <textarea name="descriptionRole" id="descriptionRole" cols="30" rows="10" >   
        <?= $role["description_role"] ?>
    </textarea>
    <br>
    
    <input type="submit" name="submit" value="Modifier" >

</form>

<?php
$titre = "Modifier le rôle";
$titre_secondaire = "Modifier le rôle";
$contenu = ob_get_clean();

require "view/template.php";