<!DOCTYPE html>
<html lang="en">
  <head>
    <title>MambaAndMe | Kobe Bryant | Inspirational Stories</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/mediaqueries.css">

    <meta property="og:title" content="MambaAndMe - Inspirational Stories" />
    <meta property="og:description" content="How Kobe inspired each of us." />
    <meta property="og:image" content="img/promoteImage.png" />
    <meta name="description" content="How Kobe Bryant inspired each of us. Stories from around the world.">
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-157239014-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-157239014-1');
    </script>
  </head>


  <body>

  <div class="top-banner">
    <div class="site-title">
      <!-- <img class="site-logo" src="img/site-logo.png"> -->
      <!-- Add site logo here  -->
      <h1><a href="index.php">MambaAndMe</a></h1>
    </div>

    <nav class="profile-links">
      <ul class="nav-links">
        <?php
          // Check if user is logged in
          if (empty($_SESSION['first-name'])) {
            echo "<li><a href=\"login.php\">Log In</a></li>";
            echo "<li><a href=\"register.php\">Register</a></li>";
            echo "<li><a href=\"about.php\">How it Works</a></li>";
            echo "<li><a href=\"story.php\">Write a Story</a></li>";
          } else {
            echo "<li><a href=\"profile.php\">Welcome " .$_SESSION['first-name']."</a></li>";
            echo "<li><a href=\"story.php\">Write a Story</a></li>";
            echo "<li><a href=\"about.php\">How it Works</a></li>";
            echo "<li><a href=\"logout.php\">Logout</a></li>";
          }
        ?>
      </ul>
    </nav>
  </div>

  <?php
  // switch to HTTPS
    if(!isset($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] != "on") {
      header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"], true, 301);  
      exit;
    }
  ?>