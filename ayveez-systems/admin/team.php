<?php

session_start();

include "../includes/db.php";

$page_title = "Team";
$current_page = "team";

include "includes/admin-header.php";
include "includes/sidebar.php";

$sql = "SELECT *
        FROM team
        ORDER BY id DESC";

$result = $conn->query($sql);

?>

<main class="main-content">

    <div class="topbar">

        <div>

            <h5>Team</h5>

            <span>
                Manage Ayveez Systems team members
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

                <h2>Team Members</h2>

                <p>
                    Manage your company team members.
                </p>

            </div>

            <a
                href="add-team.php"
                class="btn btn-primary"
            >

                <i class="fas fa-plus me-2"></i>

                Add Team Member

            </a>

        </div>


        <div class="row g-4">

            <?php if (
                $result &&
                $result->num_rows > 0
            ): ?>

                <?php while (
                    $member = $result->fetch_assoc()
                ): ?>

                    <div class="col-xl-3
                                col-lg-4
                                col-md-6">

                        <div class="team-admin-card">

                            <?php if (
                                !empty($member["image"])
                            ): ?>

                                <img
                                    src="../assets/uploads/<?php
                                        echo htmlspecialchars(
                                            $member["image"]
                                        );
                                    ?>"
                                    alt="<?php
                                        echo htmlspecialchars(
                                            $member["name"]
                                        );
                                    ?>"
                                    class="team-admin-image"
                                >

                            <?php else: ?>

                                <div class="team-admin-placeholder">

                                    <i class="fas fa-user"></i>

                                </div>

                            <?php endif; ?>


                            <div class="team-admin-content">

                                <h5>

                                    <?php
                                    echo htmlspecialchars(
                                        $member["name"]
                                    );
                                    ?>

                                </h5>

                                <span class="team-designation">

                                    <?php
                                    echo htmlspecialchars(
                                        $member["designation"]
                                    );
                                    ?>

                                </span>


                                <p>

                                    <?php
                                    echo htmlspecialchars(
                                        $member["description"]
                                    );
                                    ?>

                                </p>


                                <?php if (
                                    $member["status"] == 1
                                ): ?>

                                    <span
                                        class="badge bg-success mb-3"
                                    >
                                        Active
                                    </span>

                                <?php else: ?>

                                    <span
                                        class="badge bg-secondary mb-3"
                                    >
                                        Inactive
                                    </span>

                                <?php endif; ?>


                                <div>

                                    <a
                                        href="edit-team.php?id=<?php
                                            echo $member["id"];
                                        ?>"
                                        class="btn
                                               btn-sm
                                               btn-outline-primary"
                                    >

                                        <i class="fas fa-edit"></i>

                                    </a>


                                    <a
                                        href="delete-team.php?id=<?php
                                            echo $member["id"];
                                        ?>"
                                        class="btn
                                               btn-sm
                                               btn-outline-danger"
                                        onclick="
                                            return confirm(
                                                'Are you sure you want to delete this team member?'
                                            );
                                        "
                                    >

                                        <i class="fas fa-trash"></i>

                                    </a>

                                </div>

                            </div>

                        </div>

                    </div>

                <?php endwhile; ?>

            <?php else: ?>

                <div class="col-12">

                    <div class="table-card text-center py-5">

                        <i
                            class="fas fa-users mb-3"
                            style="font-size:40px;color:#94a3b8;"
                        ></i>

                        <h5>
                            No team members found
                        </h5>

                        <p class="text-muted">
                            Add your first team member.
                        </p>

                    </div>

                </div>

            <?php endif; ?>

        </div>

    </div>

</main>


<?php

include "includes/admin-footer.php";

?>