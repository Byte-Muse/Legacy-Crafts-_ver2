<?php
require_once __DIR__ . "/../database/connexion.php";
require_once __DIR__ . "/../includes/functions.php";

$id = filter_var($_GET["id"] ?? null, FILTER_VALIDATE_INT);

if (!$id) {
    setFlash("Identifiant d'étudiant invalide.", "danger");
    header("Location: index.php");
    exit;
}

$statement = $pdo->prepare("SELECT * FROM etudiant WHERE id = :id");
$statement->execute(["id" => $id]);
$etudiant = $statement->fetch(PDO::FETCH_ASSOC);

if (!$etudiant) {
    setFlash("Cet étudiant n'existe pas.", "danger");
    header("Location: index.php");
    exit;
}
$formations = $pdo->query("SELECT id, titre FROM formations ORDER BY titre")->fetchAll(PDO::FETCH_ASSOC);
$errors = [];
$nom = $etudiant["nom"];
$tel = $etudiant["tel"];
$email = $etudiant["email"];
$formationId = $etudiant["formation_id"];   
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nom = trim($_POST["nom"] ?? "");
    $tel = trim($_POST["tel"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $formationId = filter_var($_POST["formation_id"] ?? null, FILTER_VALIDATE_INT);

    if ($nom === "") {
        $errors[] = "Le nom est obligatoire.";
    } elseif (mb_strlen($nom) > 100) {
        $errors[] = "Le nom ne doit pas dépasser 100 caractères.";
    }

    if (!preg_match('/^\+?[0-9 ]{8,20}$/', $tel)) {
        $errors[] = "Le téléphone est invalide (chiffres et espaces, avec + facultatif au début).";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($email) > 100) {
        $errors[] = "L'adresse email est invalide.";
    }

    if (!$formationId) {
        $errors[] = "Veuillez choisir une formation.";
    } else {
        $check = $pdo->prepare("SELECT COUNT(*) FROM formation WHERE id = :id");
        $check->execute(["id" => $formationId]);
        if ($check->fetchColumn() == 0) {
            $errors[] = "La formation choisie n'existe pas.";
        }
    }

    if (empty($errors)) {
        
        $sql = "
            UPDATE etudiant
            SET nom = :nom, tel = :tel, email = :email, formation_id = :formation_id
            WHERE id = :id
        ";
        $statement = $pdo->prepare($sql);
        $statement->execute([
            "nom" => $nom,
            "tel" => $tel,
            "email" => $email,
            "formation_id" => $formationId,
            "id" => $id,
        ]);

        setFlash("L'étudiant « " . $nom . " » a bien été modifié.");
        header("Location: index.php");
        exit;
    }
}

$pageTitle = "Modifier un étudiant";
$active = "etudiant";
require_once __DIR__ . "/../includes/header.php";
?>

<h1 class="mb-4">Modifier un étudiant</h1>

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
        <label for="nom" class="form-label fw-semibold">Nom complet</label>
        <input type="text" id="nom" name="nom" class="form-control" maxlength="100" value="<?= h($nom) ?>" required>
    </div>

    <div class="mb-3">
        <label for="tel" class="form-label fw-semibold">Téléphone</label>
        <input type="tel" id="tel" name="tel" class="form-control" maxlength="20" value="<?= h($tel) ?>" required>
    </div>

    <div class="mb-3">
        <label for="email" class="form-label fw-semibold">Email</label>
        <input type="email" id="email" name="email" class="form-control" maxlength="100" value="<?= h($email) ?>" required>
    </div>

    <div class="mb-4">
        <label for="formation_id" class="form-label fw-semibold">Formation</label>
        <select id="formation_id" name="formation_id" class="form-select" required>
            <option value="">Choisir une formation</option>
            <?php foreach ($formations as $formation) { ?>
                <option value="<?= h($formation["id"]) ?>"
                    <?= (int) $formation["id"] === (int) $formationId ? "selected" : "" ?>>
                    <?= h($formation["titre"]) ?>
                </option>
            <?php } ?>
        </select>
    </div>

    <button type="submit" class="btn btn-main">Enregistrer</button>
    <a href="index.php" class="btn btn-outline-secondary">Annuler</a>
</form>

<?php require_once __DIR__ . "/../includes/footer.php"; ?>