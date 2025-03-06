<?php
	session_start();
	if (isset($_SESSION['role']) && isset($_SESSION['id'])) {
        include "app/Model/Task.php";
        include "app/Model/User.php";
        include "DB_connection.php";

        if (!isset($_GET['id'])) {
            header("Location: tasks.php");
            exit();
        }
        $id = $_GET['id']; //id cua task, not user
        $task = get_task_by_id($conn, $id); 
        $users = get_all_users($conn);
        $edit_user = get_user_by_id($conn, $task['assigned_to']);

        if ($task == 0) {
            header("Location: tasks.php");
            exit();
        }
?>

<!DOCTYPE html>
<html>
<head>
	<title>Edit Task</title>
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
            <h4 class="title">Edit Task <a href="tasks.php"> Tasks </a></h4>
            <form class="form-1"
                  method="POST"
                  action="app/update-task.php">
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
                    <label>Person</label>
                    <input type="text" name="person" class="input-1" value="<?=$edit_user['full_name']?>" placeholder="Title" readonly><br>
                </div>
                <div class="input-holder">
                    <label>Title</label>
                    <input type="text" name="title" class="input-1" value="<?=$task['title']?>" placeholder="Title"><br>
                </div>
                <div class="input-holder">
                    <label>Description</label>
                    <textarea type="text" name="description" class="input-1" placeholder="Description"></textarea><br>
                </div>
                <div class="input-holder">
                    <label>Assigned To</label>
                    <select name="assigned_to" class="input-1">
                        <option value="0">Select Employee</option>
                        <?php if ($users != 0) {
                            foreach ($users as $user) if ($user != $edit_user) {
                        ?>
                        <option value="<?=$user['id']?>"><?=$user['full_name']?></option>
                        <?php
                            } }
                        ?>
                    </select><br>
                </div>
                <input type="text" name="id" value="<?=$task['id']?>" hidden>
                <button class="edit-btn"> Update Task </button>
            </form>
		</section>
	</div>

    <script type="text/javascript">
	var active = document.querySelector("#navList li:nth-child(4)");
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