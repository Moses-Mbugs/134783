<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    // Redirect to the login page if the user is not logged in
    header("Location: ../views/login.html");
    exit();
}

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

// Check if the project_id is set in the POST request
if (isset($_POST["project_id"])) {
    $project_id = mysqli_real_escape_string($conn, $_POST["project_id"]);

    // Mark the project as deleted in the accepted_projects table
    $deleteQuery = "UPDATE accepted_projects SET is_deleted = 1 WHERE project_id = $project_id";

    if ($conn->query($deleteQuery)) {
        // Return success message
        echo "success";
    } else {
        // Return error message
        echo "error";
    }
} else {
    // Return error message if project_id is not set
    echo "error";
}

// Close the database connection
$conn->close();
?>
