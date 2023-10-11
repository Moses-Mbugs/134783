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
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashed_password = $row["password"];
        
        // Verify the entered password against the stored hashed password
        if (password_verify($password, $hashed_password)) {
            // // Start a session and store user information (e.g., user ID)
            // session_start();
            // $_SESSION["user_id"] = $row["id"];

            // // Redirect to the dashboard or another page

            //generate code
            require_once '../scripts/functions.php';
            $code = numberGenerator(5);
            $userId = $row["id"];
            $currentDateTime = date('Y-m-d H:i:s');

            //save the code in the database
            $sq2 = "UPDATE users SET lastlogin='$currentDateTime', code='$code' WHERE id=$userId";
            $conn->query($sq2);

            //send email to the user
            $userEmail = $row['email'];
            $userName = $row['first_name'];

            sendCode($userEmail,$userName,$code);

            //redirect them to the confirmCode page
            header("Location: ../views/confirmCode.php?userId=$userId"); // Change this to your dashboard page
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
