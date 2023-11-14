<?php
// deleteProject.php

if (isset($_GET['id'])) {
    $projectID = $_GET['id'];

    // Database connection parameters
    $host = "localhost";
    $username = "root";
    $password = "";
    $dbname = "apprentice";

    // Create a database connection
    $conn = new mysqli($host, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Perform the update in the database to mark the project as hidden or deleted
    // Replace 'is_deleted' with the actual column name you want to use
    $updateSql = "UPDATE projects SET is_deleted = 1 WHERE id = ?";

    // Update logic
    $stmt = $conn->prepare($updateSql);
    $stmt->bind_param("i", $projectID);

    if ($stmt->execute()) {
        // Assuming the update was successful
        echo 'success';
    } else {
        echo 'error';
    }

    $stmt->close();
    $conn->close();
} else {
    echo 'error';
}
?>
