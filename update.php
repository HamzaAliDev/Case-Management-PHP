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

<body>
    <h3>Welcome, you are logged in! &nbsp; &nbsp; &nbsp; <button><a href="logout.php">Logout</a></button></h3>
    <h1>Update case</h1>
    <?php
    // Include database connection
    require_once 'db_connection.php';

    // Check if taskId is set in the URL (GET request)
    if (isset($_GET['id'])) {
        $caseId = $_GET['id'];

        // Get the database connection
        $conn = getDBConnection();

        // Retrieve the task details using the taskId
        $sql = "SELECT * FROM cases WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $caseId);
        $stmt->execute();
        $result = $stmt->get_result();

        // If the task exists, display the form with current values
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            ?>

            <form action="update.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
                <label for="taskId">TaskId</label>
                <input type="text" name="taskId" value="<?php echo $row['id']; ?>" readonly /><br /><br />
                <label for="user_id">UserId</label>
                <input type="text" name="user_id" value="<?php echo $row['user_id']; ?>" readonly /><br /><br />
                <label for="title">Title:</label>
                <input type="text" name="title" value="<?php echo $row['title']; ?>" required><br /><br />

                <label for="description">Description:</label>
                <input name="description" value="<?php echo $row['detail']; ?>" required><br><br />

                <label for="status">Status:</label>
                <select name="status" id="status">
                    <option value="open" <?php if ($row['status'] == 'open') echo 'selected'; ?>>Open</option>
                    <option value="inprogress" <?php if ($row['status'] == 'inprogress') echo 'selected'; ?>>Inprogress</option>
                    <option value="resolved" <?php if ($row['status'] == 'resolved') echo 'selected'; ?>>Resolved</option>
                </select><br><br />


                
                <button type="submit">Update Case</button>
            </form>

            <?php
        } else {
            echo "case not found.";
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();
    }

    // Check if the form is submitted (POST request)
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = $_POST['id'];
        $userId = $_POST['user_id'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $status = $_POST['status'];

        $updatedAt = date('Y-m-d H:i:s'); // Current timestamp

        // Get the database connection
        $conn = getDBConnection();

        // Update query
        $sql = "UPDATE cases SET user_id = ?, title = ?, detail = ?, status = ?, updated_at = ? WHERE id = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issssi", $userId ,$title, $description, $status, $updatedAt, $id);

        // Execute the query
        if ($stmt->execute()) {
            echo "Case updated successfully!";
        } else {
            echo "Error updating task: " . $conn->error;
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();
    }
    ?>

    <br /><br />
    <button><a href="display.php">Go Back</a></button>
</body>

</html>