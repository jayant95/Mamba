<?php
  function loginByUsername($user, $connection) {
    $error = "";

    $stmt = $connection->prepare('SELECT * FROM members WHERE username = ? LIMIT 1');
    $stmt->bind_param('s', $user['username']);

    $stmt->execute();

    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
      if ($row['username'] == $user['username']) {
        if (password_verify($user['password'], $row['password'])) {
          session_regenerate_id();

          $_SESSION['memberID'] = $row['memberID'];
          $_SESSION['first-name'] = $row['firstName'];
          $_SESSION['username'] = $row['username'];

          if (isset($_SESSION['redirect'])) {
            header("Location: " . $_SESSION['redirect']);
            unset($_SESSION['redirect']);
          } else {
            header("Location: index.php");
          }
        } else {
          // Don't volunteer what information is incorrect - username or pass
          $error = "This information is incorrect";
        }
      } else {
        $error = "This information is invalid";
      }
    }

    $stmt->close();
    $connection->close();

    return $error;
  }

?>


