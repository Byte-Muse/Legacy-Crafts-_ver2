<?php

require_once __DIR__ . "/../database/connexion.php";
require_once __DIR__ . "/../includes/functions.php";

$formations = $pdo->query("SELECT id, titre FROM formations ORDER BY titre")->fetchAll(PDO::FETCH_ASSOC);

$errors = [];
$nom = "";
$tel = "";
$email = "";
$formationId = 0;  

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nom = trim($_POST["nom"] ?? "");
    $tel = trim($_POST["tel"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $formationId = filter_var($_POST["formation_id"] ?? null, FILTER_VALIDATE_INT);

    if ($nom === "") {
        $errors[] = "Adding the Name is quite important, you see";
    } elseif (mb_strlen($nom) > 100) {
        $errors[] = "Make sure the name is within the limit of 100 character.";
    }
    if (!preg_match('/^\+?[0-9 ]{8,20}$/', $tel)) {
        $errors[] = "The tel is invalid";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($email) > 100) {
        $errors[] = "The Email is invalid";
    }

    if (!$formationId) {
        $errors[] = "Although we're happy to know you, Please choose a formation to properly enroll with us";
    } else {
        $check = $pdo->prepare("SELECT COUNT(*) FROM formations WHERE id = :id");
        $check->execute(["id" => $formationId]);
        if ($check->fetchColumn() == 0) {
            $errors[] = "Sorry, this formation isn't a part of program";
        }
    }

    if (empty($errors)) {
        $sql = "
            INSERT INTO etudiant (nom, tel, email, formation_id)
            VALUES (:nom, :tel, :email, :formation_id)
        ";
        $statement = $pdo->prepare($sql);
        $statement->execute([
            "nom" => $nom,
            "tel" => $tel,
            "email" => $email,
            "formation_id" => $formationId,
        ]);

        setFlash("The Student « " . $nom . " » was added successfully");
        header("Location: index.php");
        exit;
    }
}

$pageTitle = "Add a Student";
$active = "etudiant";
require_once __DIR__ . "/../includes/header.php";
?>

<h1 class="mb-4">Add a Student</h1>

<?php if (empty($formations)) { ?>

    <div class="alert alert-warning">
        No data exists yet <a href="../formations/create.php">First, add a formation</a>.
    </div>
<?php } ?>

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
        <label for="nom" class="form-label fw-semibold">Full name</label>
        <input type="text" id="nom" name="nom" class="form-control" maxlength="100" value="<?= h($nom) ?>" required>
    </div>

    <div class="mb-3">
        <label for="tel" class="form-label fw-semibold">Tel</label>
        <input type="tel" id="tel" name="tel" class="form-control" maxlength="20" value="<?= h($tel) ?>" required>
    </div>

    <div class="mb-3">
        <label for="email" class="form-label fw-semibold">Email</label>
        <input type="email" id="email" name="email" class="form-control" maxlength="100" value="<?= h($email) ?>" required>
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

    <button type="submit" class="btn btn-main">Add</button>
    <a href="index.php" class="btn btn-outline-secondary">Cancel</a>
</form>

<?php require_once __DIR__ . "/../includes/footer.php"; ?>