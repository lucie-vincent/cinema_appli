<?php
ob_start(); ?>

<h1>
    Ajouter un rôle
</h1>

<?php
$titre = "Ajouter un rôle";
$titre_secondaire = "Ajouter un rôle";
$contenu = ob_get_clean();

require "view/template.php";

