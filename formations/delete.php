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

try {
    $statement = $pdo->prepare("DELETE FROM formations WHERE id = :id");
    $statement->execute(["id" => $id]);
    if ($statement->rowCount() === 0) {
        setFlash("Sorry, we don't have this formation in our program", "danger");
    } else {
        setFlash("The Formation was deleted successfully ");
    }
} catch (PDOException $e) {
    if ($e->getCode() == "23000") {
        setFlash("Sorry, we can't delete this Formation just yet, there's students still enrolled in it", "danger");
    } else {
        throw $e;
    }
}

header("Location: index.php");
exit;