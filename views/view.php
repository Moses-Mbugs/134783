<?php
// Database connection parameters
$host = "localhost";
$username = "root";
$password = "";
$dbname = "apprentice";

// Create a database connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check for database connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to retrieve project data from the database
$query = "SELECT id, image_path, title, category, project_description FROM projects";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="project-card">';
        echo '<img src="' . $row['image_path'] . '" alt="' . $row['title'] . '">';
        echo '<h2>' . $row['title'] . '</h2>';
        echo '<p>Category: ' . $row['category'] . '</p>';
        echo '<p>' . $row['project_description'] . '</p>';
        echo '<button class="read-button">Read Description</button>';
        echo '</div>';
    }
} else {
    echo "No projects found.";
}
// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/view.css">
    <title>View project</title>
</head>
<body>
    
</body>
</html>