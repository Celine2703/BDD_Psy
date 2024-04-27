<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <title>Mico</title>

</head>


<?php
session_start();
$is_admin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
?>

<body class="sub_page">

<div class="hero_area">
    <!-- header section strats -->
    <header class="header_section">
        <div class="header_bottom">
            <div class="container-fluid">
                <nav class="navbar navbar-expand-lg custom_nav-container ">
                    <a class="navbar-brand" href="accueil">
                        <img src="images/logo.png" alt="">
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                        <span class=""> </span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <div class="d-flex mr-auto flex-column flex-lg-row align-items-center">
                            <ul class="navbar-nav">
                                <?php if ($is_admin): ?>
                                    <li class="nav-item">
                                        <a class="nav-link" href="./patient">Patients</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="./slot">Mes disponibilités</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="./agenda">Agenda - Disponibilités</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="./agenda-consultation">Agenda - Consultation</a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                        <?php if (!$is_admin):?>
                            <div class="quote_btn-container" id="connexion_btn_header">
                                <a href="">
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                        <span> Se connecter </span>
                                </a>
                            </div>
                        <?php else: ?>
                            <div class="quote_btn-container" id="deconnexion_btn_header">
                                <a href="./src/deconnexion.php">
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                    <span> Se deconnecter </span>
                                </a>
                            </div>
                        <?php endif; ?>

                    </div>
                </nav>
            </div>
        </div>
    </header>
    <!-- end header section -->
</div>
</body>

</html>
