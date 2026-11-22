
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Legacy Crafts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="CSS/style.css">

    </head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark navbar-zellige">
    <div class="container">
        <a class="navbar-brand" href="index.php">Legacy Crafts</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#mainMenu" aria-controls="mainMenu" aria-expanded="false" aria-label="Menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainMenu">
            <ul class="navbar-nav ms-auto">
                <!-- "active" highlights the link of the current page -->
                <li class="nav-item">
                    <a class="nav-link <?= ($active ?? "") === "home" ? "active" : "" ?>" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($active ?? "") === "formation" ? "active" : "" ?>" href="formations/index.php">Formations</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($active ?? "") === "etudiant" ? "active" : "" ?>" href="etudiant/index.php">Students</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($active ?? "") === "module" ? "active" : "" ?>" href="module/index.php">Modules</a>
                </li>
            </ul>
        </div>
    </div>
</nav>