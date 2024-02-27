<?php
require_once "database.php";

$sql = "SELECT * FROM todos ORDER BY id DESC";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['title'] . "</td>";
        echo "<td>";
        echo "<button onclick='updateTask(" . $row['id'] . ")' class='btn btn-primary'>Update</button>";
        echo "<button onclick='deleteTask(" . $row['id'] . ")' class='btn btn-danger'>Delete</button>";
        echo "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='3'>No tasks found</td></tr>";
}
?>
