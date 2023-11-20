<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    // Redirect to login page if not logged in
    header("Location: ../views/login.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["mentor_id"])) {
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
    
    // Get mentor ID from the form data
    $mentor_id = $_POST["mentor_id"];

    // Check if the mentorship request already exists
    $checkQuery = "SELECT * FROM mentorship_requests WHERE mentor_id = ? AND mentee_id = ?";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bind_param("ii", $mentor_id, $mentee_id);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        // Request already exists
        echo "exists";
    } else {
        // Insert new mentorship request
        $insertQuery = "INSERT INTO mentorship_requests (mentor_id, mentee_id) VALUES (?, ?)";
        $insertStmt = $conn->prepare($insertQuery);
        $insertStmt->bind_param("ii", $mentor_id, $mentee_id);

        if ($insertStmt->execute()) {
            // Request successful
            echo "success";
        } else {
            // Request failed
            echo "error";
        }
    }

    $checkStmt->close();
    $insertStmt->close();
    $conn->close();
} else {
    // Invalid request
    echo "invalid";
}
?>
