<?php

require_once __DIR__ . "/../database/connexion.php";
require_once __DIR__ . "/../includes/functions.php";

$id = filter_var($_GET["id"] ?? null, FILTER_VALIDATE_INT);

if (!$id) {
    setFlash("ID invalid", "danger");
    header("Location: index.php");
    exit;
}

$statement = $pdo->prepare("SELECT * FROM module WHERE id = :id");
$statement->execute(["id" => $id]);
$module = $statement->fetch(PDO::FETCH_ASSOC);

if (!$module) {
    setFlash("This Module doesn't exist", "danger");
    header("Location: index.php");
    exit;
}

$formations = $pdo->query("SELECT id, titre FROM formations ORDER BY titre")->fetchAll(PDO::FETCH_ASSOC);
$errors = [];
$titre = $module["titre"];
$heures = $module["heures"];
$formationId = $module["formation_id"];

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $titre = trim($_POST["titre"] ?? "");
    $heures = filter_var(
        $_POST["heures"] ?? null,
        FILTER_VALIDATE_INT,
        ["options" => ["min_range" => 1, "max_range" => 500]]
    );
    $formationId = filter_var($_POST["formation_id"] ?? null, FILTER_VALIDATE_INT);

    if ($titre === "") {
        $errors[] = "The Title of the course is quite important, you see";
    } elseif (mb_strlen($titre) > 100) {
        $errors[] = "Make sure the title is within the limit of 100 characters";
    }

    if ($heures === false) {
        $errors[] = "The number of hours of each course should be between 1 and 500, try not to travel back in time or add a module with an eternity to learn";
    }

    if (!$formationId) {
        $errors[] = "Please Choose a Formation";
    } else {
        $check = $pdo->prepare("SELECT COUNT(*) FROM formations WHERE id = :id");
        $check->execute(["id" => $formationId]);
        if ($check->fetchColumn() == 0) {
            $errors[] = "This formation doesn't exist yet, feel free to add it in Formations";
        }
    }

    if (empty($errors)) {
        $sql = "
            UPDATE module
            SET titre = :titre, heures = :heures, formation_id = :formation_id
            WHERE id = :id
        ";
        $statement = $pdo->prepare($sql);
        $statement->execute([
            "titre" => $titre,
            "heures" => $heures,
            "formation_id" => $formationId,
            "id" => $id,
        ]);

        setFlash("The module « " . $titre . " » was modified successfully");
        header("Location: index.php");
        exit;
    }
}

$pageTitle = "Modify a Module";
$active = "module";
require_once __DIR__ . "/../includes/header.php";
?>

<h1 class="mb-4">Modify a Module</h1>

<?php if (!empty($errors)) { ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php foreach ($errors as $error) { ?>
                <li><?= h($error) ?></li>
            <?php } ?>
        </ul>
    </div>
<?php } ?>

<form method="POST" class="form-card">

    <div class="mb-3">
        <label for="titre" class="form-label fw-semibold">Title</label>
        <input type="text" id="titre" name="titre" class="form-control" maxlength="100" value="<?= h($titre) ?>" required>
    </div>

    <div class="mb-3">
        <label for="heures" class="form-label fw-semibold">Hours </label>
        <input type="number" id="heures" name="heures" class="form-control" min="1" max="500"
               value="<?= h($heures === false ? "" : $heures) ?>" required>
    </div>

    <div class="mb-4">
        <label for="formation_id" class="form-label fw-semibold">Formation</label>
        <select id="formation_id" name="formation_id" class="form-select" required>
            <option value="">Choose a formation</option>
            <?php foreach ($formations as $formation) { ?>
                <option value="<?= h($formation["id"]) ?>"
                    <?= (int) $formation["id"] === (int) $formationId ? "selected" : "" ?>>
                    <?= h($formation["titre"]) ?>
                </option>
            <?php } ?>
        </select>
    </div>

    <button type="submit" class="btn btn-main">Save</button>
    <a href="index.php" class="btn btn-outline-secondary">Cancel</a>
</form>

<?php require_once __DIR__ . "/../includes/footer.php"; ?>