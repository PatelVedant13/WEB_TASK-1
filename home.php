<?php
require_once "controllerUserData.php";

$email = $_SESSION['email'] ?? false;
$password = $_SESSION['password'] ?? false;

if (!$email || !$password) {
    header('Location: login-user.php');
    exit();
}

$sql = "SELECT * FROM usertable WHERE email = '$email'";
$run_Sql = mysqli_query($con, $sql);

if (!$run_Sql) {
    echo "Error: " . mysqli_error($con);
    exit();
}

$fetch_info = mysqli_fetch_assoc($run_Sql);
$status = $fetch_info['status'];
$code = $fetch_info['code'];

if ($status != "verified" || $code != 0) {
    header('Location: ' . ($status == "verified" ? 'reset-code.php' : 'user-otp.php'));
    exit();
}

$sql = "SELECT * FROM todos ORDER BY id DESC";
$result = mysqli_query($con, $sql);

if (!$result) {
    echo "Error: " . mysqli_error($con);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $fetch_info['name'] ?? 'User'; ?> | Home</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <nav class="navbar">
        <a class="navbar-brand" href="#">TO DO APPLICATION</a>
        <button type="button" class="btn btn-light"><a href="logout-user.php">Logout</a></button>
    </nav>
    <h1>Welcome <?php echo $fetch_info['name'] ?? 'User'; ?></h1>

    <div class="container">
        <h2>My To-Do List</h2>
        <div class="input-group">
            <input type="text" id="taskInput" class="task-input" placeholder="Add new task">
            <button onclick="addTask()" class="add-btn">Add Task</button>
        </div>
        <table id="taskList" class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Task</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php if ($result && mysqli_num_rows($result) > 0) : ?>
                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td id="taskText_<?php echo $row['id']; ?>"><?php echo $row['title']; ?></td>
                        <td>
                            <button onclick="updateTask(<?php echo $row['id']; ?>)" class="btn btn-primary mr-2">Update</button>
                            <button onclick="deleteTask(<?php echo $row['id']; ?>)" class="btn btn-danger">Delete</button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else : ?>
                <tr><td colspan="3">No tasks found</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        function addTask() {
            var taskInput = $('#taskInput').val().trim();
            if (taskInput === "") {
                alert("Please enter a task!");
                return;
            }

            $.ajax({
                url: "add_task.php",
                method: "POST",
                data: { task: taskInput },
                success: function(response) {
                    fetchTasks();
                    $('#taskInput').val('');
                },
                error: function(xhr, status, error) {
                    alert("Failed to add task: " + error);
                }
            });
        }

               function deleteTask(taskId) {
            if (confirm("Are you sure you want to delete this task?")) {
                $.ajax({
                    url: "delete_task.php",
                    method: "POST",
                    data: { id: taskId },
                    success: function(response) {
                        fetchTasks();
                    },
                    error: function(xhr, status, error) {
                        alert("Failed to delete task: " + error);
                    }
                });
            }
        }
 function updateTask(id) {
    var newTitle = prompt("Enter new task title:");
    if (newTitle !== null && newTitle !== "") {
        $.ajax({
            url: "update_task.php",
            type: "POST",
            data: { id: id, title: newTitle },
            success: function(response) {
                alert(response);
                location.reload(); // Reload the page after successful update
            }
        });
    }
}

     function fetchTasks() {
            $.ajax({
                url: "fetch_tasks.php",
                method: "GET",
                success: function(data) {
                    $("#taskList tbody").html(data);
                },
                error: function(xhr, status, error) {
                    alert("Failed to fetch tasks: " + error);
                }
            });
        }

        $(document).ready(function() {
            fetchTasks();
        });
    </script>
</body>
</html>
