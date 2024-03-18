<?php
ob_start();
?>


<?php
$titre = "Ajouter un réalisateur";
$titre_secondaire = "Ajouter un réalisateur";
$contenu = ob_get_clean();

require "view/template.php";