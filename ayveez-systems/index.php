<?php

include 'includes/config.php';
include 'includes/db.php';
include 'includes/header.php';
include 'includes/navbar.php';

?>

<!-- HERO -->

<section class="hero">

<div class="container-fluid px-lg-5">

<div class="row">

<div class="col-lg-9">

<h1>

Building

<span class="text-primary">

Digital Solutions That

</span>

Drive Business Growth

</h1>
<h4 class="text-primary fw-semibold mt-4 mb-4">

Systems That Take Off

</h4>

<p>

Ayveez Systems develops websites, enterprise software,
mobile applications, cloud solutions, and digital products
that help businesses grow.

</p>

<a href="contact.php" class="btn btn-main">

Get Free Consultation

</a>

<a href="services.php" class="btn btn-outline-light">

View Our Services

</a>

</div>

</div>

</div>


</section>
<div class="text-center mt-5">

<a href="#about">

<i class="fas fa-angle-down fa-2x text-white"></i>

</a>
<a class="nav-link active" href="index.php">

</div>


<!-- ABOUT -->

<section id="about" class="section">

<div class="container-fluid px-lg-5">

<div class="row align-items-center">

<div class="col-lg-6">

<div class="about-image">

<img src="assets/images/about.png" alt="About Ayveez Systems">

</div>

</div>

<div class="col-lg-6">

<div class="about-content">

<h2>About <?php echo COMPANY_NAME; ?></h2>

<p>

At <?php echo COMPANY_NAME; ?>, we specialize in delivering innovative software
solutions that help businesses improve productivity, streamline operations,
and embrace digital transformation.

</p>

<p>

From custom web applications and enterprise software to cloud-based
solutions, we are committed to delivering reliable, scalable, and
future-ready technology.

</p>

<a href="about.php" class="btn btn-main mt-3">

Learn More

</a>

</div>

</div>

</div>

</div>

</section>

<section class="pb-5">

<div class="container-fluid px-lg-5">

<div class="row g-4">

<div class="col-md-3">

<div class="feature-box text-center">

<i class="fas fa-lightbulb"></i>

<h4>Innovation</h4>

<p>Creative software solutions for modern businesses.</p>

</div>

</div>

<div class="col-md-3">

<div class="feature-box text-center">

<i class="fas fa-user-shield"></i>

<h4>Quality</h4>

<p>Reliable, secure and scalable applications.</p>

</div>

</div>

<div class="col-md-3">

<div class="feature-box text-center">

<i class="fas fa-headset"></i>

<h4>Support</h4>

<p>Dedicated technical support whenever you need us.</p>

</div>

</div>

<div class="col-md-3">

<div class="feature-box text-center">

<i class="fas fa-rocket"></i>

<h4>Growth</h4>

<p>Technology solutions designed to help your business grow.</p>

</div>

</div>

</div>

</div>

</section>

<section>

<div class="mt-4">

<span class="badge bg-primary me-2">PHP</span>

<span class="badge bg-success me-2">Python</span>

<span class="badge bg-dark me-2">MySQL</span>

<span class="badge bg-warning text-dark me-2">JavaScript</span>

<span class="badge bg-info text-dark me-2">Bootstrap</span>

<span class="badge bg-danger me-2">Angular</span>

</div>
<div class="row mt-5">

<div class="col-4">

<h2>50+</h2>

<p>Projects</p>

</div>

<div class="col-4">

<h2>30+</h2>

<p>Clients</p>

</div>

<div class="col-4">

<h2>15+</h2>

<p>Experts</p>

</div>

</div>

</section>

<!-- SERVICES -->

<section class="section bg-light">

<div class="container">

    <div class="section-title">

        <span class="section-subtitle">
            WHAT WE DO
        </span>

        <h2>Our Services</h2>

        <p>
            Technology solutions designed to help your
            business grow, innovate and succeed.
        </p>

    </div>


    <div class="row g-4">

        <?php

        $sql = "SELECT id, title, icon, description
                FROM services
                WHERE status = 1
                ORDER BY id ASC";

        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0):

            while ($service = $result->fetch_assoc()):

        ?>

            <div class="col-lg-4 col-md-6">

                <div class="service-card">

                    <i class="<?php
                        echo htmlspecialchars($service["icon"]);
                    ?>"></i>

                    <h4>
                        <?php
                        echo htmlspecialchars($service["title"]);
                        ?>
                    </h4>

                    <p>
                        <?php
                        echo htmlspecialchars(
                            $service["description"]
                        );
                        ?>
                    </p>

                    <a
                        href="services.php"
                        class="service-link">

                        Learn More

                        <i class="fas fa-arrow-right"></i>

                    </a>

                </div>

            </div>

        <?php

            endwhile;

        else:

        ?>

            <div class="col-12 text-center">

                <p>
                    Our services will be available soon.
                </p>

            </div>

        <?php endif; ?>

    </div>

</div>

</section>

<div class="col-md-4">

<div class="service-card">

<i class="fas fa-mobile-alt"></i>

<h4>Mobile Apps</h4>

<p>

Android and iOS applications with modern UI.

</p>

</div>

</div>

<div class="col-md-4">

<div class="service-card">

<i class="fas fa-cloud"></i>

<h4>Cloud Solutions</h4>

<p>

Cloud deployment and scalable enterprise applications.

</p>

</div>

</div>

</div>

</div>

</section>
<section class="section" id="portfolio">

    <div class="container">

        <div class="section-title">

            <span class="section-subtitle">
                OUR WORK
            </span>

            <h2>Featured Projects</h2>

            <p>
                Explore some of the digital solutions
                we've built for businesses.
            </p>

        </div>


        <div class="row g-4">

            <?php

            $project_sql = "SELECT *
                            FROM projects
                            WHERE status = 1
                            ORDER BY id DESC
                            LIMIT 6";

            $project_result =
                $conn->query($project_sql);

            ?>


            <?php if (
                $project_result &&
                $project_result->num_rows > 0
            ): ?>


                <?php while (
                    $project =
                    $project_result->fetch_assoc()
                ): ?>


                    <div class="col-lg-4 col-md-6">

                        <div class="project-card">


                            <?php if (
                                !empty($project["image"])
                            ): ?>

                                <div class="project-image">

                                    <img
                                        src="assets/uploads/<?php
                                            echo htmlspecialchars(
                                                $project["image"]
                                            );
                                        ?>"
                                        alt="<?php
                                            echo htmlspecialchars(
                                                $project["project_name"]
                                            );
                                        ?>"
                                    >

                                </div>

                            <?php else: ?>

                                <div class="project-image
                                            project-no-image">

                                    <i
                                        class="fas fa-image"
                                    ></i>

                                </div>

                            <?php endif; ?>


                            <div class="project-content">

                                <span class="project-category">

                                    <?php
                                    echo htmlspecialchars(
                                        $project["category"]
                                    );
                                    ?>

                                </span>


                                <h4>

                                    <?php
                                    echo htmlspecialchars(
                                        $project["project_name"]
                                    );
                                    ?>

                                </h4>


                                <p>

                                    <?php
                                    echo htmlspecialchars(
                                        $project["description"]
                                    );
                                    ?>

                                </p>


                                <div class="project-tech">

                                    <?php
                                    echo htmlspecialchars(
                                        $project["technology"]
                                    );
                                    ?>

                                </div>


                                <?php if (
                                    !empty(
                                        $project["project_url"]
                                    )
                                ): ?>

                                    <a
                                        href="<?php
                                            echo htmlspecialchars(
                                                $project["project_url"]
                                            );
                                        ?>"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="project-link"
                                    >

                                        View Project

                                        <i
                                            class="fas fa-arrow-right"
                                        ></i>

                                    </a>

                                <?php endif; ?>

                            </div>

                        </div>

                    </div>


                <?php endwhile; ?>


            <?php endif; ?>

        </div>


        <div class="text-center mt-5">

            <a
                href="portfolio.php"
                class="btn btn-main"
            >

                View All Projects

                <i
                    class="fas fa-arrow-right ms-2"
                ></i>

            </a>

        </div>

    </div>

</section>
<section class="section bg-light" id="team">

    <div class="container">

        <div class="section-title">

            <span class="section-subtitle">
                OUR TEAM
            </span>

            <h2>
                Meet Our Team
            </h2>

            <p>
                Passionate professionals working together
                to build meaningful technology solutions.
            </p>

        </div>


        <div class="row g-4">

            <?php

            $team_sql = "SELECT *
                         FROM team
                         WHERE status = 1
                         ORDER BY id ASC
                         LIMIT 4";

            $team_result =
                $conn->query($team_sql);

            ?>


            <?php if (
                $team_result &&
                $team_result->num_rows > 0
            ): ?>


                <?php while (
                    $member = $team_result->fetch_assoc()
                ): ?>


                    <div class="col-lg-3 col-md-6">

                        <div class="team-card">


                            <?php if (
                                !empty($member["image"])
                            ): ?>

                                <div class="team-image">

                                    <img
                                        src="assets/uploads/<?php
                                            echo htmlspecialchars(
                                                $member["image"]
                                            );
                                        ?>"
                                        alt="<?php
                                            echo htmlspecialchars(
                                                $member["name"]
                                            );
                                        ?>"
                                    >

                                </div>

                            <?php else: ?>

                                <div class="team-image
                                            team-no-image">

                                    <i
                                        class="fas fa-user"
                                    ></i>

                                </div>

                            <?php endif; ?>


                            <div class="team-content">

                                <h4>

                                    <?php
                                    echo htmlspecialchars(
                                        $member["name"]
                                    );
                                    ?>

                                </h4>


                                <span>

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

                            </div>

                        </div>

                    </div>


                <?php endwhile; ?>


            <?php endif; ?>

        </div>

    </div>

</section>
<!-- COUNTER -->

<section class="counter section">

<div class="container text-center">

<div class="row">

<div class="col-md-3">

<h2>50+</h2>

<p>Projects</p>

</div>

<div class="col-md-3">

<h2>30+</h2>

<p>Clients</p>

</div>

<div class="col-md-3">

<h2>15+</h2>

<p>Experts</p>

</div>

<div class="col-md-3">

<h2>5+</h2>

<p>Years</p>

</div>

</div>

</div>

</section>

<!-- CTA -->

<section class="section">

<div class="container text-center">

<h2>Ready to Build Your Next Project?</h2>

<p>

Let's create innovative software solutions together.

</p>

<a href="contact.php" class="btn btn-primary btn-lg">

Contact Us

</a>

</div>

</section>

<!-- FOOTER -->

<footer class="footer">

<div class="container text-center">

<h4>
    <?php echo COMPANY_NAME; ?>
</h4>

<p>
    <?php echo COMPANY_TAGLINE; ?>
</p>

<p>

© <?php echo date("Y"); ?> Ayveez Systems.
All Rights Reserved.

</p>

</div>

</footer>

<?php

include 'includes/footer.php';

?>