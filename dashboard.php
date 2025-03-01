<?php
session_start();
require_once 'config.php'; // Include the database connection

// Redirect to login page if not logged in.
if (!isset($_SESSION['role'])) {
  header("Location: login.php");
  exit();
}

// Process logout request.
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
  session_destroy();
  header("Location: login.php");
  exit();
}

// Admin: Process adding a student.
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addStudent']) && $_SESSION['role'] === 'admin') {
  $studentName = trim($_POST['studentName']);
  if ($studentName !== "") {
    $stmt = $pdo->prepare("INSERT INTO students (name) VALUES (:name)");
    $stmt->execute(['name' => $studentName]);
  }
  header("Location: dashboard.php");
  exit();
}

// Admin: Process deleting a student.
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteStudent']) && $_SESSION['role'] === 'admin') {
  $studentId = (int) $_POST['deleteId'];
  $stmt = $pdo->prepare("DELETE FROM students WHERE id = :id");
  $stmt->execute(['id' => $studentId]);
  header("Location: dashboard.php");
  exit();
}

// Student: Process saving the student's name.
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['saveStudent']) && $_SESSION['role'] === 'student') {
  $studentName = trim($_POST['studentName']);
  $session_id = session_id();
  // Use REPLACE to either insert a new record or update the existing one.
  $stmt = $pdo->prepare("REPLACE INTO student_profiles (session_id, name) VALUES (:session_id, :name)");
  $stmt->execute(['session_id' => $session_id, 'name' => $studentName]);
  header("Location: dashboard.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dashboard - Admin & Student Portal</title>
  <style>
    /* Custom styling without a framework */
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { background: #eef2f3; font-family: Arial, sans-serif; padding: 20px; }
    .dashboard-container { max-width: 600px; margin: 20px auto; background: #fff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.15); padding: 30px; }
    h2 { margin-bottom: 20px; color: #333; }
    form { margin-bottom: 20px; }
    input[type="text"], select { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; margin-bottom: 15px; }
    input[type="submit"], button { padding: 10px 20px; background: #4285f4; border: none; border-radius: 4px; color: #fff; cursor: pointer; font-size: 16px; }
    input[type="submit"]:hover, button:hover { background: #357ae8; }
    .logout-form { text-align: right; }
    .list-group { list-style: none; padding: 0; }
    .list-group li { padding: 10px; border: 1px solid #ddd; margin-bottom: 8px; display: flex; justify-content: space-between; align-items: center; border-radius: 4px; }
    .list-group li form { margin: 0; }
    .list-group li button { background: #d9534f; }
    .list-group li button:hover { background: #c9302c; }
  </style>
</head>
<body>
<div class="dashboard-container">
  <!-- Logout Button -->
  <div class="logout-form">
    <form method="POST" action="">
      <button type="submit" name="logout">Logout</button>
    </form>
  </div>

  <!-- Admin Panel -->
  <?php if ($_SESSION['role'] === 'admin'): ?>
    <h2>Admin Panel</h2>
    <form method="POST" action="">
      <input type="text" name="studentName" placeholder="Enter student name">
      <input type="submit" name="addStudent" value="Add Student">
    </form>
    <?php
      // Retrieve students from the database.
      $stmt = $pdo->query("SELECT * FROM students");
      $students = $stmt->fetchAll();
    ?>
    <?php if ($students): ?>
      <ul class="list-group">
        <?php foreach ($students as $student): ?>
          <li>
            <?php echo htmlspecialchars($student['name']); ?>
            <form method="POST" action="">
              <input type="hidden" name="deleteId" value="<?php echo $student['id']; ?>">
              <button type="submit" name="deleteStudent">Delete</button>
            </form>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php else: ?>
      <p>No students added yet.</p>
    <?php endif; ?>
  <?php endif; ?>

  <!-- Student Panel -->
  <?php if ($_SESSION['role'] === 'student'): ?>
    <h2>Student Panel</h2>
    <form method="POST" action="">
      <input type="text" name="studentName" placeholder="Enter your name" required>
      <input type="submit" name="saveStudent" value="Save">
    </form>
    <?php
      $session_id = session_id();
      $stmt = $pdo->prepare("SELECT * FROM student_profiles WHERE session_id = :session_id");
      $stmt->execute(['session_id' => $session_id]);
      $profile = $stmt->fetch();
    ?>
    <p>Welcome, <?php echo $profile ? htmlspecialchars($profile['name']) : "Student"; ?>!</p>
  <?php endif; ?>
</div>
</body>
</html>
