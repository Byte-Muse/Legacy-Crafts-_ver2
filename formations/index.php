<?php
require_once __DIR__ . "/../database/connexion.php";
require_once __DIR__ . "/../includes/functions.php";

$pageTitle = "Formations";
$active = "formation";


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
require_once __DIR__ . "/../includes/header.php";
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="mb-1">Formations</h1>
        <p class="text-muted mb-0">Check out our fun craft Formations</p>
    </div>
    <a class="btn btn-main" href="create.php">+ Add a formation</a>
</div>

<div class="table-card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Level</th>
                    <th>Students</th>
                    <th>Modules</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>

            <?php if (empty($formations)) { ?>
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">We apologize, We don't have any available Formations in the moment</td>
                </tr>
            <?php } ?>

            <?php foreach ($formations as $formation) { ?>
                <tr>
                    <td><?= h($formation["id"]) ?></td>
                    <td class="fw-semibold"><?= h($formation["titre"]) ?></td>
                    <td><?= h($formation["niveau"]) ?></td>
                    <td><span class="badge text-bg-secondary"><?= h($formation["nb_etudiants"]) ?></span></td>
                    <td><span class="badge text-bg-secondary"><?= h($formation["nb_modules"]) ?></span></td>
                    <td class="text-end">
                        <a class="btn btn-sm btn-outline-primary" href="edit.php?id=<?= h($formation["id"]) ?>">Modify</a>

                        <form method="POST" action="delete.php" class="d-inline"
                              onsubmit="return confirm('Delete this formation?');">
                            <input type="hidden" name="id" value="<?= h($formation["id"]) ?>">
                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>

            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . "/../includes/footer.php"; ?>
