<!-- ici on sera la base/le squelette à toutes les vues
on déclarera le doctype, les link css / js une seule fois dans ce fichier
on exploitera la temporisation de sortie -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php $titre ?></title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <nav>
        <a href="index.php?action=listGenres">Genres</a>
        <a href="index.php?action=listActeurs">Acteurs</a>
        <a href="index.php?action=listRealisateurs">Réalisateurs</a>
        <a href="index.php?action=listFilms">Films</a>
        <a href="index.php?action=listRoles">Rôles</a>
    </nav>
    <div id="wrapper">
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
    </div>
</body>
</html>