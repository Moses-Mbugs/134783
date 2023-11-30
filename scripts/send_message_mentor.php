<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_SESSION["user_id"])) {
        header("HTTP/1.1 401 Unauthorized");
        exit();
    }

    $mentorId = $_SESSION["user_id"];
    $menteeId = $_POST["mentee_id"];
    $message = $_POST["message"];

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

    // Perform database query to insert the message
    $query = "INSERT INTO chat_messages (mentor_id, mentee_id, message, timestamp) VALUES ($mentorId, $menteeId, '$message', NOW())";
    $result = $conn->query($query);

    if ($result) {
        echo "Message sent successfully!";
    } else {
        echo "Error sending message.";
    }
} else {
    header("HTTP/1.1 405 Method Not Allowed");
    exit();
}
?>
