<?php

function isExistingUser($data, $connection, $column) {
    $error = "";
    $stmt = $connection->prepare("SELECT * FROM members WHERE " .$column. " = ?");
    $stmt->bind_param('s', $data);

    $stmt->execute();

    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
      if ($row[$column] == $data) {
        $error = "The " .$column. " you entered already exists.";
        break;
      }
    }

    $stmt->close();

    return $error;
  }

  function registerNewUser($user, $connection) {
    $hashed_password = password_hash($user['password'], PASSWORD_BCRYPT);

    $stmt = $connection->prepare('INSERT INTO members (firstName, lastName, email, country, username, password) VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->bind_param('ssssss', $user['first-name'], $user['last-name'], $user['email'], $user['country'], $user['username'], $hashed_password);

    $stmt->execute();
    $result = $stmt->get_result();

    $stmt->close();

    $_SESSION['first-name'] = $user['first-name'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['memberID'] = getMemberID($user['username'], $connection);
  }


  function getMemberID($username, $connection) {
    $memberID = -1;

    if ($stmt = $connection->prepare('SELECT memberID FROM members WHERE username = ? LIMIT 1')) {
      $stmt->bind_param('s', $username);
      $stmt->execute();
    } else {
      $error = $connection->errno . ' ' . $connection->error;
      echo $error;
    }

    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
      $memberID = $row['memberID'];
    }

    return $memberID;
  }

  ?>