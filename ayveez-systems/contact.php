<?php

include "includes/config.php";
include "includes/db.php";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION["csrf_token"])) {

    $_SESSION["csrf_token"] =
        bin2hex(
            random_bytes(32)
        );

}
$error = "";
$success = "";


/*
|--------------------------------------------------------------------------
| CONTACT FORM SUBMISSION
|--------------------------------------------------------------------------
*/

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (
    empty($_POST["csrf_token"]) ||
    empty($_SESSION["csrf_token"]) ||
    !hash_equals(
        $_SESSION["csrf_token"],
        $_POST["csrf_token"]
    )
) {

    $error = "Invalid form submission.";

} else {

    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);
    $subject = trim($_POST["subject"]);
    $message = trim($_POST["message"]);


    if (
        empty($name) ||
        empty($email) ||
        empty($message)
    ) {

        $error = "Please fill in all required fields.";

    } elseif (
        !filter_var($email, FILTER_VALIDATE_EMAIL)
    ) {

        $error = "Please enter a valid email address.";

    } else {

        $sql = "INSERT INTO contacts
                (
                    name,
                    email,
                    phone,
                    subject,
                    message
                )
                VALUES (?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);

        $stmt->bind_param(
            "sssss",
            $name,
            $email,
            $phone,
            $subject,
            $message
        );

        if ($stmt->execute()) {

            $success =
                "Thank you! Your message has been sent successfully.";

        } else {

            $error =
                "Unable to send your message. Please try again.";

        }

        $stmt->close();

    }

}


include "includes/header.php";
include "includes/navbar.php";

?>


<section class="contact-hero">

    <div class="container text-center">

        <span class="section-subtitle">
            CONTACT US
        </span>

        <h1>
            Let's Talk About Your Project
        </h1>

        <p>
            Have an idea, project or business requirement?
            We'd love to hear from you.
        </p>

    </div>

</section>


<section class="section">

    <div class="container">

        <div class="row g-5">


            <!-- CONTACT INFORMATION -->

            <div class="col-lg-5">

                <span class="section-subtitle">
                    GET IN TOUCH
                </span>

                <h2 class="contact-heading">
                    Let's Build Something Great Together
                </h2>

                <p class="contact-description">

                    Whether you need a new website, custom
                    software, mobile application or digital
                    solution, our team is ready to help.

                </p>


                <div class="contact-info-list">


                    <div class="contact-info-item">

                        <div class="contact-icon">

                            <i class="fas fa-envelope"></i>

                        </div>

                        <div>

                            <h5>Email</h5>

                            <a
                                href="mailto:hr.india@ayveez.com"
                            >
                               hr.india@ayveez.com
                            </a>

                        </div>

                    </div>


                    <div class="contact-info-item">

                        <div class="contact-icon">

                            <i class="fas fa-phone"></i>

                        </div>

                        <div>

                            <h5>Phone</h5>

                            <a href="tel:+919000000000">
                                +91 90000 00000
                            </a>

                        </div>

                    </div>


                    <div class="contact-info-item">

                        <div class="contact-icon">

                            <i class="fas fa-location-dot"></i>

                        </div>

                        <div>

                            <h5>Location</h5>

                            <p>
                                India
                            </p>

                        </div>

                    </div>


                </div>

            </div>


            <!-- CONTACT FORM -->

            <div class="col-lg-7">

                <div class="contact-form-card">


                    <?php if (!empty($success)): ?>

                        <div class="alert alert-success">

                            <i
                                class="fas fa-circle-check me-2"
                            ></i>

                            <?php
                            echo htmlspecialchars($success);
                            ?>

                        </div>

                    <?php endif; ?>


                    <?php if (!empty($error)): ?>

                        <div class="alert alert-danger">

                            <i
                                class="fas fa-circle-exclamation me-2"
                            ></i>

                            <?php
                            echo htmlspecialchars($error);
                            ?>

                        </div>

                    <?php endif; ?>


                    <h3>
                        Send Us a Message
                    </h3>

                    <p class="text-muted">
                        Fill out the form and our team
                        will get back to you.
                    </p>


                    <form method="POST">

    <input
        type="hidden"
        name="csrf_token"
        value="<?php
            echo htmlspecialchars(
                $_SESSION["csrf_token"]
            );
        ?>"
    >


                        <div class="row">


                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Name <span>*</span>
                                </label>

                                <input
                                    type="text"
                                    name="name"
                                    class="form-control"
                                    placeholder="Your name"
                                    required
                                    value="<?php

                                    echo isset($_POST["name"])
                                        ? htmlspecialchars(
                                            $_POST["name"]
                                        )
                                        : "";

                                    ?>"
                                >

                            </div>


                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Email <span>*</span>
                                </label>

                                <input
                                    type="email"
                                    name="email"
                                    class="form-control"
                                    placeholder="you@example.com"
                                    required
                                    value="<?php

                                    echo isset($_POST["email"])
                                        ? htmlspecialchars(
                                            $_POST["email"]
                                        )
                                        : "";

                                    ?>"
                                >

                            </div>


                        </div>


                        <div class="row">


                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Phone
                                </label>

                                <input
                                    type="text"
                                    name="phone"
                                    class="form-control"
                                    placeholder="Your phone number"
                                    value="<?php

                                    echo isset($_POST["phone"])
                                        ? htmlspecialchars(
                                            $_POST["phone"]
                                        )
                                        : "";

                                    ?>"
                                >

                            </div>


                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Subject
                                </label>

                                <input
                                    type="text"
                                    name="subject"
                                    class="form-control"
                                    placeholder="How can we help?"
                                    value="<?php

                                    echo isset($_POST["subject"])
                                        ? htmlspecialchars(
                                            $_POST["subject"]
                                        )
                                        : "";

                                    ?>"
                                >

                            </div>


                        </div>


                        <div class="mb-4">

                            <label class="form-label">
                                Message <span>*</span>
                            </label>

                            <textarea
                                name="message"
                                class="form-control"
                                rows="7"
                                placeholder="Tell us about your project or requirement..."
                                required
                            ><?php

                            echo isset($_POST["message"])
                                ? htmlspecialchars(
                                    $_POST["message"]
                                )
                                : "";

                            ?></textarea>

                        </div>


                        <button
                            type="submit"
                            class="btn btn-main"
                        >

                            Send Message

                            <i
                                class="fas fa-paper-plane ms-2"
                            ></i>

                        </button>


                    </form>

                </div>

            </div>

        </div>

    </div>

</section>


<section class="section bg-light">

    <div class="container text-center">

        <span class="section-subtitle">
            AYVEEZ SYSTEMS
        </span>

        <h2 class="mt-2">
            Have a software idea?
        </h2>

        <p>
            Let's turn your idea into a reliable
            digital solution.
        </p>

    </div>

</section>


<?php

include "includes/footer.php";

?>