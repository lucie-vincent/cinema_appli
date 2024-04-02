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
    require str_replace("\\", DIRECTORY_SEPARATOR, $class_name) . '.php';
});

// on instancie les controller 
$ctrlCinema         = new CinemaController();
$ctrlFilm           = new FilmController();
$ctrlGenre          = new GenreController();
$ctrlActeur         = new ActeurController;
$ctrlRealisateur    = new RealisateurController();
$ctrlRole           = new RoleController();
$ctrlCasting        = new CastingController();


// $id = isset($_GET["id"]) ? $_GET["id"] : null;
$id = htmlentities(isset($_GET["id"])) ? $_GET["id"] : null;

// il faut se protéger contre les failles XSS (Cross Site Scripting) - on peut utiliser des filtres ou des méthodes
// pour les input - on utilise les filtres (voir FILTER_INPUT)
// pour les variables on peut utiliser FILTER_VAR ou 2 fonctions :
// htmlspecialchars() et htmlentities()
// voir également le site OWASP (Open Worldwide Application Security Project) -- attacks/XSS ou TYpe_Of_Cross-Site_Scripting pour plus d'infos
// $id = htmlentities($id);

if(isset($_GET["action"])) {
    // on met on place le switch pour vérifier l'action des URL, et plus haut, on vérifie avec le if(isset($_GET["action"])) qu'une action est bien passée en paramètres
    switch ($_GET["action"]) {
        // Films
        case "listFilms"          : $ctrlFilm->listFilms();         break;
        case "detailFilm"         : $ctrlFilm->detailFilm($id);     break;
        case "ajouterFilm"        : $ctrlFilm->ajouterFilm();       break;
        case "modifierFilm"       : $ctrlFilm->modifierFilm($id);   break;
        case "supprimerFilm"      : $ctrlFilm->supprimerFilm($id);  break;

        // Genres
        case "listGenres"      : $ctrlGenre->listGenres();        break;
        case "detailGenre"     : $ctrlGenre->detailGenre($id);    break;
        case "ajouterGenre"    : $ctrlGenre->ajouterGenre();       break;
        case "modifierGenre"   : $ctrlGenre->modifierGenre($id);  break;
        case "supprimerGenre"  : $ctrlGenre->supprimerGenre($id); break;
        // case "associerGenre": $ctrlCinema->associerGenre();    break;

        // Acteurs
        case "listActeurs"          : $ctrlActeur->listActeurs();        break;
        case "detailActeur"         : $ctrlActeur->detailActeur($id);    break;
        case "ajouterActeur"        : $ctrlActeur->ajouterActeur();      break;
        case "modifierActeur"       : $ctrlActeur->modifierActeur($id);  break;
        case "supprimerActeur"      : $ctrlActeur->supprimerActeur($id); break;

        // Réalisateurs
        case "listRealisateurs"     : $ctrlRealisateur->listRealisateurs();        break;
        case "detailRealisateur"    : $ctrlRealisateur->detailRealisateur($id);    break;
        case "ajouterRealisateur"   : $ctrlRealisateur->ajouterRealisateur();      break;
        case "modifierRealisateur"  : $ctrlRealisateur->modifierRealisateur($id);  break;

        // Rôles
        case "listRoles"        : $ctrlRole->listRoles();        break;
        case "detailRole"       : $ctrlRole->detailRole($id);    break;
        case "ajouterRole"      : $ctrlRole->ajouterRole();      break;
        case "modifierRole"     : $ctrlRole->modifierRole($id);  break;
        case "supprimerRole"    : $ctrlRole->supprimerRole($id); break;

        // Casting
        case "ajouterCasting"    : $ctrlCasting->ajouterCasting();      break;
        case "supprimerCasting"  : $ctrlCasting->supprimerCasting($id); break;
    }
} else {
    $ctrlCinema->listFilms();
}