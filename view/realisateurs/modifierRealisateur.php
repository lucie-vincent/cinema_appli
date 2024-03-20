<?php
ob_start();
$realisateur = $requeteInfosRealisateur->fetch();
?>

<form action="index.php?action=modifierRealisateur&id=<?= $realisateur["id_realisateur"] ?>" method="POST" >
    <label for="prenom">Prénom :</label><br>
    <input type="text" name="prenom" id="prenom" value="<?= $realisateur["prenom_personne"] ?>" required ><br>

    <label for="nom">Nom :</label><br>
    <input type="text" name="nom" id="nom" value="<?= $realisateur["nom_personne"] ?>" required ><br>

    <legend>Genre :</legend>
    <input type="radio" name="genre" id="genreFeminin" value="Féminin" checked >
    <label for="genreFeminin">Féminin</label><br>
    <input type="radio" name="genre" id="genreMasculin" value="Masculin">
    <label for="genreMasculin">Masculin</label><br>

    <label for="dateNaissance">Date de naissance :</label><br>
    <input type="date" name="dateNaissance" id="dateNaissance" value="<?= $realisateur["date_naissance_personne"] ?>" ><br>

    <label for="pays">Pays de naissance :</label><br>
    <input type="text" name="pays" id="pays"  value="<?= $realisateur["pays_naissance"] ?>" ><br>

    <label for="habitation">Lieu d'habitation :</label><br>
    <input type="text" name="habitation" id="habitation" value="<?= $realisateur["lieu_habitation"] ?>" ><br>

    <label for="infos">Informations personnelles :</label><br>
    <textarea name="infos" id="infos" cols="30" rows="10">
        <?= $realisateur["informations_personnelles"] ?>
    </textarea><br>

    <input type="submit" name="submit" value="Modifier" >

</form>


<?php
$titre = "Modifier le réalisateur";
$titre_secondaire = "Modifier le réalisateur";
$contenu = ob_get_clean();

require "view/template.php";
