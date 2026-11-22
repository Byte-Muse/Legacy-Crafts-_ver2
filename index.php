
<?php

require_once __DIR__ . "/database/connexion.php";  
require_once __DIR__ . "/includes/functions.php";   
 

$active = "home";
 
$nbFormations = $pdo->query("SELECT COUNT(*) FROM formations")->fetchColumn();
$nbEtudiants = $pdo->query("SELECT COUNT(*) FROM etudiant")->fetchColumn();
$nbModules = $pdo->query("SELECT COUNT(*) FROM module")->fetchColumn();
 

?>
 
 <?php //header: ?> <!--come back and replace the header by calling it + footer-->
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

<div class="zellige-band"></div>

<main class="container py-4">

<?php if (isset($_SESSION["flash"])) { ?>
    <div class="alert alert-<?= h($_SESSION["flash"]["type"]) ?> alert-dismissible fade show" role="alert">
        <?= h($_SESSION["flash"]["message"]) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
    </div>
    <?php unset($_SESSION["flash"]); ?>
<?php } ?>

<section class="hero mb-5">
    <h1> Join Us Now in Legacy Crafts</h1>
    <p class="lead mb-0"> We offer Workshops for everyone at all skill level</p>
</section>
 
<div class="row g-4">
 
    <div class="col-md-4">
        <div class="entity-card">
            <h2 class="h4 mt-2">Formations</h2>
            <p class="text-muted">Check out the arts our Workshops offer</p>
            <a class="btn btn-main" href="formation/index.php">Check</a>
        </div>
    </div>
 
    <div class="col-md-4">
        <div class="entity-card">
            <h2 class="h4 mt-2">Students</h2>
            <p class="text-muted">A list of our enrolled students</p>
            <a class="btn btn-main" href="etudiant/index.php">Check</a>
        </div>
    </div>
 
    <div class="col-md-4">
        <div class="entity-card">
            <h2 class="h4 mt-2">Modules</h2>
            <p class="text-muted">Take a look at the diffrent modules each Workshop offers</p>
            <a class="btn btn-main" href="module/index.php">Check</a>
        </div>
    </div>
 
</div>

<?php //footer ?> </main>
<footer class="site-footer text-center py-3">
    Legacy Crafts Center for Traditional Moroccan Arts and Workshops

</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
 
