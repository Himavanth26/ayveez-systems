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


/* GET JOB */

$sql = "SELECT *
        FROM careers
        WHERE id = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $id);

$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    header("Location: careers.php");
    exit;
}

$job = $result->fetch_assoc();

$error = "";


/* UPDATE */

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $job_title = trim($_POST["job_title"]);
    $department = trim($_POST["department"]);
    $location = trim($_POST["location"]);
    $employment_type = trim($_POST["employment_type"]);
    $experience = trim($_POST["experience"]);
    $description = trim($_POST["description"]);

    $status = isset($_POST["status"]) ? 1 : 0;


    if (
        empty($job_title) ||
        empty($description)
    ) {

        $error =
            "Job title and description are required.";

    } else {

        $sql = "UPDATE careers
                SET
                    job_title = ?,
                    department = ?,
                    location = ?,
                    employment_type = ?,
                    experience = ?,
                    description = ?,
                    status = ?
                WHERE id = ?";

        $stmt = $conn->prepare($sql);

        $stmt->bind_param(
            "ssssssii",
            $job_title,
            $department,
            $location,
            $employment_type,
            $experience,
            $description,
            $status,
            $id
        );

        if ($stmt->execute()) {

            header("Location: careers.php");
            exit;

        } else {

            $error =
                "Unable to update job opening.";

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

<title>Edit Job | Ayveez Systems</title>

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
                <a href="team.php">
                    <i class="fas fa-users"></i>
                    Team
                </a>
            </li>

            <li>
                <a href="careers.php" class="active">
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

                <h5>Edit Job Opening</h5>

                <span>
                    Update career opportunity
                </span>

            </div>

        </div>


        <div class="dashboard-content">

            <div class="form-card">

                <h3>Edit Job Opening</h3>


                <?php if (!empty($error)): ?>

                    <div class="alert alert-danger">

                        <?php
                        echo htmlspecialchars($error);
                        ?>

                    </div>

                <?php endif; ?>


                <form method="POST">

                    <div class="mb-3">

                        <label class="form-label">
                            Job Title
                        </label>

                        <input
                            type="text"
                            name="job_title"
                            class="form-control"
                            value="<?php
                                echo htmlspecialchars(
                                    $job["job_title"]
                                );
                            ?>"
                            required
                        >

                    </div>


                    <div class="mb-3">

                        <label class="form-label">
                            Department
                        </label>

                        <input
                            type="text"
                            name="department"
                            class="form-control"
                            value="<?php
                                echo htmlspecialchars(
                                    $job["department"]
                                );
                            ?>"
                        >

                    </div>


                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Location
                            </label>

                            <input
                                type="text"
                                name="location"
                                class="form-control"
                                value="<?php
                                    echo htmlspecialchars(
                                        $job["location"]
                                    );
                                ?>"
                            >

                        </div>


                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Employment Type
                            </label>

                            <select
                                name="employment_type"
                                class="form-select"
                            >

                                <?php
                                $types = [
                                    "Full Time",
                                    "Part Time",
                                    "Internship",
                                    "Contract"
                                ];
                                ?>

                                <option value="">
                                    Select Type
                                </option>

                                <?php foreach (
                                    $types as $type
                                ): ?>

                                    <option
                                        value="<?php
                                            echo $type;
                                        ?>"
                                        <?php
                                        echo (
                                            $job[
                                                "employment_type"
                                            ] == $type
                                        )
                                            ? "selected"
                                            : "";
                                        ?>
                                    >

                                        <?php echo $type; ?>

                                    </option>

                                <?php endforeach; ?>

                            </select>

                        </div>

                    </div>


                    <div class="mb-3">

                        <label class="form-label">
                            Experience
                        </label>

                        <input
                            type="text"
                            name="experience"
                            class="form-control"
                            value="<?php
                                echo htmlspecialchars(
                                    $job["experience"]
                                );
                            ?>"
                        >

                    </div>


                    <div class="mb-3">

                        <label class="form-label">
                            Job Description
                        </label>

                        <textarea
                            name="description"
                            class="form-control"
                            rows="7"
                            required
                        ><?php
                            echo htmlspecialchars(
                                $job["description"]
                            );
                        ?></textarea>

                    </div>


                    <div class="form-check mb-4">

                        <input
                            class="form-check-input"
                            type="checkbox"
                            name="status"
                            id="status"
                            <?php
                            echo $job["status"]
                                ? "checked"
                                : "";
                            ?>
                        >

                        <label
                            class="form-check-label"
                            for="status"
                        >

                            Active Job Opening

                        </label>

                    </div>


                    <button
                        type="submit"
                        class="btn btn-primary"
                    >

                        <i class="fas fa-save me-2"></i>

                        Update Job

                    </button>


                    <a
                        href="careers.php"
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