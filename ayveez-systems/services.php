<?php

include "includes/config.php";

include "includes/db.php";

include "includes/header.php";

include "includes/navbar.php";

?>

<section class="services-hero">

    <div class="container text-center">

        <span class="section-subtitle">

            WHAT WE DO

        </span>

        <h1>

            Our Services

        </h1>

        <p>

            Innovative technology solutions designed
            to help your business grow.

        </p>

    </div>

</section>


<section class="section">

    <div class="container">

        <div class="row g-4">

            <?php

            $sql = "SELECT *
                    FROM services
                    WHERE status = 1
                    ORDER BY id ASC";

            $result = $conn->query($sql);

            ?>


            <?php if (
                $result &&
                $result->num_rows > 0
            ): ?>


                <?php while (
                    $service = $result->fetch_assoc()
                ): ?>


                    <div class="col-lg-4 col-md-6">

                        <div class="service-card">


                            <div class="service-icon-large">

                                <i class="<?php

                                    echo htmlspecialchars(
                                        $service["icon"]
                                    );

                                ?>"></i>

                            </div>


                            <h3>

                                <?php

                                echo htmlspecialchars(
                                    $service["title"]
                                );

                                ?>

                            </h3>


                            <p>

                                <?php

                                echo htmlspecialchars(
                                    $service["description"]
                                );

                                ?>

                            </p>


                            <a
                                href="contact.php"
                                class="service-link"
                            >

                                Discuss Your Project

                                <i
                                    class="fas fa-arrow-right"
                                ></i>

                            </a>

                        </div>

                    </div>


                <?php endwhile; ?>


            <?php else: ?>


                <div class="col-12 text-center">

                    <h4>
                        Services coming soon.
                    </h4>

                </div>


            <?php endif; ?>

        </div>

    </div>

</section>


<section class="section bg-light">

    <div class="container text-center">

        <span class="section-subtitle">

            LET'S WORK TOGETHER

        </span>

        <h2 class="mt-2">

            Have a project in mind?

        </h2>

        <p>

            Let's discuss how Ayveez Systems can
            help turn your idea into a digital solution.

        </p>


        <a
            href="contact.php"
            class="btn btn-main mt-3"
        >

            Start a Conversation

            <i
                class="fas fa-arrow-right ms-2"
            ></i>

        </a>

    </div>

</section>


<?php

include "includes/footer.php";

?>