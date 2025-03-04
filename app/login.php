<?php
if (isset($_POST["user_name"]) && isset($_POST["password"])) {
    include "../DB_connection.php";
    function validate_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $user_name = validate_input($_POST['user_name']);
    $password = validate_input($_POST['password']);

    if (empty($user_name)) {
        $em = "User name is required";
        header("Location: ../login.php?error=$em");
        exit();
    } else if (empty($password)) {
        $em = "password name is required";
        header("Location: ../login.php?error=$em");
        exit();
    } else {
        $sql = "SELECT * FROM user WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute($user_name);
    }
} else {
    $em = "Unknown error occured";
    header("Location: ../login.php?error=$em");
    exit(); 
}
?>