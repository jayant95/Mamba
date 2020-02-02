<!DOCTYPE html>
<html lang="en">
  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title><?php echo $siteTitle ?></title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/mediaqueries.css">
    <link rel='icon' href='img/favicon.ico' type='image/x-icon'>
    <meta property="og:type" content="website" />
    <meta property="og:title" content="MambaAndMe | Kobe Bryant | Inspirational Short Stories" />
    <meta property="og:description" content="MambaAndMe is a collection of short stories inspired by Kobe Bryant. Read and share stories you’re interested in, from around the world!" />
    <meta property="og:url" content="http://mambaandme.com/" />
    <meta property="og:image" content="http://mambaandme.com/img/promoteImage.png" />
    <meta property="og:site_name" content="MambaAndMe" />
    <meta name="description" content="MambaAndMe is a collection of short stories inspired by Kobe Bryant. Read and share stories you’re interested in, from around the world!">
    <meta property="og:image:secure_url" content="http://mambaandme.com/img/promoteImage.png" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="MambaAndMe | Kobe Bryant | Inspirational Short Stories" />
    <meta name="twitter:description" content="MambaAndMe is a collection of short stories inspired by Kobe Bryant. Read and share stories you’re interested in, from around the world!" />
    <meta name="twitter:image" content="http://mambaandme.com/img/promoteImage.png" />
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
      <!-- Add the site logo here  -->
      <h1><a href="index.php">MambaAndMe</a></h1>
    </div>

    <nav class="profile-links">
      <ul class="nav-links">
        <?php
          // Check if user is logged in
          if (empty($_SESSION['first-name'])) {
            echo "<li><a href=\"story.php\">Write a Story</a></li>";
            echo "<li><a href=\"about.php\">How it Works</a></li>";
            echo "<li><a href=\"login.php\">Login</a></li>";
            echo "<li><a href=\"donate.php\">Register</a></li>";
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
    $word = "Foundations";
    if (strpos($siteTitle, $word) === false) {
        ?>
          <div class="donate-area">
              <a href="donate.php">Donate to Kobe's personal and supported foundations here</a>
          </div>
        <?php
    }
?>
