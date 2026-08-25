<?php

session_start();

if (!isset($_SESSION["admin_id"])) {
    header("Location: login.php");
    exit;
}

include "../includes/db.php";

if (
    !isset($_GET["id"]) ||
    !is_numeric($_GET["id"])
) {
    header("Location: careers.php");
    exit;
}

$id = (int) $_GET["id"];

$sql = "DELETE FROM careers
        WHERE id = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $id);

$stmt->execute();

$stmt->close();

header("Location: careers.php");

exit;

?>