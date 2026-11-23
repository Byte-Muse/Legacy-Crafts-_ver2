<?php ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title><?= h($pageTitle ?? "Home") ?> | Legacy Crafts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>CSS/style.css">

    </head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark navbar-zellige">
    <div class="container">
        <a class="navbar-brand" href=" <?= BASE_URL ?>index.php">Legacy Crafts</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#mainMenu" aria-controls="mainMenu" aria-expanded="false" aria-label="Menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainMenu">
            <ul class="navbar-nav ms-auto">

                <li class="nav-item">
                    <a class="nav-link <?= ($active ?? "") === "home" ? "active" : "" ?>" href="<?= BASE_URL ?>index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($active ?? "") === "formation" ? "active" : "" ?>" href="<?= BASE_URL ?>formations/index.php">Formations</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($active ?? "") === "etudiant" ? "active" : "" ?>" href="<?= BASE_URL ?>etudiant/index.php">Students</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($active ?? "") === "module" ? "active" : "" ?>" href="<?= BASE_URL ?>module/index.php">Modules</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="zellige-band"></div>

<main class="container py-4">

<?php if (isset($_SESSION["flash"])) { ?>
    <div class="alert alert-<?= h($_SESSION["flash"]["type"]) ?> alert-dismissible fade show" role="alert">
        <?= h($_SESSION["flash"]["message"]) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
    </div>
    <?php unset($_SESSION["flash"]); ?>
<?php } ?>