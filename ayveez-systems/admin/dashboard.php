<?php




// --------------------------------------------------
// DATABASE CONNECTION
// --------------------------------------------------

include "../includes/db.php";


// --------------------------------------------------
// COUNT FUNCTION
// --------------------------------------------------

function getCount($conn, $table)
{
    $allowed_tables = [
        "services",
        "projects",
        "team",
        "careers",
        "job_applications",
        "contacts"
    ];

    if (!in_array($table, $allowed_tables)) {
        return 0;
    }

    $sql = "SELECT COUNT(*) AS total FROM `$table`";

    $result = $conn->query($sql);

    if ($result) {

        $row = $result->fetch_assoc();

        return (int) $row["total"];

    }

    return 0;
}


// --------------------------------------------------
// DASHBOARD COUNTS
// --------------------------------------------------

$services_count =
    getCount($conn, "services");

$projects_count =
    getCount($conn, "projects");

$team_count =
    getCount($conn, "team");

$careers_count =
    getCount($conn, "careers");

$applications_count =
    getCount($conn, "job_applications");

$contacts_count =
    getCount($conn, "contacts");


// --------------------------------------------------
// ADMIN NAME
// --------------------------------------------------

$admin_name =
    $_SESSION["admin_name"] ?? "Administrator";


// Get first letter for avatar

$admin_initial =
    strtoupper(
        substr(
            $admin_name,
            0,
            1
        )
    );

    $messages_count =
    getCount(
        $conn,
        "contacts"
    );
?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Dashboard | Ayveez Systems
    </title>


    <!-- Bootstrap -->

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >


    <!-- Font Awesome -->

    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        rel="stylesheet"
    >


    <!-- Google Font -->

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap"
        rel="stylesheet"
    >


    <!-- Admin CSS -->

    <link
        rel="stylesheet"
        href="admin.css"
    >

</head>


<body>


<div class="admin-wrapper">


    <!-- ==================================================
         SIDEBAR
    =================================================== -->

    <aside class="sidebar">


        <!-- BRAND -->

        <div class="sidebar-brand">

            <h4>
                Ayveez Systems
            </h4>

            <span>
                Admin Panel
            </span>

        </div>


        <!-- MENU -->

        <ul class="sidebar-menu">


            <!-- DASHBOARD -->

            <li>

                <a
                    href="dashboard.php"
                    class="active"
                >

                    <i class="fas fa-chart-line"></i>

                    Dashboard

                </a>

            </li>


            <!-- SERVICES -->

            <li>

                <a href="services.php">

                    <i class="fas fa-layer-group"></i>

                    Services

                </a>

            </li>


            <!-- PROJECTS -->

            <li>

                <a href="projects.php">

                    <i class="fas fa-briefcase"></i>

                    Projects

                </a>

            </li>


            <!-- TEAM -->

            <li>

                <a href="team.php">

                    <i class="fas fa-users"></i>

                    Team

                </a>

            </li>


            <!-- CAREERS -->

            <li>

                <a href="careers.php">

                    <i class="fas fa-user-tie"></i>

                    Careers

                </a>

            </li>


            <!-- APPLICATIONS -->

            <li>

                <a href="applications.php">

                    <i class="fas fa-file-alt"></i>

                    Applications

                </a>

            </li>


            <!-- CONTACT MESSAGES -->

            <li>

                <a href="contacts.php">

                    <i class="fas fa-envelope"></i>

                    Messages

                </a>

            </li>


            <!-- LOGOUT -->

            <li class="logout-menu">

                <a href="logout.php">

                    <i class="fas fa-sign-out-alt"></i>

                    Logout

                </a>

            </li>


        </ul>


    </aside>



    <!-- ==================================================
         MAIN CONTENT
    =================================================== -->

    <main class="main-content">


        <!-- ==================================================
             TOP BAR
        =================================================== -->

        <div class="topbar">


            <div>

                <h5>
                    Dashboard
                </h5>

                <span>
                    Welcome to Ayveez Systems Admin Panel
                </span>

            </div>


            <!-- ADMIN USER -->

            <div class="admin-user">


                <div class="admin-avatar">

                    <?php

                    echo htmlspecialchars(
                        $admin_initial
                    );

                    ?>

                </div>


                <div>

                    <strong>

                        <?php

                        echo htmlspecialchars(
                            $admin_name
                        );

                        ?>

                    </strong>


                    <small>
                        Administrator
                    </small>

                </div>


            </div>


        </div>



        <!-- ==================================================
             DASHBOARD CONTENT
        =================================================== -->

        <div class="dashboard-content">


            <!-- PAGE INTRO -->

            <div class="mb-4">

                <h2>
                    Overview
                </h2>

                <p>
                    Manage your Ayveez Systems website
                    from one place.
                </p>

            </div>



            <!-- ==================================================
                 STATISTICS
            =================================================== -->

            <div class="row g-4">


                <!-- SERVICES -->

                <div class="col-xl-3 col-md-6">

                    <div class="stat-card">


                        <div class="stat-icon blue">

                            <i
                                class="fas fa-layer-group"
                            ></i>

                        </div>


                        <div>

                            <span>
                                Services
                            </span>


                            <h2>

                                <?php

                                echo $services_count;

                                ?>

                            </h2>

                        </div>


                    </div>

                </div>



                <!-- PROJECTS -->

                <div class="col-xl-3 col-md-6">

                    <div class="stat-card">


                        <div class="stat-icon purple">

                            <i
                                class="fas fa-briefcase"
                            ></i>

                        </div>


                        <div>

                            <span>
                                Projects
                            </span>


                            <h2>

                                <?php

                                echo $projects_count;

                                ?>

                            </h2>

                        </div>


                    </div>

                </div>



                <!-- TEAM -->

                <div class="col-xl-3 col-md-6">

                    <div class="stat-card">


                        <div class="stat-icon green">

                            <i
                                class="fas fa-users"
                            ></i>

                        </div>


                        <div>

                            <span>
                                Team Members
                            </span>


                            <h2>

                                <?php

                                echo $team_count;

                                ?>

                            </h2>

                        </div>


                    </div>

                </div>



                <!-- JOB OPENINGS -->

                <div class="col-xl-3 col-md-6">

                    <div class="stat-card">


                        <div class="stat-icon orange">

                            <i
                                class="fas fa-user-tie"
                            ></i>

                        </div>


                        <div>

                            <span>
                                Job Openings
                            </span>


                            <h2>

                                <?php

                                echo $careers_count;

                                ?>

                            </h2>

                        </div>


                    </div>

                </div>



                <!-- APPLICATIONS -->

                <div class="col-xl-3 col-md-6">

                    <div class="stat-card">


                        <div class="stat-icon blue">

                            <i
                                class="fas fa-file-alt"
                            ></i>

                        </div>


                        <div>

                            <span>
                                Applications
                            </span>


                            <h2>

                                <?php

                                echo $applications_count;

                                ?>

                            </h2>

                        </div>


                    </div>

                </div>


            </div>



            <!-- ==================================================
                 SECOND ROW
            =================================================== -->

            <div class="row g-4 mt-1">


                <!-- CONTACT MESSAGES -->

                <div class="col-lg-4">

                    <div class="message-card">


                        <div class="card-header-custom">


                            <div>

                                <h5>
                                    Contact Messages
                                </h5>

                                <span>
                                    Total messages received
                                </span>

                            </div>


                            <i
                                class="fas fa-envelope"
                            ></i>


                        </div>


                        <div class="message-number">

                            <?php

                            echo $contacts_count;

                            ?>

                        </div>


                        <a
                            href="contacts.php"
                            class="btn btn-primary"
                        >

                            View Messages

                        </a>


                    </div>

                </div>



                <!-- QUICK ACTIONS -->

                <div class="col-lg-8">

                    <div class="quick-card">


                        <h5>
                            Quick Actions
                        </h5>


                        <p>
                            Quickly manage your website
                            content.
                        </p>


                        <div class="row g-3">


                            <!-- ADD SERVICE -->

                            <div class="col-md-4">

                                <a
                                    href="add-service.php"
                                    class="quick-action"
                                >

                                    <i
                                        class="fas fa-plus-circle"
                                    ></i>

                                    <span>
                                        Add Service
                                    </span>

                                </a>

                            </div>



                            <!-- ADD PROJECT -->

                            <div class="col-md-4">

                                <a
                                    href="add-project.php"
                                    class="quick-action"
                                >

                                    <i
                                        class="fas fa-folder-plus"
                                    ></i>

                                    <span>
                                        Add Project
                                    </span>

                                </a>

                            </div>



                            <!-- ADD JOB -->

                            <div class="col-md-4">

                                <a
                                    href="add-career.php"
                                    class="quick-action"
                                >

                                    <i
                                        class="fas fa-user-plus"
                                    ></i>

                                    <span>
                                        Add Job
                                    </span>

                                </a>

                            </div>



                            <!-- APPLICATIONS -->

                            <div class="col-md-4">

                                <a
                                    href="applications.php"
                                    class="quick-action"
                                >

                                    <i
                                        class="fas fa-file-alt"
                                    ></i>

                                    <span>
                                        Applications
                                    </span>

                                </a>

                            </div>

<div class="col-xl-3 col-md-6">

    <div class="stat-card">

        <div class="stat-icon">

            <i class="fas fa-envelope"></i>

        </div>

        <div>

            <span>
                Messages
            </span>

            <h3>

                <?php
                echo $messages_count;
                ?>

            </h3>

        </div>

    </div>

</div>

                            <!-- ADD TEAM MEMBER -->

                            <div class="col-md-4">

                                <a
                                    href="add-team.php"
                                    class="quick-action"
                                >

                                    <i
                                        class="fas fa-user-plus"
                                    ></i>

                                    <span>
                                        Add Team Member
                                    </span>

                                </a>

                            </div>


                        </div>


                    </div>

                </div>


            </div>



            <!-- ==================================================
                 WELCOME CARD
            =================================================== -->

            <div class="welcome-card mt-4">


                <div>


                    <span class="welcome-label">

                        AYVEEZ SYSTEMS

                    </span>


                    <h3>

                        Systems That Take Off

                    </h3>


                    <p>

                        Build, manage and grow your digital
                        presence from your administration panel.

                    </p>


                </div>


                <i
                    class="fas fa-rocket"
                ></i>


            </div>


        </div>


    </main>


</div>


<!-- Bootstrap JS -->

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
></script>


</body>

</html>