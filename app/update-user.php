<?php
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id']) && $_SESSION['role'] == 'admin') { //Need confirmation from log first
if (isset($_POST["user_name"]) && isset($_POST["password"]) && isset($_POST["full_name"])) {
    include "../DB_connection.php";
    function validate_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $user_name = validate_input($_POST['user_name']);
    $password = validate_input($_POST['password']);
    $full_name = validate_input($_POST['full_name']);
    $id = validate_input($_POST['id']);

    if (empty($user_name)) {
        $em = "User name is required";
        header("Location: ../edit-user.php?error=$em&$id=$id");
        exit();
    } else if (empty($password)) {
        $em = "Password is required";
        header("Location: ../edit-user.php?error=$em&$id=$id");
        exit();
    } else if (empty($full_name)) {
        $em = "Full name is required";
        header("Location: ../edit-user.php?error=$em&$id=$id");
        exit();
    } else {
        include "Model/User.php";  
        $password = password_hash($password, PASSWORD_DEFAULT);
        $data = array($full_name, $user_name, $password, "employee", $id, "employee");
        update_user($conn, $data);     

        $em = "User created successfully!";
        header("Location: ../edit-user.php?success=$em&id=$id"); //dcm??
        exit();
    }
} else {
    $em = "Unknown error occured";
    header("Location: ../edit-user.php?error=$em");
    exit(); 
}
?>

<?php }else { //else always go with enclose bracket
	$em = "First login";
	header("Location: ../edit-user.php?error=$em");
	exit();
}
?>