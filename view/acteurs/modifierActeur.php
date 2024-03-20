<?php
ob_start();

$acteur = $requeteInfosActeur->fetch();
// var_dump($acteur);
$Fcheck = false ? "checked" : "";
$Mcheck = true ? "checked" : "";

?>


<form action="index.php?action=modifierActeur&id=<?= $acteur["id_acteur"]?>" method="POST" >
    <label for="prenom">Prénom :</label><br>
    <input type="text" name="prenom" id="prenom" value="<?= $acteur["prenom_personne"] ?>" required ><br>

    <label for="nom">Nom :</label><br>
    <input type="text" name="nom" id="nom" value="<?= $acteur["nom_personne"] ?>" required ><br>

    <legend>Genre :</legend>
    <input type="radio" name="genre" id="genreFeminin" value="Féminin" <?= $Fcheck ?>>
    <label for="genreFeminin">Féminin</label><br>
    <input type="radio" name="genre" id="genreMasculin" value="Masculin" <?= $Mcheck ?>>
    <label for="genreMasculin">Masculin</label><br>

    <label for="dateNaissance">Date de naissance :</label><br>
    <input type="date" name="dateNaissance" id="dateNaissance" value="<?= $acteur["date_naissance_personne"]?>" ><br>

    <label for="pays">Pays de naissance :</label><br>
    <input type="text" name="pays" id="pays" value="<?= $acteur["pays_naissance"]?>"><br>

    <label for="habitation">Lieu d'habitation :</label><br>
    <input type="text" name="habitation" id="habitation" value="<?= $acteur["lieu_habitation"] ?>" ><br>

    <label for="infos">Informations personnelles :</label><br>
    <textarea name="infos" id="infos" cols="30" rows="10">
        <?= $acteur["informations_personnelles"] ?>
    </textarea><br>

    <input type="submit" name="submit" value="Modifier" >

</form>


<?php
$titre = "Modifier l'acteur";
$titre_secondaire = "Modifier l'acteur";
$contenu = ob_get_clean();

require "view/template.php";
