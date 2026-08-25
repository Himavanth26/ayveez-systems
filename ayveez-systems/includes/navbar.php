<?php

$current_page = basename($_SERVER["PHP_SELF"]);

?>

<nav class="navbar navbar-expand-lg">

    <div class="container">

        <!-- LOGO / BRAND -->

        <a
            class="navbar-brand d-flex align-items-center"
            href="index.php"
        >

           <img
    src="assets/images/logo.png"
    alt="Ayveez Systems"
    class="navbar-logo"
>

            <span>
                Ayveez Systems
            </span>

        </a>


        <!-- MOBILE BUTTON -->

        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#mainNavbar"
            aria-controls="mainNavbar"
            aria-expanded="false"
            aria-label="Toggle navigation"
        >

            <span class="navbar-toggler-icon"></span>

        </button>


        <!-- NAVIGATION -->

        <div
            class="collapse navbar-collapse"
            id="mainNavbar"
        >

            <ul class="navbar-nav ms-auto">


                <!-- HOME -->

                <li class="nav-item">

                    <a
                        class="nav-link <?php
                            echo ($current_page == 'index.php')
                                ? 'active'
                                : '';
                        ?>"
                        href="index.php"
                    >

                        Home

                    </a>

                </li>


                <!-- ABOUT -->

                <li class="nav-item">

                    <a
                        class="nav-link <?php
                            echo ($current_page == 'about.php')
                                ? 'active'
                                : '';
                        ?>"
                        href="about.php"
                    >

                        About

                    </a>

                </li>


                <!-- SERVICES -->

                <li class="nav-item">

                    <a
                        class="nav-link <?php
                            echo ($current_page == 'services.php')
                                ? 'active'
                                : '';
                        ?>"
                        href="services.php"
                    >

                        Services

                    </a>

                </li>


                <!-- PORTFOLIO -->

                <li class="nav-item">

                    <a
                        class="nav-link <?php
                            echo ($current_page == 'portfolio.php')
                                ? 'active'
                                : '';
                        ?>"
                        href="portfolio.php"
                    >

                        Portfolio

                    </a>

                </li>


                <!-- CAREERS -->

                <li class="nav-item">

                    <a
                        class="nav-link <?php
                            echo ($current_page == 'careers.php')
                                ? 'active'
                                : '';
                        ?>"
                        href="careers.php"
                    >

                        Careers

                    </a>

                </li>


                <!-- CONTACT -->

                <li class="nav-item">

                    <a
                        class="nav-link <?php
                            echo ($current_page == 'contact.php')
                                ? 'active'
                                : '';
                        ?>"
                        href="contact.php"
                    >

                        Contact

                    </a>

                </li>


            </ul>

        </div>

    </div>

</nav>