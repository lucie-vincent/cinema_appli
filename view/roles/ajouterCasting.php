<?php ob_start() ?>


<h2>
    Sélectionner le rôle, l'acteur et le film correspondants
</h2>

<?php 
$roles = $requeteRoles->fetchAll();
$acteurs = $requeteActeurs->fetchAll();
$films = $requeteFilms->fetchAll();
?>

<form action="index.php?action=ajouterCasting" method="POST" >
    <select name="roles" id="roles" required>
        <?php
            foreach($roles as $role) { ?>
                <option value="<?= $role["id_role"] ?>">
                    <?= $role["titre_film"] ?>
                </option>
        <?php } ?>
    </select><br>

    <select name="acteurs" id="acteurs" required>
        <?php
            foreach($acteurs as $acteur) { ?>
                <option value="<?= $acteur["id_acteur"] ?>">
                    <?= $acteur["titre_film"] ?>
                </option>
        <?php } ?>
    </select><br>

    <select name="films" id="films" required>
        <?php
            foreach($films as $film) { ?>
                <option value="<?= $film["id_film"] ?>">
                    <?= $film["titre_film"] ?>
                </option>
        <?php } ?>
    </select><br>


</form>


<?php
$titre = "Ajouter un casting";
$titre_secondaire = "";

$contenu = ob_get_clean();

require "view/template.php";