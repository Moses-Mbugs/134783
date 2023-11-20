<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    echo "invalid";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["request_id"]) && isset($_POST["action"])) {
    $host = "localhost";
    $username = "root";
    $password = "";
    $dbname = "apprentice";

    $conn = new mysqli($host, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $mentor_id = $_SESSION["user_id"];
    $request_id = $_POST["request_id"];
    $action = $_POST["action"];

    $updateQuery = "UPDATE mentorship_requests SET status = ? WHERE request_id = ? AND mentor_id = ?";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bind_param("sii", $action, $request_id, $mentor_id);

    if ($updateStmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }

    $updateStmt->close();
    $conn->close();
} else {
    echo "invalid";
}
?>
