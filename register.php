<?php
    session_start();
    require("includes/header.php");
    
    $user = [];
    $user['first-name'] = "";
    $user['last-name'] = "";
    $user['email'] = "";
    $user['username'] = "";
    $errors = [];

    if(isset($_POST['submit'])) {
        $user['first-name'] = !empty($_POST['first-name']) ? $_POST['first-name'] : "";
        $user['last-name'] = !empty($_POST['last-name']) ? $_POST['last-name'] : "";
        $user['email'] = !empty($_POST['email']) ? $_POST['email'] : "";
        $user['username'] = !empty($_POST['username']) ? $_POST['username'] : "";
        $user['password'] = !empty($_POST['password']) ? $_POST['password'] : "";
        $user['confirm-password'] = !empty($_POST['confirm-password']) ? $_POST['confirm-password'] : "";
    
        $incomplete = false;
    
        // Check validation and if form is complete
        $errors = [];
    
        if (empty($user['first-name'])) $errors[] = "First name is required";
        if (empty($user['last-name'])) $errors[] = "Last name is required";
        if (empty($user['email'])) $errors[] = "Email is required";
        if (empty($user['username'])) $errors[] = "Username is required";
    
        // Check if the password and confirm password entry is the same
        if ($user['password'] != $user['confirm-password']) {
          $errors[] = "Passwords must match";
        }
    
        if (!preg_match('/^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=§!\?]{8,50}$/', $user['password'])) {
          $errors[] = 'Password does not meet the requirements!';
        }
    
        if ($errors) {
          $incomplete = true;
        }
    
        if (!$incomplete) {
            require_once("includes/db_connection.php");
            $isRegisteredEmail = "";
            $isRegisteredUsername = "";
            $emailFound = false;
            $sql = "SELECT * FROM members WHERE email = ?";
            if ($stmt = $connection->prepare($sql)) {
              $stmt->bind_param('s', $user['email']);
              $stmt->execute();
              $stmt->store_result();
    
              if ($stmt->num_rows > 0) {
                $isRegisteredEmail = "The email you entered already exists";
              }
            } else {
              $error = $connection->errno . ' ' . $connection->error;
              echo $error;
            }
            $stmt->close();
    
            $usernameFound = false;
            $sql = "SELECT * FROM members WHERE username = ?";
            if ($stmt = $connection->prepare($sql)) {
              $stmt->bind_param('s', $user['username']);
              $stmt->execute();
              $stmt->store_result();
              if ($stmt->num_rows > 0) {
                $isRegisteredUsername = "The username you entered already exists";
              }
            } else {
              $error = $connection->errno . ' ' . $connection->error;
              echo $error;
            }
            $stmt->close();
    
            if (!$isRegisteredEmail && !$isRegisteredUsername) {
    
              require("includes/register_helper.php");
              registerNewUser($user, $connection);
              header("Location: index.php");
            } else {
              if ($isRegisteredEmail != NULL) {
                $errors[] = $isRegisteredEmail;
              }
              if ($isRegisteredUsername != NULL) {
                $errors[] = $isRegisteredUsername;
              }
            }
        }
      }
?>


<div class="login-wrapper">
  <div class="container-login background-image overlay">
			<div class="wrap-login">
		<form class="login-form" action<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?> method="post">
          <h3 class="login-header">Register</h3>

          <?php
            // Show validation errors
            if (!empty($errors)) {
              echo "<div class='validation-msg'>";
              foreach ($errors as $opt) {
                if ($opt) {
                  echo "<li>$opt</li>";
                }
              }
              echo "</div>";
            }
          ?>
		<div class="wrap-input">
          <label class="input-label">First Name</label>
						<input class="form-input" type="text" name="first-name" placeholder="Bob" value="<?php echo $user['first-name'] ?>">
					</div>

					<div class="wrap-input">
            <label class="input-label">Last Name</label>
						<input class="form-input" type="text" name="last-name" placeholder="Smith" value="<?php echo $user['last-name'] ?>">
          </div>
          
          <div class="wrap-input">
            <label class="input-label">Email</label>
						<input class="form-input" type="text" name="email" placeholder="abc@abc.com" value="<?php echo $user['email'] ?>">
          </div>
          
          <div class="wrap-input">
            <label class="input-label">Username</label>
						<input class="form-input" type="text" name="username" placeholder="Bobby007" value="<?php echo $user['username'] ?>">
					</div>
					
          <div class="wrap-input">
            <label class="input-label">Password</label>
            <label class="input-label small">Minimum of 8 characters. At least one captial letter, lowercase letter, special character and number</label>
            <input class="form-input" type="password" name="password" value="" placeholder="">
          </div>

          <div class="wrap-input">
            <label class="input-label">Confirm Password</label>
            <input class="form-input" type="password" name="confirm-password" value="" placeholder="">
          </div>
          
          <div class="login-form-btn">
            <input class="login-button" type="submit" name="submit" value="Submit">
					</div>

					<div class="login-form-link">
            <p>Have an account? <a class="register-link" href="login.php">Sign in here</a></p>
          </div>
				</form>
			</div>
  </div>
</div>