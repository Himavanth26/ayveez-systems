<?php

include "includes/config.php";
include "includes/db.php";

$error = "";
$success = "";


/*
|--------------------------------------------------------------------------
| GET JOB
|--------------------------------------------------------------------------
*/

if (
    !isset($_GET["job_id"]) ||
    !is_numeric($_GET["job_id"])
) {

    header("Location: careers.php");
    exit;

}

$job_id = (int) $_GET["job_id"];


$sql = "SELECT *
        FROM careers
        WHERE id = ?
        AND status = 1";

$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $job_id);

$stmt->execute();

$result = $stmt->get_result();


if ($result->num_rows !== 1) {

    header("Location: careers.php");
    exit;

}

$job = $result->fetch_assoc();


/*
|--------------------------------------------------------------------------
| APPLICATION SUBMISSION
|--------------------------------------------------------------------------
*/

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);
    $cover_message = trim($_POST["cover_message"]);


    /*
    |--------------------------------------------------------------------------
    | BASIC VALIDATION
    |--------------------------------------------------------------------------
    */

    if (
        empty($name) ||
        empty($email)
    ) {

        $error =
            "Name and email are required.";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $error =
            "Please enter a valid email address.";

    } elseif (
        !isset($_FILES["resume"]) ||
        $_FILES["resume"]["error"] !== UPLOAD_ERR_OK
    ) {

        $error =
            "Please upload your resume.";

    } else {


        /*
        |--------------------------------------------------------------------------
        | RESUME VALIDATION
        |--------------------------------------------------------------------------
        */

        $allowed_extensions = [
            "pdf",
            "doc",
            "docx"
        ];

        $file_name =
            $_FILES["resume"]["name"];

        $file_size =
            $_FILES["resume"]["size"];

        $extension = strtolower(
            pathinfo(
                $file_name,
                PATHINFO_EXTENSION
            )
        );


        if (
            !in_array(
                $extension,
                $allowed_extensions
            )
        ) {

            $error =
                "Only PDF, DOC and DOCX resumes are allowed.";

        }


        /*
        |--------------------------------------------------------------------------
        | FILE SIZE
        |--------------------------------------------------------------------------
        */

        elseif ($file_size > 5 * 1024 * 1024) {

            $error =
                "Resume must be smaller than 5 MB.";

        }


        /*
        |--------------------------------------------------------------------------
        | UPLOAD
        |--------------------------------------------------------------------------
        */

        else {

            $resume_name =
                uniqid("resume_", true)
                . "."
                . $extension;

            $resume_path =
                "assets/uploads/resumes/"
                . $resume_name;


            if (
                move_uploaded_file(
                    $_FILES["resume"]["tmp_name"],
                    $resume_path
                )
            ) {


                /*
                |--------------------------------------------------------------------------
                | SAVE APPLICATION
                |--------------------------------------------------------------------------
                */

                $sql = "INSERT INTO job_applications
                        (
                            job_id,
                            name,
                            email,
                            phone,
                            resume,
                            cover_message
                        )
                        VALUES (?, ?, ?, ?, ?, ?)";

                $stmt =
                    $conn->prepare($sql);

                $stmt->bind_param(
                    "isssss",
                    $job_id,
                    $name,
                    $email,
                    $phone,
                    $resume_name,
                    $cover_message
                );


                if ($stmt->execute()) {

                    $success =
                        "Your application has been submitted successfully.";

                } else {

                    /*
                     * Remove uploaded file if
                     * database insertion fails.
                     */

                    if (
                        file_exists($resume_path)
                    ) {

                        unlink($resume_path);

                    }

                    $error =
                        "Unable to submit your application. Please try again.";

                }

            } else {

                $error =
                    "Unable to upload your resume.";

            }

        }

    }

}


include "includes/header.php";
include "includes/navbar.php";

?>


<section class="apply-hero">

    <div class="container text-center">

        <span class="section-subtitle">

            CAREERS

        </span>

        <h1>

            Apply For This Position

        </h1>

        <p>

            Take the next step in your career
            with Ayveez Systems.

        </p>

    </div>

</section>


<section class="section">

    <div class="container">

        <div class="row justify-content-center">

            <div class="col-lg-9">


                <div class="application-card">


                    <!-- JOB INFORMATION -->

                    <div class="job-summary">

                        <span class="career-department">

                            <?php

                            echo htmlspecialchars(
                                $job["department"]
                            );

                            ?>

                        </span>


                        <h2>

                            <?php

                            echo htmlspecialchars(
                                $job["job_title"]
                            );

                            ?>

                        </h2>


                        <div class="career-meta">

                            <span>

                                <i
                                    class="fas fa-location-dot"
                                ></i>

                                <?php

                                echo htmlspecialchars(
                                    $job["location"]
                                );

                                ?>

                            </span>


                            <span>

                                <i
                                    class="fas fa-clock"
                                ></i>

                                <?php

                                echo htmlspecialchars(
                                    $job["employment_type"]
                                );

                                ?>

                            </span>


                            <span>

                                <i
                                    class="fas fa-briefcase"
                                ></i>

                                <?php

                                echo htmlspecialchars(
                                    $job["experience"]
                                );

                                ?>

                            </span>

                        </div>

                    </div>


                    <hr>


                    <?php if (!empty($success)): ?>

                        <div
                            class="alert alert-success"
                        >

                            <i
                                class="fas fa-circle-check me-2"
                            ></i>

                            <?php

                            echo htmlspecialchars(
                                $success
                            );

                            ?>

                        </div>


                        <div class="text-center mt-4">

                            <a
                                href="careers.php"
                                class="btn btn-main"
                            >

                                Back To Careers

                            </a>

                        </div>


                    <?php else: ?>


                        <?php if (!empty($error)): ?>

                            <div
                                class="alert alert-danger"
                            >

                                <i
                                    class="fas fa-circle-exclamation me-2"
                                ></i>

                                <?php

                                echo htmlspecialchars(
                                    $error
                                );

                                ?>

                            </div>

                        <?php endif; ?>


                        <h3 class="mb-4">

                            Application Details

                        </h3>


                        <form
                            method="POST"
                            enctype="multipart/form-data"
                        >


                            <div class="row">


                                <div class="col-md-6 mb-3">

                                    <label
                                        class="form-label"
                                    >

                                        Full Name
                                        <span>*</span>

                                    </label>


                                    <input
                                        type="text"
                                        name="name"
                                        class="form-control"
                                        placeholder="Your full name"
                                        required
                                        value="<?php

                                        echo isset(
                                            $_POST["name"]
                                        )
                                            ? htmlspecialchars(
                                                $_POST["name"]
                                            )
                                            : "";

                                        ?>"
                                    >

                                </div>


                                <div class="col-md-6 mb-3">

                                    <label
                                        class="form-label"
                                    >

                                        Email Address
                                        <span>*</span>

                                    </label>


                                    <input
                                        type="email"
                                        name="email"
                                        class="form-control"
                                        placeholder="you@example.com"
                                        required
                                        value="<?php

                                        echo isset(
                                            $_POST["email"]
                                        )
                                            ? htmlspecialchars(
                                                $_POST["email"]
                                            )
                                            : "";

                                        ?>"
                                    >

                                </div>

                            </div>


                            <div class="mb-3">

                                <label
                                    class="form-label"
                                >

                                    Phone Number

                                </label>


                                <input
                                    type="text"
                                    name="phone"
                                    class="form-control"
                                    placeholder="Your phone number"
                                    value="<?php

                                    echo isset(
                                        $_POST["phone"]
                                    )
                                        ? htmlspecialchars(
                                            $_POST["phone"]
                                        )
                                        : "";

                                    ?>"
                                >

                            </div>


                            <div class="mb-3">

                                <label
                                    class="form-label"
                                >

                                    Resume
                                    <span>*</span>

                                </label>


                                <input
                                    type="file"
                                    name="resume"
                                    class="form-control"
                                    accept=".pdf,.doc,.docx"
                                    required
                                >


                                <small
                                    class="text-muted"
                                >

                                    PDF, DOC or DOCX.
                                    Maximum size: 5 MB.

                                </small>

                            </div>


                            <div class="mb-4">

                                <label
                                    class="form-label"
                                >

                                    Cover Message

                                </label>


                                <textarea
                                    name="cover_message"
                                    class="form-control"
                                    rows="6"
                                    placeholder="Tell us briefly about yourself and why you are interested in this role..."
                                ><?php

                                echo isset(
                                    $_POST["cover_message"]
                                )
                                    ? htmlspecialchars(
                                        $_POST["cover_message"]
                                    )
                                    : "";

                                ?></textarea>

                            </div>


                            <button
                                type="submit"
                                class="btn btn-main"
                            >

                                Submit Application

                                <i
                                    class="fas fa-paper-plane ms-2"
                                ></i>

                            </button>


                        </form>

                    <?php endif; ?>

                </div>

            </div>

        </div>

    </div>

</section>


<?php

include "includes/footer.php";

?>