<?php


include "../includes/db.php";

$page_title = "Applications";
$current_page = "applications";

include "includes/admin-header.php";
include "includes/sidebar.php";


$sql = "SELECT
            job_applications.*,
            careers.job_title
        FROM job_applications
        LEFT JOIN careers
            ON job_applications.job_id = careers.id
        ORDER BY job_applications.id DESC";

$result = $conn->query($sql);

?>


<main class="main-content">


    <div class="topbar">

        <div>

            <h5>Applications</h5>

            <span>
                Manage job applications
            </span>

        </div>


        <div class="admin-user">

            <div class="admin-avatar">

                <?php

                echo strtoupper(
                    substr(
                        $_SESSION["admin_name"],
                        0,
                        1
                    )
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

                <small>
                    Administrator
                </small>

            </div>

        </div>

    </div>


    <div class="dashboard-content">


        <div class="mb-4">

            <h2>
                Job Applications
            </h2>

            <p>
                Review candidates who applied
                for your job openings.
            </p>

        </div>


        <div class="table-card">

            <div class="table-responsive">

                <table class="table align-middle">

                    <thead>

                        <tr>

                            <th>ID</th>

                            <th>Applicant</th>

                            <th>Position</th>

                            <th>Email</th>

                            <th>Phone</th>

                            <th>Status</th>

                            <th>Date</th>

                            <th>Resume</th>

                        </tr>

                    </thead>


                    <tbody>


                    <?php if (
                        $result &&
                        $result->num_rows > 0
                    ): ?>


                        <?php while (
                            $application =
                            $result->fetch_assoc()
                        ): ?>


                            <tr>


                                <td>

                                    <?php

                                    echo $application["id"];

                                    ?>

                                </td>


                                <td>

                                    <strong>

                                        <?php

                                        echo htmlspecialchars(
                                            $application["name"]
                                        );

                                        ?>

                                    </strong>

                                </td>


                                <td>

                                    <?php

                                    echo htmlspecialchars(
                                        $application["job_title"]
                                        ?? "Unknown Position"
                                    );

                                    ?>

                                </td>


                                <td>

                                    <a
                                        href="mailto:<?php

                                            echo htmlspecialchars(
                                                $application["email"]
                                            );

                                        ?>"
                                    >

                                        <?php

                                        echo htmlspecialchars(
                                            $application["email"]
                                        );

                                        ?>

                                    </a>

                                </td>


                                <td>

                                    <?php

                                    echo htmlspecialchars(
                                        $application["phone"]
                                    );

                                    ?>

                                </td>


                                <td>

                                    <?php

                                    $status =
                                        $application["status"];

                                    ?>


                                    <?php if (
                                        $status === "new"
                                    ): ?>

                                        <span
                                            class="badge bg-primary"
                                        >
                                            New
                                        </span>

                                    <?php elseif (
                                        $status === "reviewed"
                                    ): ?>

                                        <span
                                            class="badge bg-info"
                                        >
                                            Reviewed
                                        </span>

                                    <?php elseif (
                                        $status === "shortlisted"
                                    ): ?>

                                        <span
                                            class="badge bg-success"
                                        >
                                            Shortlisted
                                        </span>

                                    <?php elseif (
                                        $status === "rejected"
                                    ): ?>

                                        <span
                                            class="badge bg-danger"
                                        >
                                            Rejected
                                        </span>

                                    <?php else: ?>

                                        <span
                                            class="badge bg-secondary"
                                        >

                                            <?php

                                            echo htmlspecialchars(
                                                ucfirst(
                                                    $status
                                                )
                                            );

                                            ?>

                                        </span>

                                    <?php endif; ?>


                                </td>


                                <td>

                                    <?php

                                    echo date(
                                        "d M Y",
                                        strtotime(
                                            $application[
                                                "created_at"
                                            ]
                                        )
                                    );

                                    ?>

                                </td>


                                <td>

                                    <?php if (
                                        !empty(
                                            $application[
                                                "resume"
                                            ]
                                        )
                                    ): ?>

                                        <a
                                            href="../assets/uploads/resumes/<?php

                                                echo htmlspecialchars(
                                                    $application[
                                                        "resume"
                                                    ]
                                                );

                                            ?>"
                                            target="_blank"
                                            class="btn
                                                   btn-sm
                                                   btn-outline-primary"
                                        >

                                            <i
                                                class="fas fa-file-pdf"
                                            ></i>

                                            View

                                        </a>

                                    <?php endif; ?>

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
                                    class="fas fa-file-circle-xmark"
                                    style="
                                        font-size:40px;
                                        color:#94a3b8;
                                    "
                                ></i>

                                <h5 class="mt-3">
                                    No applications yet
                                </h5>

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