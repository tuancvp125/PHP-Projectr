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
	<title>Create Task</title>
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
            <h4 class="title">Create Task </h4>
            <form class="form-1"
                  method="POST"
                  action="app/add-task.php">
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
                    <label>Title</label>
                    <input type="text" name="title" class="input-1" placeholder="Title"><br>
                </div>
                <div class="input-holder">
                    <lable>Description</label>
                    <textarea type="text" name="description" class="input-1" placeholder="Description"></textarea><br>
                </div>
                <div class="input-holder">
                    <label>Assigned To</label>
                    <select name="assigned_to" class="input-1">
                        <option value="0">Select employee</option>
                        <?php if ($users != 0) {
                            foreach ($users as $user) {
                        ?>
                        <option value="<?=$user['id']?>"><?=$user['full_name']?></option> <!--id o dau?? for qua moi user-->
                        <?php
                            } }
                        ?>
                    </select><br>
                </div>
                <button class="edit-btn"> Create Task </button>
            </form>
		</section>
	</div>

    <script type="text/javascript">
	var active = document.querySelector("#navList li:nth-child(3)");
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