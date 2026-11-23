<?php
require_once __DIR__ . "/../database/connexion.php";
require_once __DIR__ . "/../includes/functions.php";

$pageTitle = "Modules";
$active = "module";

$sql = "
    SELECT
        module.id,
        module.titre,
        module.heures,
        formations.titre AS formation_titre
    FROM module
    JOIN formations ON module.formation_id = formations.id
    ORDER BY formations.titre, module.titre
";
$modules = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

require_once __DIR__ . "/../includes/header.php";
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="mb-1">Modules</h1>
        <p class="text-muted mb-0">Curious about our services? Here's a list with the courses of each Formation</p>
    </div>
    <a class="btn btn-main" href="create.php">+ Add a module</a>
</div>

<div class="table-card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Hours</th>
                    <th>Formation</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>

            <?php if (empty($modules)) { ?>
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">No Modules yet</td>
                </tr>
            <?php } ?>

            <?php foreach ($modules as $module) { ?>
                <tr>
                    <td><?= h($module["id"]) ?></td>
                    <td class="fw-semibold"><?= h($module["titre"]) ?></td>
                    <td><?= h($module["heures"]) ?> h</td>
                    <td><span class="badge text-bg-secondary"><?= h($module["formation_titre"]) ?></span></td>
                    <td class="text-end">
                        <a class="btn btn-sm btn-outline-primary" href="edit.php?id=<?= h($module["id"]) ?>">Modify</a>
                        <form method="POST" action="delete.php" class="d-inline"
                              onsubmit="return confirm('Delete this Module?');">
                            <input type="hidden" name="id" value="<?= h($module["id"]) ?>">
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