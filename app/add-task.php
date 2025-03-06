<?php
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id']) && $_SESSION['role'] == 'admin') { //Need confirmation from log first
if (isset($_POST["title"]) && isset($_POST["description"]) && isset($_POST["assigned_to"])) {    
    include "../DB_connection.php";
    function validate_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $title = validate_input($_POST['title']);
    $description = validate_input($_POST['description']);
    $assigned_to = validate_input($_POST['assigned_to']);

    if (empty($title)) {
        $em = "Title is required";
        header("Location: ../create_task.php?error=$em");
        exit();
    } else if (empty($description)) {
        $em = "Description is required";
        header("Location: ../create_task.php?error=$em");
        exit();
    } else if ($assigned_to == 0) {
        $em = "Select is required";
        header("Location: ../create_task.php?error=$em");
        exit();
    } else {
        include "Model/Task.php";  
        $data = array($title, $description, $assigned_to);
        insert_task($conn, $data);     

        $em = "Task added successfully!";
        header("Location: ../create_task.php?success=$em");
        exit();
    }
} else {
    $em = "Unknown error occured";
    header("Location: ../create_task.php?error=$em");
    exit(); 
}
?>

<?php }else { //else always go with enclose bracket
	$em = "First login";
	header("Location: ../create_task.php?error=$em");
	exit();
}
?>