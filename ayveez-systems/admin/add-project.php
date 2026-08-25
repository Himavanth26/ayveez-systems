<?php

session_start();

if (!isset($_SESSION["admin_id"])) {
    header("Location: login.php");
    exit;
}

include "../includes/db.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $project_name = trim($_POST["project_name"]);
    $category = trim($_POST["category"]);
    $technology = trim($_POST["technology"]);
    $description = trim($_POST["description"]);
    $project_url = trim($_POST["project_url"]);

    if (
        empty($project_name) ||
        empty($description)
    ) {

        $error = "Project name and description are required.";

    } else {

        $image_name = "";

        /*
         * IMAGE UPLOAD
         */

        if (
            isset($_FILES["image"]) &&
            $_FILES["image"]["error"] === UPLOAD_ERR_OK
        ) {

            $allowed_types = [
                "image/jpeg",
                "image/png",
                "image/webp"
            ];

            $file_type = $_FILES["image"]["type"];

            if (!in_array($file_type, $allowed_types)) {

                $error = "Only JPG, PNG and WEBP images are allowed.";

            } else {

                $extension = pathinfo(
                    $_FILES["image"]["name"],
                    PATHINFO_EXTENSION
                );

                $image_name =
                    uniqid("project_", true)
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

                    $error = "Unable to upload image.";

                }

            }

        }


        if (empty($error)) {

            $sql = "INSERT INTO projects
                    (
                        project_name,
                        category,
                        technology,
                        description,
                        image,
                        project_url
                    )
                    VALUES (?, ?, ?, ?, ?, ?)";

            $stmt = $conn->prepare($sql);

            $stmt->bind_param(
                "ssssss",
                $project_name,
                $category,
                $technology,
                $description,
                $image_name,
                $project_url
            );

            if ($stmt->execute()) {

                header("Location: projects.php");
                exit;

            } else {

                $error = "Unable to add project.";

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

<title>Add Project | Ayveez Systems</title>

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
                <a href="projects.php" class="active">
                    <i class="fas fa-briefcase"></i>
                    Projects
                </a>
            </li>

            <li>
                <a href="team.php">
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

                <h5>Add Project</h5>

                <span>
                    Add a new portfolio project
                </span>

            </div>

        </div>


        <div class="dashboard-content">

            <div class="form-card">

                <h3>Add New Project</h3>

                <p class="text-muted">
                    Enter your project information.
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
                            Project Name
                        </label>

                        <input
                            type="text"
                            name="project_name"
                            class="form-control"
                            placeholder="Example: E-Commerce Platform"
                            required
                        >

                    </div>


                    <div class="mb-3">

                        <label class="form-label">
                            Category
                        </label>

                        <input
                            type="text"
                            name="category"
                            class="form-control"
                            placeholder="Example: Web Application"
                        >

                    </div>


                    <div class="mb-3">

                        <label class="form-label">
                            Technologies
                        </label>

                        <input
                            type="text"
                            name="technology"
                            class="form-control"
                            placeholder="PHP, MySQL, JavaScript, Bootstrap"
                        >

                    </div>


                    <div class="mb-3">

                        <label class="form-label">
                            Project Description
                        </label>

                        <textarea
                            name="description"
                            class="form-control"
                            rows="5"
                            placeholder="Describe the project..."
                            required
                        ></textarea>

                    </div>


                    <div class="mb-3">

                        <label class="form-label">
                            Project URL
                        </label>

                        <input
                            type="url"
                            name="project_url"
                            class="form-control"
                            placeholder="https://example.com"
                        >

                    </div>


                    <div class="mb-4">

                        <label class="form-label">
                            Project Image
                        </label>

                        <input
                            type="file"
                            name="image"
                            class="form-control"
                            accept=".jpg,.jpeg,.png,.webp"
                        >

                        <small class="text-muted">
                            Recommended: JPG, PNG or WEBP.
                        </small>

                    </div>


                    <button
                        type="submit"
                        class="btn btn-primary"
                    >

                        <i class="fas fa-save me-2"></i>

                        Save Project

                    </button>


                    <a
                        href="projects.php"
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