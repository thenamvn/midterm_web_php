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