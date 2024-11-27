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
    <title>Add Task</title>
</head>

<body>
    <h3>Welcome, you are logged in! &nbsp; &nbsp; &nbsp; <button><a href="logout.php">Logout</a></button></h3>
    <h1>Add New Task</h1>
    <form action="create.php" method="POST">
        <label for="title">Title</label>
        <input type="text" name="title" id="title" required /><br /><br />
        <label for="description">Description</label>
        <input type="text" name="description" id="description" required /><br /><br />
        <select name="status" id="status">
            <option value="">Select Status</option>
            <option value="open">Open</option>
            <option value="inprogress">Inprogress</option>
            <option value="resolved">Resolved</option>
        </select>
        <input type="submit" />
        <button><a href="display.php">Go Back</a></button>
    </form>

</body>

</html>