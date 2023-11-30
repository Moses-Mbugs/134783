<?php
session_start();
if (!isset($_SESSION["user_id"])) {
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

// Get user ID from the session
$user_id = $_SESSION["user_id"];

// Check if project ID is provided in the URL
if (!isset($_GET['id'])) {
    echo "Project ID not provided.";
    exit();
}

$projectID = $_GET['id'];

// Check if the project belongs to the logged-in user
$query = "SELECT id FROM projects WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $projectID, $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if the project exists and belongs to the logged-in user
if ($result->num_rows !== 1) {
    echo "Project not found or does not belong to the user.";
    exit();
}

// Soft delete the project by updating the is_deleted column
$update_sql = "UPDATE projects SET is_deleted = 1 WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($update_sql);
$stmt->bind_param("ii", $projectID, $user_id);

if ($stmt->execute()) {
    // Redirect back to the projects page or display a success message
    header("Location: ../views/myprojects.php");
    exit();
} else {
    echo "Error deleting project: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
