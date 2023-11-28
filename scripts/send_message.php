<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: ../views/login.html");
    exit();
}

// Get mentor ID and message from the POST request
$mentorId = $_POST['mentor_id'];
$message = $_POST['message'];

// Validate input
if (empty($mentorId) || empty($message)) {
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

// Insert the message into the database
$query = "INSERT INTO chat_messages (mentor_id, mentee_id, message, timestamp)
          VALUES ($mentorId, {$_SESSION['user_id']}, '$message', CURRENT_TIMESTAMP)";

$result = $conn->query($query);

if ($result) {
    echo "Message sent successfully.";
} else {
    echo "Error sending message.";
}

// Close the database connection
$conn->close();
?>
