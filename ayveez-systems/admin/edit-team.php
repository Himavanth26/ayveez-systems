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


/* GET MEMBER */

$sql = "SELECT *
        FROM team
        WHERE id = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $id);

$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    header("Location: team.php");
    exit;
}

$member = $result->fetch_assoc();

$error = "";


/* UPDATE */

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST["name"]);
    $designation = trim($_POST["designation"]);
    $description = trim($_POST["description"]);

    $status = isset($_POST["status"]) ? 1 : 0;


    if (empty($name) || empty($designation)) {

        $error =
            "Name and designation are required.";

    } else {

        $image_name = $member["image"];


        if (
            isset($_FILES["image"]) &&
            $_FILES["image"]["error"] === UPLOAD_ERR_OK
        ) {

            $allowed_types = [
                "image/jpeg",
                "image/png",
                "image/webp"
            ];

            if (
                !in_array(
                    $_FILES["image"]["type"],
                    $allowed_types
                )
            ) {

                $error =
                    "Only JPG, PNG and WEBP images are allowed.";

            } else {

                $extension = pathinfo(
                    $_FILES["image"]["name"],
                    PATHINFO_EXTENSION
                );

                $new_image =
                    uniqid("team_", true)
                    . "."
                    . strtolower($extension);

                $upload_path =
                    "../assets/uploads/"
                    . $new_image;


                if (
                    move_uploaded_file(
                        $_FILES["image"]["tmp_name"],
                        $upload_path
                    )
                ) {

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

                    $image_name = $new_image;

                } else {

                    $error =
                        "Unable to upload new image.";

                }

            }

        }


        if (empty($error)) {

            $sql = "UPDATE team
                    SET
                        name = ?,
                        designation = ?,
                        image = ?,
                        description = ?,
                        status = ?
                    WHERE id = ?";

            $stmt = $conn->prepare($sql);

            $stmt->bind_param(
                "ssssii",
                $name,
                $designation,
                $image_name,
                $description,
                $status,
                $id
            );

            if ($stmt->execute()) {

                header("Location: team.php");
                exit;

            } else {

                $error =
                    "Unable to update team member.";

            }

        }

    }

}

?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>Edit Team Member | Ayveez Systems</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
rel="stylesheet">

<link
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
rel="stylesheet">

<link rel="stylesheet" href="admin.css">

</head>

<body>

<div class="admin-wrapper">

    <aside class="sidebar">

        <div class="sidebar-brand">

            <h4>Ayveez Systems</h4>

            <span>Admin Panel</span>

        </div>


        <ul class="sidebar-menu">

            <li>
                <a href="dashboard.php">
                    <i class="fas fa-chart-line"></i>
                    Dashboard
                </a>
            </li>

            <li>
                <a href="services.php">
                    <i class="fas fa-layer-group"></i>
                    Services
                </a>
            </li>

            <li>
                <a href="projects.php">
                    <i class="fas fa-briefcase"></i>
                    Projects
                </a>
            </li>

            <li>
                <a href="team.php" class="active">
                    <i class="fas fa-users"></i>
                    Team
                </a>
            </li>

            <li>
                <a href="careers.php">
                    <i class="fas fa-user-tie"></i>
                    Careers
                </a>
            </li>

            <li>
                <a href="contacts.php">
                    <i class="fas fa-envelope"></i>
                    Messages
                </a>
            </li>

            <li class="logout-menu">

                <a href="logout.php">

                    <i class="fas fa-sign-out-alt"></i>

                    Logout

                </a>

            </li>

        </ul>

    </aside>


    <main class="main-content">

        <div class="topbar">

            <div>

                <h5>Edit Team Member</h5>

                <span>
                    Update team member information
                </span>

            </div>

        </div>


        <div class="dashboard-content">

            <div class="form-card">

                <h3>Edit Team Member</h3>


                <?php if (!empty($error)): ?>

                    <div class="alert alert-danger">

                        <?php
                        echo htmlspecialchars($error);
                        ?>

                    </div>

                <?php endif; ?>


                <form
                    method="POST"
                    enctype="multipart/form-data"
                >

                    <div class="mb-3">

                        <label class="form-label">
                            Full Name
                        </label>

                        <input
                            type="text"
                            name="name"
                            class="form-control"
                            value="<?php
                                echo htmlspecialchars(
                                    $member["name"]
                                );
                            ?>"
                            required
                        >

                    </div>


                    <div class="mb-3">

                        <label class="form-label">
                            Designation
                        </label>

                        <input
                            type="text"
                            name="designation"
                            class="form-control"
                            value="<?php
                                echo htmlspecialchars(
                                    $member["designation"]
                                );
                            ?>"
                            required
                        >

                    </div>


                    <div class="mb-3">

                        <label class="form-label">
                            Description
                        </label>

                        <textarea
                            name="description"
                            class="form-control"
                            rows="5"
                        ><?php
                            echo htmlspecialchars(
                                $member["description"]
                            );
                        ?></textarea>

                    </div>


                    <?php if (
                        !empty($member["image"])
                    ): ?>

                        <div class="mb-3">

                            <label class="form-label">
                                Current Photo
                            </label>

                            <br>

                            <img
                                src="../assets/uploads/<?php
                                    echo htmlspecialchars(
                                        $member["image"]
                                    );
                                ?>"
                                class="edit-team-image"
                                alt="Team member"
                            >

                        </div>

                    <?php endif; ?>


                    <div class="mb-3">

                        <label class="form-label">
                            Replace Photo
                        </label>

                        <input
                            type="file"
                            name="image"
                            class="form-control"
                            accept=".jpg,.jpeg,.png,.webp"
                        >

                    </div>


                    <div class="form-check mb-4">

                        <input
                            class="form-check-input"
                            type="checkbox"
                            name="status"
                            id="status"
                            <?php
                            echo $member["status"]
                                ? "checked"
                                : "";
                            ?>
                        >

                        <label
                            class="form-check-label"
                            for="status"
                        >

                            Active Team Member

                        </label>

                    </div>


                    <button
                        type="submit"
                        class="btn btn-primary"
                    >

                        <i class="fas fa-save me-2"></i>

                        Update Team Member

                    </button>


                    <a
                        href="team.php"
                        class="btn btn-secondary"
                    >

                        Cancel

                    </a>

                </form>

            </div>

        </div>

    </main>

</div>

</body>

</html>