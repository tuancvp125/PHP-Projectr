<?php
	session_start();
	if (isset($_SESSION['role']) && isset($_SESSION['id'])) {
        include "app/Model/User.php";
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
?>

<!DOCTYPE html>
<html>
<head>
	<title>Edit User</title>
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
            <h4 class="title">Edit User <a href="user.php"> Users </a></h4>
            <form class="form-1"
                  method="POST"
                  action="app/update-user.php">
                  <?php if (isset($_GET['error'])) { ?>
                    <div class="danger" role="alert">
                        <?php echo stripslashes($_GET['error']); ?>
                    </div>
                    <?php } ?>
                    <?php if (isset($_GET['success'])) { ?>
                        <div class="success" role="alert">
                            <?php echo stripslashes($_GET['success']); ?>
                        </div>
                    <?php } ?>
                <div class="input-holder">
                    <label>Full Name</label>
                    <input type="text" name="full_name" value="<?=$user['full_name']?>" class="input-1" placeholder="Full Name"><br>
                </div>
                <div class="input-holder">
                    <label>UserName</label>
                    <input type="text" name="user_name" value="<?=$user['username']?>" class="input-1" placeholder="UserName"><br>
                </div>
                <div class="input-holder">
                    <label>Password</label>
                    <input type="text" name="password" value="******" class="input-1" placeholder="Password"><br>
                </div>
                <input type="text" name="id" value="<?=$user['id']?>" hidden>
                <button class="edit-btn"> Update </button>
            </form>
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