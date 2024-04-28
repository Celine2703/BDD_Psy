<html lang='en'>
<head>
    <meta charset='utf-8' />
    <link rel="icon" type="image/png" href="images/logo.png">


    <?php
    include './includes.html';
//    include './check_admin.php';
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@latest/main.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@latest/main.min.js'></script>

    <link rel="stylesheet" href="css/core_agenda.css">
</head>
<body>
<?php include 'header.php'; ?>


<div id="hearder_agenda">
    <h3>Choisir une date : </h3>
</div>
<div id='calendar'></div>


<?php include 'end.html'; ?>

<script src="js/core_agenda_user.js"></script>
<style>
    .fc-event-main-frame:hover {
        background-color: #1e7e34;
        cursor: pointer;
    }
</style>
</body>
</html>
