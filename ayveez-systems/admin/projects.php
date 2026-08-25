<?php

session_start();

include "../includes/db.php";

$page_title = "Projects";
$current_page = "projects";

include "includes/admin-header.php";
include "includes/sidebar.php";

$sql = "SELECT *
        FROM projects
        ORDER BY id DESC";

$result = $conn->query($sql);

?>

<main class="main-content">

    <div class="topbar">

        <div>

            <h5>Projects</h5>

            <span>
                Manage Ayveez Systems portfolio
            </span>

        </div>

        <div class="admin-user">

            <div class="admin-avatar">

                <?php
                echo strtoupper(
                    substr($_SESSION["admin_name"], 0, 1)
                );
                ?>

            </div>

            <div>

                <strong>
                    <?php
                    echo htmlspecialchars(
                        $_SESSION["admin_name"]
                    );
                    ?>
                </strong>

                <small>Administrator</small>

            </div>

        </div>

    </div>


    <div class="dashboard-content">

        <div class="d-flex
                    justify-content-between
                    align-items-center
                    mb-4">

            <div>

                <h2>Projects</h2>

                <p>
                    Manage your portfolio projects.
                </p>

            </div>

            <a
                href="add-project.php"
                class="btn btn-primary"
            >

                <i class="fas fa-plus me-2"></i>

                Add New Project

            </a>

        </div>


        <div class="table-card">

            <div class="table-responsive">

                <table class="table align-middle">

                    <thead>

                        <tr>

                            <th>ID</th>

                            <th>Image</th>

                            <th>Project</th>

                            <th>Category</th>

                            <th>Technology</th>

                            <th>Status</th>

                            <th>Actions</th>

                        </tr>

                    </thead>


                    <tbody>

                    <?php if (
                        $result &&
                        $result->num_rows > 0
                    ): ?>

                        <?php while (
                            $project = $result->fetch_assoc()
                        ): ?>

                            <tr>

                                <td>
                                    <?php
                                    echo $project["id"];
                                    ?>
                                </td>


                                <td>

                                    <?php if (
                                        !empty(
                                            $project["image"]
                                        )
                                    ): ?>

                                        <img
                                            src="../assets/uploads/<?php
                                                echo htmlspecialchars(
                                                    $project["image"]
                                                );
                                            ?>"
                                            class="project-thumb"
                                            alt="Project"
                                        >

                                    <?php else: ?>

                                        <div class="project-placeholder">

                                            <i class="fas fa-image"></i>

                                        </div>

                                    <?php endif; ?>

                                </td>


                                <td>

                                    <strong>

                                        <?php
                                        echo htmlspecialchars(
                                            $project["project_name"]
                                        );
                                        ?>

                                    </strong>

                                </td>


                                <td>

                                    <?php
                                    echo htmlspecialchars(
                                        $project["category"]
                                    );
                                    ?>

                                </td>


                                <td>

                                    <span class="technology-text">

                                        <?php
                                        echo htmlspecialchars(
                                            $project["technology"]
                                        );
                                        ?>

                                    </span>

                                </td>


                                <td>

                                    <?php if (
                                        $project["status"] == 1
                                    ): ?>

                                        <span
                                            class="badge bg-success"
                                        >
                                            Active
                                        </span>

                                    <?php else: ?>

                                        <span
                                            class="badge bg-secondary"
                                        >
                                            Inactive
                                        </span>

                                    <?php endif; ?>

                                </td>


                                <td>

                                    <a
                                        href="edit-project.php?id=<?php
                                            echo $project["id"];
                                        ?>"
                                        class="btn
                                               btn-sm
                                               btn-outline-primary
                                               me-1"
                                    >

                                        <i class="fas fa-edit"></i>

                                    </a>


                                    <a
                                        href="delete-project.php?id=<?php
                                            echo $project["id"];
                                        ?>"
                                        class="btn
                                               btn-sm
                                               btn-outline-danger"
                                        onclick="
                                            return confirm(
                                                'Are you sure you want to delete this project?'
                                            );
                                        "
                                    >

                                        <i class="fas fa-trash"></i>

                                    </a>

                                </td>

                            </tr>

                        <?php endwhile; ?>

                    <?php else: ?>

                        <tr>

                            <td
                                colspan="7"
                                class="text-center py-5"
                            >

                                No projects found.

                            </td>

                        </tr>

                    <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</main>


<?php

include "includes/admin-footer.php";

?>