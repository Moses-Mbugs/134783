<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: ../views/login.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["project_id"])) {
    $host = "localhost";
    $username = "root";
    $password = "";
    $dbname = "apprentice";

    $conn = new mysqli($host, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $mentee_id = $_SESSION["user_id"];
    $project_id = $_POST["project_id"];
    $timestamp = date("Y-m-d H:i:s");

    $insertQuery = "INSERT INTO accepted_projects (mentee_id, project_id, timestamp) VALUES (?, ?, ?)";
    $insertStmt = $conn->prepare($insertQuery);
    $insertStmt->bind_param("iis", $mentee_id, $project_id, $timestamp);

    if ($insertStmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }

    $insertStmt->close();
    $conn->close();
} else {
    echo "invalid";
}
?>
