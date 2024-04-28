<!DOCTYPE html>
<html>

  <head>
    <!-- Basic -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- Site Metas -->
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Mico</title>
    <?php 
      include './includes.html' 
    ?>

  </head>

  <body>
    
    <div class="hero_area">
      <!-- header section strats -->
      <?php
      include 'header.php';

      include 'slider.html';

      include 'connexion.php';
      ?>

    </div>

    <?php
      //about section
      include 'about.html';
      //avis section
      include 'avis.html';
      //contact section
//      include 'contact.html';
      //end section
      include 'end.html';

    ?>

  <?php include './include_js.html'; ?>
  </body>

</html>