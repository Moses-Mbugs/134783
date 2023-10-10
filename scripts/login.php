<?php
// login.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection parameters
    $host = "localhost";
    $username = "root";
    $password = "";
    $dbname = "apprentice";

    // Create a database connection
    $conn = new mysqli($host, $username, $password, $dbname);

    // Check for connection errors
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve user input from the form
    $email = $_POST["email"]; // Change this to match your form field name
    $password = $_POST["password"];

    // Query the database for the user's hashed password
    $sql = "SELECT id, password FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashed_password = $row["password"];
        
        // Verify the entered password against the stored hashed password
        if (password_verify($password, $hashed_password)) {
            // Start a session and store user information (e.g., user ID)
            session_start();
            $_SESSION["user_id"] = $row["id"];

            // Redirect to the dashboard or another page
            header("Location: ../views/mentors.html"); // Change this to your dashboard page
            exit();
        } else {
            // Password is incorrect
            $error_message = "Invalid username or password"; 
        }
    } else {
        // User with the provided email does not exist
        $error_message = "User not found"; 
    }

    $conn->close();
}
?>
