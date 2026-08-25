<?php

session_start();

include "../includes/db.php";

$page_title = "Careers";
$current_page = "careers";

include "includes/admin-header.php";
include "includes/sidebar.php";

$sql = "SELECT *
        FROM careers
        ORDER BY id DESC";

$result = $conn->query($sql);

?>

<main class="main-content">

    <div class="topbar">

        <div>

            <h5>Careers</h5>

            <span>
                Manage Ayveez Systems job openings
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

                <h2>Job Openings</h2>

                <p>
                    Manage current career opportunities.
                </p>

            </div>

            <a
                href="add-career.php"
                class="btn btn-primary"
            >

                <i class="fas fa-plus me-2"></i>

                Add Job Opening

            </a>

        </div>


        <div class="table-card">

            <div class="table-responsive">

                <table class="table align-middle">

                    <thead>

                        <tr>

                            <th>ID</th>

                            <th>Job Title</th>

                            <th>Department</th>

                            <th>Location</th>

                            <th>Type</th>

                            <th>Experience</th>

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
                            $job = $result->fetch_assoc()
                        ): ?>

                            <tr>

                                <td>
                                    <?php
                                    echo $job["id"];
                                    ?>
                                </td>


                                <td>

                                    <strong>

                                        <?php
                                        echo htmlspecialchars(
                                            $job["job_title"]
                                        );
                                        ?>

                                    </strong>

                                </td>


                                <td>

                                    <?php
                                    echo htmlspecialchars(
                                        $job["department"]
                                    );
                                    ?>

                                </td>


                                <td>

                                    <i
                                        class="fas fa-location-dot me-1"
                                    ></i>

                                    <?php
                                    echo htmlspecialchars(
                                        $job["location"]
                                    );
                                    ?>

                                </td>


                                <td>

                                    <?php
                                    echo htmlspecialchars(
                                        $job["employment_type"]
                                    );
                                    ?>

                                </td>


                                <td>

                                    <?php
                                    echo htmlspecialchars(
                                        $job["experience"]
                                    );
                                    ?>

                                </td>


                                <td>

                                    <?php if (
                                        $job["status"] == 1
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
                                            Closed
                                        </span>

                                    <?php endif; ?>

                                </td>


                                <td>

                                    <a
                                        href="edit-career.php?id=<?php
                                            echo $job["id"];
                                        ?>"
                                        class="btn
                                               btn-sm
                                               btn-outline-primary
                                               me-1"
                                    >

                                        <i class="fas fa-edit"></i>

                                    </a>


                                    <a
                                        href="delete-career.php?id=<?php
                                            echo $job["id"];
                                        ?>"
                                        class="btn
                                               btn-sm
                                               btn-outline-danger"
                                        onclick="
                                            return confirm(
                                                'Are you sure you want to delete this job opening?'
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
                                colspan="8"
                                class="text-center py-5"
                            >

                                <i
                                    class="fas fa-briefcase mb-3"
                                    style="
                                        font-size:40px;
                                        color:#94a3b8;
                                    "
                                ></i>

                                <h5>
                                    No job openings
                                </h5>

                                <p class="text-muted">
                                    Add your first career opportunity.
                                </p>

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