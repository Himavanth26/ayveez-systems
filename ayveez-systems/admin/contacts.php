<?php


include "../includes/db.php";

$page_title = "Messages";
$current_page = "contacts";

include "includes/admin-header.php";
include "includes/sidebar.php";


$sql = "SELECT *
        FROM contacts
        ORDER BY id DESC";

$result = $conn->query($sql);

?>


<main class="main-content">


    <div class="topbar">

        <div>

            <h5>Messages</h5>

            <span>
                Customer enquiries and contact messages
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
                Customer Messages
            </h2>

            <p>
                Review enquiries submitted through
                your website.
            </p>

        </div>


        <div class="table-card">

            <div class="table-responsive">

                <table class="table align-middle">

                    <thead>

                        <tr>

                            <th>ID</th>

                            <th>Customer</th>

                            <th>Subject</th>

                            <th>Email</th>

                            <th>Phone</th>

                            <th>Status</th>

                            <th>Date</th>

                            <th>Action</th>

                        </tr>

                    </thead>


                    <tbody>


                    <?php if (
                        $result &&
                        $result->num_rows > 0
                    ): ?>


                        <?php while (
                            $message =
                            $result->fetch_assoc()
                        ): ?>


                            <tr>


                                <td>

                                    <?php
                                    echo $message["id"];
                                    ?>

                                </td>


                                <td>

                                    <strong>

                                        <?php

                                        echo htmlspecialchars(
                                            $message["name"]
                                        );

                                        ?>

                                    </strong>

                                </td>


                                <td>

                                    <?php

                                    echo htmlspecialchars(
                                        $message["subject"]
                                        ?: "No Subject"
                                    );

                                    ?>

                                </td>


                                <td>

                                    <a
                                        href="mailto:<?php

                                            echo htmlspecialchars(
                                                $message["email"]
                                            );

                                        ?>"
                                    >

                                        <?php

                                        echo htmlspecialchars(
                                            $message["email"]
                                        );

                                        ?>

                                    </a>

                                </td>


                                <td>

                                    <?php

                                    echo htmlspecialchars(
                                        $message["phone"]
                                    );

                                    ?>

                                </td>


                                <td>

                                    <?php if (
                                        $message["status"]
                                        === "new"
                                    ): ?>

                                        <span
                                            class="badge bg-primary"
                                        >
                                            New
                                        </span>

                                    <?php else: ?>

                                        <span
                                            class="badge bg-success"
                                        >
                                            Read
                                        </span>

                                    <?php endif; ?>

                                </td>


                                <td>

                                    <?php

                                    echo date(
                                        "d M Y",
                                        strtotime(
                                            $message[
                                                "created_at"
                                            ]
                                        )
                                    );

                                    ?>

                                </td>


                                <td>

                                    <a
                                        href="view-message.php?id=<?php

                                            echo $message["id"];

                                        ?>"
                                        class="btn
                                               btn-sm
                                               btn-outline-primary"
                                    >

                                        <i
                                            class="fas fa-eye"
                                        ></i>

                                        View

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
                                    class="fas fa-envelope-open"
                                    style="
                                        font-size:40px;
                                        color:#94a3b8;
                                    "
                                ></i>

                                <h5 class="mt-3">
                                    No messages
                                </h5>

                                <p class="text-muted">
                                    Customer enquiries will
                                    appear here.
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