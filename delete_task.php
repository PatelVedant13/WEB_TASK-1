<?php
require_once "database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $taskId = mysqli_real_escape_string($conn, $_POST['id']);

    $sql = "DELETE FROM todos WHERE id='$taskId'";
    if (mysqli_query($conn, $sql)) {
        echo "success"; // Send success response if deletion is successful
    } else {
        echo "error"; // Send error response if deletion fails
    }
} else {
    echo "error"; // Send error response if request is invalid
}
?>
