<?php


include "../includes/db.php";


if (
    !isset($_GET["id"]) ||
    !is_numeric($_GET["id"])
) {
    header("Location: contacts.php");
    exit;
}


$id = (int) $_GET["id"];


/*
|--------------------------------------------------------------------------
| GET MESSAGE
|--------------------------------------------------------------------------
*/

$sql = "SELECT *
        FROM contacts
        WHERE id = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $id);

$stmt->execute();

$result = $stmt->get_result();


if ($result->num_rows !== 1) {

    header("Location: contacts.php");
    exit;

}


$message = $result->fetch_assoc();


/*
|--------------------------------------------------------------------------
| MARK AS READ
|--------------------------------------------------------------------------
*/

if ($message["status"] === "new") {

    $update_sql = "UPDATE contacts
                   SET status = 'read'
                   WHERE id = ?";

    $update_stmt =
        $conn->prepare($update_sql);

    $update_stmt->bind_param(
        "i",
        $id
    );

    $update_stmt->execute();

    $update_stmt->close();

}


$page_title = "View Message";
$current_page = "contacts";

include "includes/admin-header.php";
include "includes/sidebar.php";

?>


<main class="main-content">


    <div class="topbar">

        <div>

            <h5>Message Details</h5>

            <span>
                Customer enquiry
            </span>

        </div>

    </div>


    <div class="dashboard-content">


        <div class="message-card">


            <div class="message-header">


                <div>

                    <span class="message-label">
                        FROM
                    </span>

                    <h3>

                        <?php

                        echo htmlspecialchars(
                            $message["name"]
                        );

                        ?>

                    </h3>

                </div>


                <span class="badge bg-success">
                    Read
                </span>

            </div>


            <hr>


            <div class="message-details">


                <div class="message-detail">

                    <span>
                        Email
                    </span>

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

                </div>


                <div class="message-detail">

                    <span>
                        Phone
                    </span>

                    <strong>

                        <?php

                        echo htmlspecialchars(
                            $message["phone"]
                        );

                        ?>

                    </strong>

                </div>


                <div class="message-detail">

                    <span>
                        Subject
                    </span>

                    <strong>

                        <?php

                        echo htmlspecialchars(
                            $message["subject"]
                            ?: "No Subject"
                        );

                        ?>

                    </strong>

                </div>


                <div class="message-detail">

                    <span>
                        Received
                    </span>

                    <strong>

                        <?php

                        echo date(
                            "d M Y, h:i A",
                            strtotime(
                                $message["created_at"]
                            )
                        );

                        ?>

                    </strong>

                </div>


            </div>


            <div class="message-body">


                <h5>
                    Message
                </h5>


                <div class="message-text">

                    <?php

                    echo nl2br(
                        htmlspecialchars(
                            $message["message"]
                        )
                    );

                    ?>

                </div>


            </div>


            <div class="message-actions">


                <a
                    href="mailto:<?php

                        echo htmlspecialchars(
                            $message["email"]
                        );

                    ?>?subject=Re: <?php

                        echo rawurlencode(
                            $message["subject"]
                            ?: "Your Enquiry"
                        );

                    ?>"
                    class="btn btn-primary"
                >

                    <i
                        class="fas fa-reply me-2"
                    ></i>

                    Reply by Email

                </a>


                <a
                    href="contacts.php"
                    class="btn btn-secondary"
                >

                    Back to Messages

                </a>


            </div>


        </div>

    </div>


</main>


<?php

include "includes/admin-footer.php";

?>