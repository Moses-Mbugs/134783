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
    $code = $_POST["code"]; // Change this to match your form field name
    $userId = mysqli_real_escape_string($conn,$_POST["userId"]);

    // Query the database for the user's hashed password
    $sql = "SELECT * FROM users WHERE id = '$userId'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $DBCode = $row['code'];        
        // Verify the entered password against the stored hashed password

        //time based
        $loginTime = $row['lastlogin'];
        $currentTime = time();

        //compare these two and decide on a cut off 30mins, 10mins etc..

        //if within cutoff continue,
        //else, show error code expired.

        if ($DBCode == $code) {
            // // Start a session and store user information (e.g., user ID)
             session_start();
             $_SESSION["user_id"] = $row["id"];

             //delete the code from the database

            //redirect them to the confirmCode page
            header("Location: ../views/HomePage.html"); // Change this to your dashboard page
            exit();
        } else {
            // Password is incorrect
            $error_message = "Invalid code entered"; 
        }
    } else {
        // User with the provided userId does not exist
        $error_message = "User not found"; 
    }

    $conn->close();
}
?>
