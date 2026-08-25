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
    header("Location: projects.php");
    exit;
}

$id = (int) $_GET["id"];


/* GET IMAGE */

$sql = "SELECT image
        FROM projects
        WHERE id = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $id);

$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows === 1) {

    $project = $result->fetch_assoc();

    if (
        !empty($project["image"]) &&
        file_exists(
            "../assets/uploads/"
            . $project["image"]
        )
    ) {

        unlink(
            "../assets/uploads/"
            . $project["image"]
        );

    }

}


/* DELETE PROJECT */

$sql = "DELETE FROM projects
        WHERE id = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $id);

$stmt->execute();

$stmt->close();

header("Location: projects.php");

exit;

?>