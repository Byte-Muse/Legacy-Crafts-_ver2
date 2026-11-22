<?php
require_once __DIR__ . "/../database/connexion.php";
require_once __DIR__ . "/../includes/functions.php";
$niveaux = ["Débutant", "Intermédiaire", "Avancé"];

$errors = [];   
$titre = "";   
$niveau = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $titre = trim($_POST["titre"] ?? "");
    $niveau = $_POST["niveau"] ?? "";

    if ($titre === "") {
        $errors[] = "Le titre est obligatoire.";
    } elseif (mb_strlen($titre) > 100) {
        $errors[] = "Le titre ne doit pas dépasser 100 caractères.";
    }
    if (!in_array($niveau, $niveaux, true)) {
        $errors[] = "Veuillez choisir un niveau.";
    }

    if (empty($errors)) {
        $sql = "INSERT INTO formations (titre, niveau) VALUES (:titre, :niveau)";
        $statement = $pdo->prepare($sql);
        $statement->execute([
            "titre" => $titre,
            "niveau" => $niveau,
        ]);

        setFlash("La formation « " . $titre . " » a bien été ajoutée.");
        header("Location: index.php");
        exit;
    }
}

$pageTitle = "Ajouter une formation";
$active = "formation";
require_once __DIR__ . "/../includes/header.php";
?>

<h1 class="mb-4">Ajouter une formation</h1>

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
        <label for="titre" class="form-label fw-semibold">Titre</label>
        <input type="text" id="titre" name="titre" class="form-control" maxlength="100"
               value="<?= h($titre) ?>" required>
    </div>

    <div class="mb-4">
        <label for="niveau" class="form-label fw-semibold">Niveau</label>
        <select id="niveau" name="niveau" class="form-select" required>
            <option value="">Choisir un niveau</option>
            <?php foreach ($niveaux as $n) { ?>
                <option value="<?= h($n) ?>" <?= $niveau === $n ? "selected" : "" ?>><?= h($n) ?></option>
            <?php } ?>
        </select>
    </div>

    <button type="submit" class="btn btn-main">Ajouter</button>
    <a href="index.php" class="btn btn-outline-secondary">Annuler</a>
</form>

<?php require_once __DIR__ . "/../includes/footer.php"; ?>