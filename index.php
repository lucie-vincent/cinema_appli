<?php
// index va servir à accueillir l'action transmise par l'URL (en GET -> voir Appli_PHP)

// on use les controller 
use Controller\CinemaController;
use Controller\FilmController;
use Controller\GenreController;
use Controller\ActeurController;
use Controller\RealisateurController;
use Controller\RoleController;
use Controller\CastingController;

// on autocharge les classes du projet
spl_autoload_register(function($class_name) {
    include $class_name . '.php';
});
// on instancie les controller 
$ctrlCinema         = new CinemaController();
$ctrlFilm           = new FilmController();
$ctrlGenre          = new GenreController();
$ctrlActeur         = new ActeurController;
$ctrlRealisateur    = new RealisateurController();
$ctrlRole           = new RoleController();
$ctrlCasting        = new CastingController();

$id = (isset($_GET["id"])) ? $_GET["id"] : null; 

if(isset($_GET["action"])) {
    switch ($_GET["action"]) {
        // Films
        case "listFilms"            : $ctrlFilm->listFilms();             break;
        case "detailFilm"           : $ctrlFilm->detailFilm($id);         break;
        case "ajouterFilm"          :$ctrlFilm->ajouterFilm();            break;
        // Genres
        case "listGenres"           : $ctrlGenre->listGenres();            break;
        case "detailGenre"          : $ctrlGenre->detailGenre($id);        break;
        case "ajouterGenre"         : $ctrlGenre->ajouterGenre();          break;
        // case "associerGenre"    : $ctrlCinema->associerGenre();         break;
        // Acteurs
        case "listActeurs"          : $ctrlActeur->listActeurs();           break;
        case "detailActeur"         : $ctrlActeur->detailActeur($id);       break;
        case "ajouterActeur"        : $ctrlActeur->ajouterActeur();         break;
        // Réalisateurs
        case "listRealisateurs"     : $ctrlRealisateur->listRealisateurs();      break;
        case "detailRealisateur"    : $ctrlRealisateur->detailRealisateur($id);  break;
        case "ajouterRealisateur"   : $ctrlRealisateur->ajouterRealisateur();    break;
        // Rôles
        case "listRoles"            : $ctrlRole->listRoles();                   break;
        case "detailRole"           : $ctrlRole->detailRole($id);               break;
        case "ajouterRole"          : $ctrlRole->ajouterRole();                 break;
        case "modifierRole"         : $ctrlRole->modifierRole($id);             break;
        // Casting
        case "ajouterCasting"       : $ctrlCasting->ajouterCasting();        break;
    }
} else {
    $ctrlCinema->listFilms();
}