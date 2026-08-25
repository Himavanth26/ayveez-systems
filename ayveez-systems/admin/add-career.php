<?php

session_start();

if (!isset($_SESSION["admin_id"])) {
    header("Location: login.php");
    exit;
}

include "../includes/db.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $job_title = trim($_POST["job_title"]);
    $department = trim($_POST["department"]);
    $location = trim($_POST["location"]);
    $employment_type = trim($_POST["employment_type"]);
    $experience = trim($_POST["experience"]);
    $description = trim($_POST["description"]);

    if (
        empty($job_title) ||
        empty($description)
    ) {

        $error =
            "Job title and description are required.";

    } else {

        $sql = "INSERT INTO careers
                (
                    job_title,
                    department,
                    location,
                    employment_type,
                    experience,
                    description
                )
                VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);

        $stmt->bind_param(
            "ssssss",
            $job_title,
            $department,
            $location,
            $employment_type,
            $experience,
            $description
        );

        if ($stmt->execute()) {

            header("Location: careers.php");
            exit;

        } else {

            $error =
                "Unable to create job opening.";

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

<title>Add Job | Ayveez Systems</title>

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

                <h5>Add Job Opening</h5>

                <span>
                    Create a new career opportunity
                </span>

            </div>

        </div>


        <div class="dashboard-content">

            <div class="form-card">

                <h3>Add Job Opening</h3>

                <p class="text-muted">
                    Enter the job information below.
                </p>


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
                            placeholder="Example: PHP Developer"
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
                            placeholder="Example: Engineering"
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
                                placeholder="Example: Hyderabad / Remote"
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

                                <option value="">
                                    Select Type
                                </option>

                                <option value="Full Time">
                                    Full Time
                                </option>

                                <option value="Part Time">
                                    Part Time
                                </option>

                                <option value="Internship">
                                    Internship
                                </option>

                                <option value="Contract">
                                    Contract
                                </option>

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
                            placeholder="Example: 0-2 Years"
                        >

                    </div>


                    <div class="mb-4">

                        <label class="form-label">
                            Job Description
                        </label>

                        <textarea
                            name="description"
                            class="form-control"
                            rows="7"
                            placeholder="Describe the role, responsibilities and requirements..."
                            required
                        ></textarea>

                    </div>


                    <button
                        type="submit"
                        class="btn btn-primary"
                    >

                        <i class="fas fa-save me-2"></i>

                        Publish Job

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