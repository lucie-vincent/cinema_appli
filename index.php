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

if(isset($_GET["action"])) {
    switch ($_GET["action"]) {

        case "listFilms" : $ctrlCinema->listFilms(); break;
        case "listGenres" : $ctrlCinema->listGenres(); break;
        case "listActeurs" : $ctrlCinema->listActeurs(); break;
        case "listRealisateurs" : $ctrlCinema->listRealisateurs(); break;
        case "listRoles" : $ctrlCinema->listRoles(); break;
    }
} else {
    $ctrlCinema->listFilms();
}

