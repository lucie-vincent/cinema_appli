<!-- ici on sera la base/le squelette à toutes les vues
on déclarera le doctype, les link css / js une seule fois dans ce fichier
on exploitera la temporisation de sortie -->

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titre ?></title>
    <link rel="stylesheet" href="http://C:\laragon\www\cinema_appli\public\css\styles.css">
</head>
<body>
    <div id="wrapper">
        <nav>
            <a href="index.php?action=listGenres">Genres</a>
            <a href="index.php?action=listActeurs">Acteurs</a>
            <a href="index.php?action=listRealisateurs">Réalisateurs</a>
            <a href="index.php?action=listFilms">Films</a>
            <a href="index.php?action=listRoles">Rôles</a>
        </nav>
        <main>
            <div id="contenu">
                <h1>
                    PDO Cinema
                </h1>
                <h2>
                    <?= $titre_secondaire ?>
                </h2>
                <?= $contenu ?>
            </div>
        </main>
        <footer>
            <ul>
                <li>Nous Contacter</li>
                <li>CGU</li>
                <li>Politique de cookies</li>
            </ul>
        </footer>
    </div>
</body>
</html>