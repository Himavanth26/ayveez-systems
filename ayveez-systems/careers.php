<?php

include "includes/config.php";
include "includes/db.php";
include "includes/header.php";
include "includes/navbar.php";

?>

<section class="careers-hero">

    <div class="container text-center">

        <span class="section-subtitle">
            CAREERS
        </span>

        <h1>
            Build Your Career With Us
        </h1>

        <p>
            Join Ayveez Systems and work with a team
            building meaningful technology solutions.
        </p>

    </div>

</section>


<section class="section">

    <div class="container">

        <div class="section-title">

            <span class="section-subtitle">
                OPEN POSITIONS
            </span>

            <h2>
                Current Opportunities
            </h2>

            <p>
                Explore our current job openings and
                find your next opportunity.
            </p>

        </div>


        <?php

        $sql = "SELECT *
                FROM careers
                WHERE status = 1
                ORDER BY id DESC";

        $result = $conn->query($sql);

        ?>


        <?php if (
            $result &&
            $result->num_rows > 0
        ): ?>


            <div class="career-list">

                <?php while (
                    $job = $result->fetch_assoc()
                ): ?>

                    <div class="career-card">

                        <div class="career-info">

                            <span class="career-department">

                                <?php
                                echo htmlspecialchars(
                                    $job["department"]
                                );
                                ?>

                            </span>


                            <h3>

                                <?php
                                echo htmlspecialchars(
                                    $job["job_title"]
                                );
                                ?>

                            </h3>


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
                                        $job[
                                            "employment_type"
                                        ]
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


                            <p>

                                <?php
                                echo nl2br(
                                    htmlspecialchars(
                                        $job["description"]
                                    )
                                );
                                ?>

                            </p>

                        </div>


                        <div class="career-action">

                            <a
                                href="apply.php?job_id=<?php
                                    echo $job["id"];
                                ?>"
                                class="btn btn-main"
                            >

                                Apply Now

                                <i
                                    class="fas fa-arrow-right ms-2"
                                ></i>

                            </a>

                        </div>

                    </div>

                <?php endwhile; ?>

            </div>


        <?php else: ?>


            <div class="text-center py-5">

                <i
                    class="fas fa-briefcase"
                    style="
                        font-size:50px;
                        color:#94a3b8;
                    "
                ></i>

                <h3 class="mt-3">
                    No Open Positions
                </h3>

                <p class="text-muted">
                    There are currently no open positions.
                    Please check again later.
                </p>

            </div>


        <?php endif; ?>

    </div>

</section>


<section class="section bg-light">

    <div class="container text-center">

        <span class="section-subtitle">
            DON'T SEE YOUR ROLE?
        </span>

        <h2 class="mt-2">
            We'd Still Love To Hear From You
        </h2>

        <p>
            Send us your profile and we'll keep you in
            mind for future opportunities.
        </p>

        <a
            href="contact.php"
            class="btn btn-main mt-3"
        >

            Contact Us

            <i
                class="fas fa-arrow-right ms-2"
            ></i>

        </a>

    </div>

</section>


<?php

include "includes/footer.php";

?>