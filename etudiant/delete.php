<?php
require_once __DIR__ . "/../database/connexion.php";
require_once __DIR__ . "/../includes/functions.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit;
}

$id = filter_var($_POST["id"] ?? null, FILTER_VALIDATE_INT);

if (!$id) {
    setFlash("The ID is invalid", "danger");
    header("Location: index.php");
    exit;
}

$statement = $pdo->prepare("DELETE FROM etudiant WHERE id = :id");
$statement->execute(["id" => $id]);

if ($statement->rowCount() === 0) {
    setFlash("Sorry, this student does not seem to be enrolled with us.", "danger");
} else {
    setFlash("That's one student less");
}

header("Location: index.php");
exit;