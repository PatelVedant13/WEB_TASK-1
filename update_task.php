<?php
require_once "database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id']) && isset($_POST['title'])) {
    $id = $_POST['id'];
    $newTitle = $_POST['title'];

    // Update task in the database
    $sql = "UPDATE todos SET title = '$newTitle' WHERE id = $id";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo "Task updated successfully.";
    } else {
        echo "Error updating task: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request";
}
?>
