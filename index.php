<?php
session_start();

// Dummy credentials for demonstration
$valid_email = "admin";
$valid_password = "admin";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST["username"];
  $password = $_POST["password"];

  if ($email == $valid_email && $password == $valid_password) {
    $_SESSION["loggedin"] = true;
    header("Location: dashboard/index.php");
    exit();
  } else {
    echo "<script>alert('Invalid email or password.');</script>";
  }
}
?>
<?php

// using mysql login
// session_start();

// // Database credentials
// $servername = "localhost";
// $username = "root"; // Change this to your MySQL username
// $password_db = "Nam@2182004"; // Change this to your MySQL password
// $dbname = "middleterm_web";
// $port = 3306; // Change this if your MySQL server uses a different port

// // Function to validate user credentials
// function validate_user($email, $password, $servername, $username, $password_db, $dbname, $port) {
//     try {
//         // Create connection
//         $conn = new mysqli($servername, $username, $password_db, $dbname, $port);

//         // Check connection
//         if ($conn->connect_error) {
//             die("Connection failed: " . $conn->connect_error);
//         }

//         // Prepare and execute the query
//         $stmt = $conn->prepare('SELECT * FROM users WHERE username = ? AND pwd = ?');
//         $stmt->bind_param('ss', $email, $password);
//         $stmt->execute();
//         $result = $stmt->get_result();

//         // Fetch the result
//         $user = $result->fetch_assoc();

//         $stmt->close();
//         $conn->close();

//         return $user !== null;
//     } catch (Exception $e) {
//         echo "Error: " . $e->getMessage();
//         return false;
//     }
// }

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     $email = $_POST["username"];
//     $password = $_POST["password"];

//     if (validate_user($email, $password, $servername, $username, $password_db, $dbname, $port)) {
//         $_SESSION["loggedin"] = true;
//         header("Location: dashboard/index.php");
//         exit();
//     } else {
//         echo "<script>alert('Invalid email or password.');</script>";
//     }
// }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta
    name="viewport"
    content="width=device-width, initial-scale=1.0" />
  <title>Sign in</title>
  <link
    rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700" />
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />
  <link rel="stylesheet" href="styles.css" />
</head>

<body>
  <form class="form" action="index.php" method="POST">
    <p class="form-title">Sign in to Student Manager</p>
    <div class="input-container">
      <input placeholder="Enter username" name="username">
    </div>
    <div class="input-container">
      <input name="password" placeholder="Enter password" type="password">
    </div>
    <button class="submit" type="submit">
      Sign in
    </button>

    <!-- <p class="signup-link">
      No account?
      <a href="">Sign up</a>
    </p> -->
  </form>
</body>

</html>