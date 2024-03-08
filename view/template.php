<!-- ici on sera la base/le squelette à toutes les vues
on déclarera le doctype, les link css / js une seule fois dans ce fichier
on exploitera la temporisation de sortie -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php $titre ?></title>
</head>
<body>
    <nav>
        <a href="">Genres</a>
        <a href="">Acteurs</a>
        <a href="">Réalisateurs</a>
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