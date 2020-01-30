<?php
  // Starting the session
  session_start();

  // Unset the session variables and redirect back to login
  unset($_SESSION['first-name']);
  unset($_SESSION['username']);
  unset($_SESSION['email']);
  unset($_SESSION['redirect']);
  unset($_SESSION['message']);
  unset($_SESSION['memberID']);
  header("Location: index.php");
?>