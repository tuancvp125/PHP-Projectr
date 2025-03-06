<?php
	session_start();
	if (isset($_SESSION['role']) && isset($_SESSION['id'])) {
        include "app/Model/Task.php";
        include "DB_connection.php";

        $tasks = get_all_tasks($conn);
?>

<!DOCTYPE html>
<html>
<head>
	<title>All Tasks</title>
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
            <h4 class="title">All Tasks <a href="create_task.php">Create Task </a></h4>
            <?php if (isset($_GET['success'])) { ?>
            <div class="alert alert-success" role="alert">
                <?php echo stripslashes($_GET['success']); ?>
            </div>
            <?php } ?>
            <?php if ($tasks != 0) { ?>
            <table class="main-table">
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
                <?php $i=0; foreach ($tasks as $task) { ?>
                <tr>
                    <td><?=++$i?></td>
                    <td><?=$task['title']?></td>
                    <td><?=$task['description']?></td>
                    <td><?=$task['assigned_to']?></td>
                    <td>
                        <a href="edit-task.php?id=<?=$task['id']?>" class="edit-btn">Edit</a>
                        <a href="delete-task.php?id=<?=$task['id']?>" class="delete-btn">Delete</a>
                    </td>
                </tr>
                <?php } ?>
            </table>
            <?php }else { ?>

            <?php } ?>
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