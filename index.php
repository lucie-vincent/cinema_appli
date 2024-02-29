<?php

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
        case "listActeurs" : $ctrlCinema->listActeurs(); break;
    }
} else {
    $ctrl->listFilms();
}

