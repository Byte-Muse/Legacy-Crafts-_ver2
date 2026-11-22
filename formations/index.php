<?php
require_once __DIR__ . "/../database/connexion.php";
require_once __DIR__ . "/../includes/functions.php";

$pageTitle = "Formations";
$active = "formations";


$sql = "
    SELECT
        f.id,
        f.titre,
        f.niveau,
        (SELECT COUNT(*) FROM etudiant e WHERE e.formation_id = f.id) AS nb_etudiants,
        (SELECT COUNT(*) FROM module m WHERE m.formation_id = f.id) AS nb_modules
    FROM formations f
    ORDER BY f.titre
";

$formations = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>  <!--come back and replace the header by calling it + footer-->
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
                
                <li class="nav-item">
                    <a class="nav-link <?= ($active ?? "") === "home" ? "active" : "" ?>" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($active ?? "") === "formation" ? "active" : "" ?>" href="formation/index.php">Formations</a>
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

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="mb-1">Formations</h1>
        <p class="text-muted mb-0">Les arts traditionnels enseignés au centre.</p>
    </div>
    <a class="btn btn-main" href="create.php">+ Ajouter une formation</a>
</div>

<div class="table-card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titre</th>
                    <th>Niveau</th>
                    <th>Étudiants</th>
                    <th>Modules</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>

            <?php if (empty($formations)) { ?>
                <!-- Friendly message when the table is empty. colspan="6" = this cell spans the 6 columns. -->
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">Aucune formation pour le moment.</td>
                </tr>
            <?php } ?>

            <!-- foreach = repeat the block once per formation. $formation is the current row. -->
            <?php foreach ($formations as $formation) { ?>
                <tr>
                    <td><?= h($formation["id"]) ?></td>
                    <td class="fw-semibold"><?= h($formation["titre"]) ?></td>
                    <td><?= h($formation["niveau"]) ?></td>
                    <td><span class="badge text-bg-secondary"><?= h($formation["nb_etudiants"]) ?></span></td>
                    <td><span class="badge text-bg-secondary"><?= h($formation["nb_modules"]) ?></span></td>
                    <td class="text-end">
                        <!-- The id travels in the URL: edit.php?id=3 -->
                        <a class="btn btn-sm btn-outline-primary" href="edit.php?id=<?= h($formation["id"]) ?>">Modifier</a>

                        <!-- DELETE is a small form sent with POST (not a link): a link can be triggered by mistake
                             or by a robot, a POST form cannot. confirm() asks the user before sending. -->
                        <form method="POST" action="delete.php" class="d-inline"
                              onsubmit="return confirm('Supprimer cette formation ?');">
                            <input type="hidden" name="id" value="<?= h($formation["id"]) ?>">
                            <button type="submit" class="btn btn-sm btn-outline-danger">Supprimer</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>

            </tbody>
        </table>
    </div>
</div>

<footer class="site-footer text-center py-3">
    Legacy Crafts Center for Traditional Moroccan Arts and Workshops

</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
