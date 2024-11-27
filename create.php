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
    <?php
    // Include the database connection file
    require_once 'db_connection.php';

    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Get the title and description from the form
        $title = $_POST['title'];
        $description = $_POST['description'];
        $status = $_POST['status'];

        // Validate the input data
        if (empty($title) || empty($description) || empty($status)) {
            echo "Please fill all the inputs";
            echo " <button><a href='add.php'>Go Back</a></button>";
            exit;
        }

        // Retrieve user_id from session
        $userId = $_SESSION['user_id']; // Make sure 'user_id' is set during login
        $createdAt = date('Y-m-d H:i:s'); // Current timestamp
        $updatedAt = date('Y-m-d H:i:s'); // Current timestamp
    
        // Get the database connection
        $conn = getDBConnection();

        // Prepare the SQL query
        $sql = "INSERT INTO cases (user_id, title, detail, status, created_at, updated_at) VALUES (?, ?, ?, ?, ?,?)";

        // Prepare the statement
        $stmt = $conn->prepare($sql);

        // Bind the parameters
        $stmt->bind_param("isssss", $userId, $title, $description, $status, $createdAt, $updatedAt);

        // Execute the query
        if ($stmt->execute()) {
            echo "case added successfully!";
        } else {
            echo "Error adding case: " . $conn->error;
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();
    } else {
        echo "Invalid request method.";
    }
    echo " <button><a href='display.php'>Go Back</a></button>";

    ?>

</body>

</html>