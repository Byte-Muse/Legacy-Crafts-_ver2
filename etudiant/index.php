<?php
// etudiant/index.php = READ: the list of students WITH the title of their formation.

require_once __DIR__ . "/../database/connexion.php";
require_once __DIR__ . "/../includes/functions.php";

$pageTitle = "Étudiants";
$active = "etudiant";
$sql = "
    SELECT
        etudiant.id,
        etudiant.nom,
        etudiant.tel,
        etudiant.email,
        formations.titre AS formation_titre
    FROM etudiant
    JOIN formations ON etudiant.formation_id = formations.id
    ORDER BY etudiant.nom
";
$etudiants = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

require_once __DIR__ . "/../includes/header.php";
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="mb-1">Étudiants</h1>
        <p class="text-muted mb-0">Les élèves inscrits aux formations du centre.</p>
    </div>
    <a class="btn btn-main" href="create.php">+ Ajouter un étudiant</a>
</div>

<div class="table-card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Téléphone</th>
                    <th>Email</th>
                    <th>Formation</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>

            <?php if (empty($etudiants)) { ?>
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">Aucun étudiant pour le moment.</td>
                </tr>
            <?php } ?>

            <?php foreach ($etudiants as $etudiant) { ?>
                <tr>
                    <td><?= h($etudiant["id"]) ?></td>
                    <td class="fw-semibold"><?= h($etudiant["nom"]) ?></td>
                    <td><?= h($etudiant["tel"]) ?></td>
                    <td><?= h($etudiant["email"]) ?></td>
                    <!-- The TITLE of the formation, not its number -->
                    <td><span class="badge text-bg-secondary"><?= h($etudiant["formation_titre"]) ?></span></td>
                    <td class="text-end">
                        <a class="btn btn-sm btn-outline-primary" href="edit.php?id=<?= h($etudiant["id"]) ?>">Modifier</a>
                        <form method="POST" action="delete.php" class="d-inline"
                              onsubmit="return confirm('Supprimer cet étudiant ?');">
                            <input type="hidden" name="id" value="<?= h($etudiant["id"]) ?>">
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