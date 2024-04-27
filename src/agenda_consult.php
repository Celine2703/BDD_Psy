<html lang='en'>
<head>
    <meta charset='utf-8' />
    <link rel="icon" type="image/png" href="images/logo.png">


    <?php
    include './includes.html'
    ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@latest/main.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@latest/main.min.js'></script>

    <link rel="stylesheet" href="css/core_agenda.css">
</head>
<body>
<?php include 'header.php'; ?>


<div id="hearder_agenda">
    <h3>Mes consultations : </h3>
</div>
<div id='calendar'></div>


<?php include 'end.html'; ?>

<script src="js/core_agenda.js"></script>
</body>
</html>
