<?php
session_start();

// If already logged in, redirect to dashboard.
if (isset($_SESSION['role'])) {
  header("Location: dashboard.php");
  exit();
}

// Process login form submission.
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
  $_SESSION['role'] = $_POST['role'];
  header("Location: dashboard.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login - Admin & Student Portal</title>
  <style>
    /* Custom styling without a framework */
    body { background: #eef2f3; font-family: Arial, sans-serif; display: flex; align-items: center; justify-content: center; height: 100vh; }
    .login-container { background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.15); width: 100%; max-width: 400px; }
    h2 { text-align: center; margin-bottom: 20px; color: #333; }
    form { display: flex; flex-direction: column; }
    label { margin-bottom: 5px; color: #555; }
    select, input[type="submit"] { padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 4px; }
    input[type="submit"] { background: #4285f4; color: #fff; border: none; cursor: pointer; font-size: 16px; }
    input[type="submit"]:hover { background: #357ae8; }
  </style>
</head>
<body>
<div class="login-container">
  <h2>Login</h2>
  <form method="POST" action="">
    <label for="role">Select Role:</label>
    <select name="role" id="role">
      <option value="admin">Admin</option>
      <option value="student">Student</option>
    </select>
    <input type="submit" name="login" value="Login">
  </form>
</div>
</body>
</html>
