<?php
require_once __DIR__ . "/../database/connexion.php";
require_once __DIR__ . "/../includes/functions.php";
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit;
}

$id = filter_var($_POST["id"] ?? null, FILTER_VALIDATE_INT);

if (!$id) {
    setFlash("ID invalid", "danger");
    header("Location: index.php");
    exit;
}


$statement = $pdo->prepare("DELETE FROM module WHERE id = :id");
$statement->execute(["id" => $id]);

if ($statement->rowCount() === 0) {
    setFlash("Sorry, This Module doesn't exist in our systems", "danger");
} else {
    setFlash("The Module was deleted successfully");
}

header("Location: index.php");
exit;