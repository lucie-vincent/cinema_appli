<?php

// ici on déclare la connexion à la base de données

// on déclare le namespace
namespace Model;

// la classe est abstraite car on n'a pas besoin de l'instancier (voir Glossaire)
abstract class Connect {

    const HOST = "localhost";
    const DB = "cinema_appli";
    const USER = "root";
    const PASS = "";

    public static function seConnecter() {
        try {
            return new \PDO(
                "mysql:host=".self::HOST.";dbname=".self::DB.";charset=utf8", self::USER, self::PASS
            );
        } catch(\PDOException $exception) {
            return $exception->getMessage();
        }
    }

}