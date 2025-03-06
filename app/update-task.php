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
    $id = validate_input($_POST['id']);

    if (empty($title)) {
        $em = "Title is required";
        header("Location: ../edit-task.php?error=$em&id=$id");
        exit();
    } else if (empty($description)) {   
        $em = "Description is required";
        header("Location: ../edit-task.php?error=$em&id=$id");
        exit();
    } else if ($assigned_to == 0) {
        $em = "Select is required";
        header("Location: ../edit-task.php?error=$em&id=$id"); //Phai co cai nay vi neu ko no se check id o dau--> sang tasks.php
        exit();
    } else {
        include "Model/Task.php";  
        $data = array($title, $description, $assigned_to, $id);
        update_task($conn, $data);     

        $em = "Task updated successfully!";
        header("Location: ../edit-task.php?success=$em&id=$assigned_to"); //Co van de?? Update 2 lan
        exit();
    }
} else {
    $em = "Unknown error occured";
    header("Location: ../edit-task.php?error=$em");
    exit(); 
}
?>

<?php }else { //else always go with enclose bracket
	$em = "First login";
	header("Location: ../edit-task.php?error=$em");
	exit();
}
?>