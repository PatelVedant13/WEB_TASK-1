<?php
require_once "database.php";

// Check if task data is received via POST request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['task'])) {
    // Sanitize the task input
    $task = mysqli_real_escape_string($conn, $_POST['task']);

    // SQL query to insert the task into the database
    $sql = "INSERT INTO todos (title) VALUES ('$task')";

    if (mysqli_query($conn, $sql)) {
        echo "Task added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
} else {
    echo "Task data not received";
}
?>
