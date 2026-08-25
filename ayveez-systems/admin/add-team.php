<?php

session_start();

if (!isset($_SESSION["admin_id"])) {
    header("Location: login.php");
    exit;
}

include "../includes/db.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST["name"]);
    $designation = trim($_POST["designation"]);
    $description = trim($_POST["description"]);

    if (empty($name) || empty($designation)) {

        $error = "Name and designation are required.";

    } else {

        $image_name = "";

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

                $image_name =
                    uniqid("team_", true)
                    . "."
                    . strtolower($extension);

                $upload_path =
                    "../assets/uploads/"
                    . $image_name;

                if (
                    !move_uploaded_file(
                        $_FILES["image"]["tmp_name"],
                        $upload_path
                    )
                ) {

                    $error =
                        "Unable to upload image.";

                }

            }

        }


        if (empty($error)) {

            $sql = "INSERT INTO team
                    (
                        name,
                        designation,
                        image,
                        description
                    )
                    VALUES (?, ?, ?, ?)";

            $stmt = $conn->prepare($sql);

            $stmt->bind_param(
                "ssss",
                $name,
                $designation,
                $image_name,
                $description
            );

            if ($stmt->execute()) {

                header("Location: team.php");
                exit;

            } else {

                $error =
                    "Unable to add team member.";

            }

            $stmt->close();

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

<title>Add Team Member | Ayveez Systems</title>

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

                <h5>Add Team Member</h5>

                <span>
                    Add a member to your team
                </span>

            </div>

        </div>


        <div class="dashboard-content">

            <div class="form-card">

                <h3>Add Team Member</h3>

                <p class="text-muted">
                    Enter team member information below.
                </p>


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
                            placeholder="Example: John Smith"
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
                            placeholder="Example: Senior Software Engineer"
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
                            placeholder="Write a short professional bio..."
                        ></textarea>

                    </div>


                    <div class="mb-4">

                        <label class="form-label">
                            Profile Photo
                        </label>

                        <input
                            type="file"
                            name="image"
                            class="form-control"
                            accept=".jpg,.jpeg,.png,.webp"
                        >

                        <small class="text-muted">
                            JPG, PNG or WEBP only.
                        </small>

                    </div>


                    <button
                        type="submit"
                        class="btn btn-primary"
                    >

                        <i class="fas fa-save me-2"></i>

                        Save Team Member

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