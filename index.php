<?php
// index va servir à accueillir l'action transmise par l'URL (en GET -> voir Appli_PHP)

// on use le controller Cinema
use Controller\CinemaController;

// on autocharge les classes du projet
spl_autoload_register(function($class_name) {
    include $class_name . '.php';
});
// on instancie le controller Cinema
$ctrlCinema = new CinemaController();

$id = (isset($_GET["id"])) ? $_GET["id"] : null; 

if(isset($_GET["action"])) {
    switch ($_GET["action"]) {
        // Films
        case "listFilms"        : $ctrlCinema->listFilms();             break;
        case "detailFilm"       : $ctrlCinema->detailFilm($id);         break;
        // Genres
        case "listGenres"       : $ctrlCinema->listGenres();            break;
        case "detailGenre"      : $ctrlCinema->detailGenre($id);        break;
        // Acteurs
        case "listActeurs"      : $ctrlCinema->listActeurs();           break;
        case "detailActeur"     : $ctrlCinema->detailActeur($id);       break;
        // Réalisateurs
        case "listRealisateurs" : $ctrlCinema->listRealisateurs();      break;
        case "detailRealisateur": $ctrlCinema->detailRealisateur($id);  break;
        // Rôles
        case "listRoles"        : $ctrlCinema->listRoles();             break;
        case "detailRole"       : $ctrlCinema->detailRole($id);         break;
        case "ajouterRole"      : $ctrlCinema->ajouterRole();           break;
        case "ajouterCasting"   : $ctrlCinema->ajouterCasting();        break;
    }
} else {
    $ctrlCinema->listFilms();
}

