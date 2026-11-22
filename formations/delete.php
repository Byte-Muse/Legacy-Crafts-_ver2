<?php
require_once __DIR__ . "/../database/connexion.php";
require_once __DIR__ . "/../includes/functions.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit;
}

$id = filter_var($_POST["id"] ?? null, FILTER_VALIDATE_INT);

if (!$id) {
    setFlash("Identifiant de formation invalide.", "danger");
    header("Location: index.php");
    exit;
}

try {
    $statement = $pdo->prepare("DELETE FROM formations WHERE id = :id");
    $statement->execute(["id" => $id]);
    if ($statement->rowCount() === 0) {
        setFlash("Cette formation n'existe pas.", "danger");
    } else {
        setFlash("La formation a bien été supprimée.");
    }
} catch (PDOException $e) {
    if ($e->getCode() == "23000") {
        setFlash("Suppression impossible : cette formation contient encore des étudiants ou des modules.", "danger");
    } else {
        throw $e;
    }
}

header("Location: index.php");
exit;