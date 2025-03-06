<?php
	session_start();
	if (isset($_SESSION['role']) && isset($_SESSION['id']) && $_SESSION['role'] == 'admin') {
        include "app/Model/User.php";
        include "app/Model/Task.php";
        include "DB_connection.php";

        if (!isset($_GET['id'])) {
            header("Location: login.php");
            exit();
        }
        $id = $_GET['id'];
        $user = get_user_by_id($conn, $id); 

        if ($user == 0) {
            header("Location: user.php");
            exit();
        }
        $data = array($id, "employee");
        delete_user($conn, $data);
        $em = "Delete Successfully";
        header("Location: user.php?success=$em");
        exit();

 }else { //else always go with enclose bracket
	$em = "First login";
	header("Location: login.php?error=$em");
	exit();
}
?>