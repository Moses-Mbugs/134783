<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    if (!isset($_SESSION["user_id"])) {
        header("HTTP/1.1 401 Unauthorized");
        exit();
    }

    $mentorId = $_SESSION["user_id"];
    $menteeId = isset($_GET['mentee_id']) ? $_GET['mentee_id'] : null;

    if (empty($menteeId) || !is_numeric($menteeId)) {
        echo "Invalid mentee ID.";
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

    // Perform database query to retrieve messages
    $query = "SELECT * FROM chat_messages WHERE mentor_id = $mentorId AND mentee_id = $menteeId";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        // Return messages as needed (JSON, HTML, etc.)
        while ($row = $result->fetch_assoc()) {
            echo $row['message'] . '<br>';
        }
    } else {
        echo "No messages found.";
    }
} else {
    header("HTTP/1.1 405 Method Not Allowed");
    exit();
}
?>
