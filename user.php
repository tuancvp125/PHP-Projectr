<?php
	session_start();
	if (isset($_SESSION['role']) && isset($_SESSION['id'])) {
        include "app/Model/User.php";
        include "DB_connection.php";

        $users = get_all_users($conn);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Manage Users</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
	<input type="checkbox" id="checkbox">
	<?php include "inc/header.php" ?>
	<div class="body">
		<?php include "inc/nav.php" ?>
		<section class="section-1">		
            <h4 class="title">Manage Users <a href="add-user.php"> Add User </a></h4>
            <table class="main-table">
                <tr>
                    <th>#</th>
                    <th>Full Name</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
                <tr>
                    <td>1</td>
                    <td>Elias A</td>
                    <td>elias</td>
                    <td>Employee</td>
                    <td>
                        <a href="" class="edit-btn">Edit</a>
                        <a href="" class="edit-btn">Delete</a>
                    </td>
                </tr>
            </table>
		</section>
	</div>

    <script type="text/javascript">
	var active = document.querySelector("#navList li:nth-child(2)");
	active.classList.add("active");
</script>
</body>
</html>

<?php }else { //else always go with enclose bracket
	$em = "First login";
	header("Location: login.php?error=$em");
	exit();
}
?>