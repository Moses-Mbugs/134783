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

// Get mentee ID from the session
$mentee_id = $_SESSION["user_id"];

// SQL query to retrieve accepted projects for the mentee
$query = "SELECT projects.image_path, projects.title, projects.category, projects.start_date, projects.end_date
          FROM accepted_projects
          JOIN projects ON accepted_projects.project_id = projects.id
          WHERE accepted_projects.mentee_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $mentee_id);
$stmt->execute();
$result = $stmt->get_result();

// Fetch projects and encode them as JSON
$projects = array();
while ($row = $result->fetch_assoc()) {
    $projects[] = $row;
}

echo json_encode($projects);

$stmt->close();
$conn->close();
?>
