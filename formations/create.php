<?php
require_once __DIR__ . "/../database/connexion.php";
require_once __DIR__ . "/../includes/functions.php";
$niveaux = ["Beginner", "Intermediate", "Advanced"];

$errors = [];   
$titre = "";   
$niveau = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $titre = trim($_POST["titre"] ?? "");
    $niveau = $_POST["niveau"] ?? "";

    if ($titre === "") {
        $errors[] = "The Title of the Formation is quite important, you see";
    } elseif (mb_strlen($titre) > 100) {
        $errors[] = "Make sure the title is within the limit of 100 charcters";
    }
    if (!in_array($niveau, $niveaux, true)) {
        $errors[] = "Choose a level";
    }

    if (empty($errors)) {
        $sql = "INSERT INTO formations (titre, niveau) VALUES (:titre, :niveau)";
        $statement = $pdo->prepare($sql);
        $statement->execute([
            "titre" => $titre,
            "niveau" => $niveau,
        ]);

        setFlash("The formation « " . $titre . " » was added successfully.");
        header("Location: index.php");
        exit;
    }
}

$pageTitle = "Add a Formation";
$active = "formation";
require_once __DIR__ . "/../includes/header.php";
?>

<h1 class="mb-4">Add a Formation</h1>

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
        <input type="text" id="titre" name="titre" class="form-control" maxlength="100"
               value="<?= h($titre) ?>" required>
    </div>

    <div class="mb-4">
        <label for="niveau" class="form-label fw-semibold">Level</label>
        <select id="niveau" name="niveau" class="form-select" required>
            <option value="">Choose the Level</option>
            <?php foreach ($niveaux as $n) { ?>
                <option value="<?= h($n) ?>" <?= $niveau === $n ? "selected" : "" ?>><?= h($n) ?></option>
            <?php } ?>
        </select>
    </div>

    <button type="submit" class="btn btn-main">Add</button>
    <a href="index.php" class="btn btn-outline-secondary">Cancel</a>
</form>

<?php require_once __DIR__ . "/../includes/footer.php"; ?>