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
    header("Location: team.php");
    exit;
}

$id = (int) $_GET["id"];


/* GET IMAGE */

$sql = "SELECT image
        FROM team
        WHERE id = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $id);

$stmt->execute();

$result = $stmt->get_result();


if ($result->num_rows === 1) {

    $member = $result->fetch_assoc();

    if (
        !empty($member["image"]) &&
        file_exists(
            "../assets/uploads/"
            . $member["image"]
        )
    ) {

        unlink(
            "../assets/uploads/"
            . $member["image"]
        );

    }

}


/* DELETE */

$sql = "DELETE FROM team
        WHERE id = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $id);

$stmt->execute();

$stmt->close();

header("Location: team.php");

exit;

?>