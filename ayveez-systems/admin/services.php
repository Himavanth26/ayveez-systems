<?php

session_start();

include "../includes/db.php";

$page_title = "Services";

$current_page = "services";

include "includes/admin-header.php";

include "includes/sidebar.php";

$sql = "SELECT *
        FROM services
        ORDER BY id DESC";

$result = $conn->query($sql);

?>

<main class="main-content">

    <div class="topbar">

        <div>

            <h5>Services</h5>

            <span>
                Manage Ayveez Systems services
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

                <h2>Services</h2>

                <p>
                    Manage your company's services.
                </p>

            </div>


            <a
                href="add-service.php"
                class="btn btn-primary"
            >

                <i class="fas fa-plus me-2"></i>

                Add New Service

            </a>

        </div>


        <div class="table-card">

            <div class="table-responsive">

                <table class="table align-middle">

                    <thead>

                        <tr>

                            <th>ID</th>

                            <th>Icon</th>

                            <th>Service</th>

                            <th>Description</th>

                            <th>Status</th>

                            <th>Actions</th>

                        </tr>

                    </thead>


                    <tbody>

                    <?php if ($result &&
                              $result->num_rows > 0): ?>

                        <?php while (
                            $row = $result->fetch_assoc()
                        ): ?>

                            <tr>

                                <td>
                                    <?php
                                    echo $row["id"];
                                    ?>
                                </td>


                                <td>

                                    <div class="service-icon">

                                        <i class="<?php
                                            echo htmlspecialchars(
                                                $row["icon"]
                                            );
                                        ?>"></i>

                                    </div>

                                </td>


                                <td>

                                    <strong>

                                        <?php
                                        echo htmlspecialchars(
                                            $row["title"]
                                        );
                                        ?>

                                    </strong>

                                </td>


                                <td>

                                    <div class="description-cell">

                                        <?php
                                        echo htmlspecialchars(
                                            $row["description"]
                                        );
                                        ?>

                                    </div>

                                </td>


                                <td>

                                    <?php
                                    if ($row["status"] == 1):
                                    ?>

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
                                        href="edit-service.php?id=<?php
                                            echo $row["id"];
                                        ?>"
                                        class="btn
                                               btn-sm
                                               btn-outline-primary
                                               me-1"
                                    >

                                        <i class="fas fa-edit"></i>

                                    </a>


                                    <a
                                        href="delete-service.php?id=<?php
                                            echo $row["id"];
                                        ?>"
                                        class="btn
                                               btn-sm
                                               btn-outline-danger"
                                        onclick="
                                            return confirm(
                                                'Are you sure you want to delete this service?'
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
                                colspan="6"
                                class="text-center py-5"
                            >

                                No services found.

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