<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: ../views/login.html");
    exit();
}

// Get mentor ID from the GET request
$mentorId = $_GET['mentor_id'];

// Validate input
if (empty($mentorId)) {
    echo "Invalid input.";
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

// Retrieve chat messages from the database
$query = "SELECT users.first_name, users.last_name, chat_messages.message, chat_messages.timestamp
          FROM chat_messages
          JOIN users ON chat_messages.mentee_id = users.id
          WHERE chat_messages.mentor_id = $mentorId
          ORDER BY chat_messages.timestamp ASC";

$result = $conn->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Output each chat message
        echo '<p>' . $row['first_name'] . ' ' . $row['last_name'] . ': ' . $row['message'] . '</p>';
    }
} else {
    echo "No chat messages found.";
}

// Close the database connection
$conn->close();
?>
