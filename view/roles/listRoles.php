<?php ob_start(); ?>

<p> Il y a <?= $requete->rowCount() ?> rôles </p>

<div class="liste">
    <ul>
        <?php foreach($requete->fetchAll() as $role) { ?>
            <li>
                <a href="index.php?action=detailRole&id=<?=$role['id_role']?>"> <?= $role["nom_role"] ?> </a>
            </li>
            <?php } ?>
    </ul>
</div>


<br>

<a href="index.php?action=ajouterRole">Ajouter un rôle</a>

<br>

<a href="index.php?action=ajouterCasting">Ajouter un casting</a>


<?php

$titre = "Liste de rôles";
$titre_secondaire = "Liste de rôles";
$contenu = ob_get_clean();

require "view/template.php";