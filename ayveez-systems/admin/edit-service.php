<?php

session_start();

if (!isset($_SESSION["admin_id"])) {
    header("Location: login.php");
    exit;
}

include "../includes/db.php";

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    header("Location: services.php");
    exit;
}

$id = (int) $_GET["id"];

$sql = "SELECT * FROM services WHERE id = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $id);

$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    header("Location: services.php");
    exit;
}

$service = $result->fetch_assoc();

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = trim($_POST["title"]);
    $icon = trim($_POST["icon"]);
    $description = trim($_POST["description"]);
    $status = isset($_POST["status"]) ? 1 : 0;

    if (empty($title) || empty($description)) {

        $error = "Service title and description are required.";

    } else {

        $sql = "UPDATE services
                SET title = ?,
                    icon = ?,
                    description = ?,
                    status = ?
                WHERE id = ?";

        $stmt = $conn->prepare($sql);

        $stmt->bind_param(
            "sssii",
            $title,
            $icon,
            $description,
            $status,
            $id
        );

        if ($stmt->execute()) {

            header("Location: services.php");
            exit;

        } else {

            $error = "Unable to update service.";

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

<title>Edit Service | Ayveez Systems</title>

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

                <h5>Edit Service</h5>

                <span>
                    Update service information
                </span>

            </div>

        </div>


        <div class="dashboard-content">

            <div class="form-card">

                <h3>Edit Service</h3>

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
                            value="<?php echo htmlspecialchars($service["title"]); ?>"
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
                            value="<?php echo htmlspecialchars($service["icon"]); ?>"
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
                            required
                        ><?php echo htmlspecialchars($service["description"]); ?></textarea>

                    </div>


                    <div class="form-check mb-4">

                        <input
                            class="form-check-input"
                            type="checkbox"
                            name="status"
                            id="status"
                            <?php echo $service["status"] ? "checked" : ""; ?>
                        >

                        <label
                            class="form-check-label"
                            for="status">

                            Active Service

                        </label>

                    </div>


                    <button
                        type="submit"
                        class="btn btn-primary">

                        <i class="fas fa-save me-2"></i>

                        Update Service

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