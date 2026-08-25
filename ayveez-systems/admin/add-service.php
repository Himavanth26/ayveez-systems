<?php

session_start();

if (!isset($_SESSION["admin_id"])) {
    header("Location: login.php");
    exit;
}

include "../includes/db.php";

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = trim($_POST["title"]);
    $icon = trim($_POST["icon"]);
    $description = trim($_POST["description"]);

    if (empty($title) || empty($description)) {

        $error = "Service title and description are required.";

    } else {

        $sql = "INSERT INTO services
                (title, icon, description)
                VALUES (?, ?, ?)";

        $stmt = $conn->prepare($sql);

        $stmt->bind_param(
            "sss",
            $title,
            $icon,
            $description
        );

        if ($stmt->execute()) {

            header("Location: services.php");
            exit;

        } else {

            $error = "Unable to add service.";

        }

        $stmt->close();
    }
}

?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>Add Service | Ayveez Systems</title>

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
                <a href="services.php" class="active">
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

                <h5>Add Service</h5>

                <span>
                    Create a new Ayveez Systems service
                </span>

            </div>

        </div>


        <div class="dashboard-content">

            <div class="form-card">

                <h3>Add New Service</h3>

                <p class="text-muted">
                    Enter the service information below.
                </p>


                <?php if (!empty($error)): ?>

                    <div class="alert alert-danger">

                        <?php echo htmlspecialchars($error); ?>

                    </div>

                <?php endif; ?>


                <form method="POST">

                    <div class="mb-3">

                        <label class="form-label">
                            Service Name
                        </label>

                        <input
                            type="text"
                            name="title"
                            class="form-control"
                            placeholder="Example: Web Development"
                            required
                        >

                    </div>


                    <div class="mb-3">

                        <label class="form-label">
                            Font Awesome Icon
                        </label>

                        <input
                            type="text"
                            name="icon"
                            class="form-control"
                            placeholder="Example: fas fa-laptop-code"
                        >

                        <small class="text-muted">
                            Example:
                            fas fa-laptop-code
                        </small>

                    </div>


                    <div class="mb-4">

                        <label class="form-label">
                            Description
                        </label>

                        <textarea
                            name="description"
                            class="form-control"
                            rows="5"
                            placeholder="Describe your service..."
                            required
                        ></textarea>

                    </div>


                    <button
                        type="submit"
                        class="btn btn-primary">

                        <i class="fas fa-save me-2"></i>

                        Save Service

                    </button>


                    <a
                        href="services.php"
                        class="btn btn-secondary">

                        Cancel

                    </a>

                </form>

            </div>

        </div>

    </main>

</div>

</body>

</html>