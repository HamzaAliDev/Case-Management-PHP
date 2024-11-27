<?php
session_start();

if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    table,
    th,
    td {
        border: 1px solid black;
    }
</style>

<body>
    <h3>Welcome, you are logged in! &nbsp; &nbsp; &nbsp; <button><a href="logout.php">Logout</a></button></h3>

    <h1>Case List</h1>
    <br />
    <button><a href="add.php">Add New Case</a></button><br /><br />
    <?php
    // display.php
    require_once 'db_connection.php';

    // Get the database connection
    $conn = getDBConnection();

    $userId = intval($_SESSION['user_id']); // Sanitize user_id

    // SQL query to select username, password, and email
    $sql = "SELECT * FROM cases WHERE user_id = $userId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Start HTML table
    
        echo "<table border='1'>
            <tr>
            <th>Case Id</th>
            <th>User Id</th>
            <th>Title</th>
            <th>Description</th>
            <th>Status</th>
            <th>Created AT</th>
            <th>Updated AT</th>
            <th>Update Case</th>
            <th>Delete Case</th>
        </tr>";

        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>" . $row["id"] . "</td>
                <td>" . $row["user_id"] . "</td>
                <td>" . $row["title"] . "</td>
                <td>" . $row["detail"] . "</td>
                <td>" . $row["status"] . "</td>
                <td>" . $row["created_at"] . "</td>
                <td>" . $row["updated_at"] . "</td>
                <td><a href='update.php?id=" . $row['id'] . "'>Update</a></td>
                <td><a href='delete.php?id=" . $row['id'] . "' onclick='return confirm(\"Are you sure you want to delete this task?\");'>Delete</a></td>
              </tr>";
        }

        echo "</table>";
    } else {
        echo "0 results";
    }

    // Close the connection
    $conn->close();
    ?>
    <br />


</body>

</html>