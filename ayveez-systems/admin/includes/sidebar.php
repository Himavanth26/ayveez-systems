<aside class="sidebar">

    <div class="sidebar-brand">

        <h4>Ayveez Systems</h4>

        <span>Admin Panel</span>

    </div>


    <ul class="sidebar-menu">

        <li>

            <a
                href="dashboard.php"
                class="<?php
                    echo ($current_page == 'dashboard')
                        ? 'active'
                        : '';
                ?>"
            >

                <i class="fas fa-chart-line"></i>

                Dashboard

            </a>

        </li>


        <li>

            <a
                href="services.php"
                class="<?php
                    echo ($current_page == 'services')
                        ? 'active'
                        : '';
                ?>"
            >

                <i class="fas fa-layer-group"></i>

                Services

            </a>

        </li>


        <li>

           <a
    href="projects.php"
    class="<?php
        echo ($current_page == 'projects')
            ? 'active'
            : '';
    ?>"
>

    <i class="fas fa-briefcase"></i>

    Projects

</a>

        </li>


        <li>

            <a
    href="team.php"
    class="<?php
        echo ($current_page == 'team')
            ? 'active'
            : '';
    ?>"
>

    <i class="fas fa-users"></i>

    Team

</a>

        </li>


        <li>

            <a
    href="careers.php"
    class="<?php
        echo ($current_page == 'careers')
            ? 'active'
            : '';
    ?>"
>

    <i class="fas fa-user-tie"></i>

    Careers

</a>

        </li>
<li>

    <a
        href="applications.php"
        class="<?php
            echo ($current_page == 'applications')
                ? 'active'
                : '';
        ?>"
    >

        <i class="fas fa-file-user"></i>

        Applications

    </a>

</li>

        <li>

            <a href="contacts.php">

                <i class="fas fa-envelope"></i>

                Messages

            </a>

        </li>


        <li class="logout-menu">

            <a href="logout.php">

                <i class="fas fa-sign-out-alt"></i>

                Logout

            </a>

        </li>

    </ul>

</aside>