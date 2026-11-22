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
        formation.titre AS formation_titre
    FROM module
    JOIN formation ON module.formation_id = formation.id
    ORDER BY formation.titre, module.titre
";
$modules = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

require_once __DIR__ . "/../includes/header.php";
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="mb-1">Modules</h1>
        <p class="text-muted mb-0">Les cours qui composent chaque formation.</p>
    </div>
    <a class="btn btn-main" href="create.php">+ Ajouter un module</a>
</div>

<div class="table-card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titre</th>
                    <th>Heures</th>
                    <th>Formation</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>

            <?php if (empty($modules)) { ?>
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">Aucun module pour le moment.</td>
                </tr>
            <?php } ?>

            <?php foreach ($modules as $module) { ?>
                <tr>
                    <td><?= h($module["id"]) ?></td>
                    <td class="fw-semibold"><?= h($module["titre"]) ?></td>
                    <td><?= h($module["heures"]) ?> h</td>
                    <td><span class="badge text-bg-secondary"><?= h($module["formation_titre"]) ?></span></td>
                    <td class="text-end">
                        <a class="btn btn-sm btn-outline-primary" href="edit.php?id=<?= h($module["id"]) ?>">Modifier</a>
                        <form method="POST" action="delete.php" class="d-inline"
                              onsubmit="return confirm('Supprimer ce module ?');">
                            <input type="hidden" name="id" value="<?= h($module["id"]) ?>">
                            <button type="submit" class="btn btn-sm btn-outline-danger">Supprimer</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>

            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . "/../includes/footer.php"; ?>