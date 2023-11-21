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
    $code = $_POST["code"];
    $userId = mysqli_real_escape_string($conn,$_POST["userId"]);

    // Query the database for the user's hashed password, experience, and lastlogin as timestamp
    $sql = "SELECT *, UNIX_TIMESTAMP(lastlogin) AS lastlogin_timestamp FROM users WHERE id = '$userId'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $DBCode = $row['code'];
        $userExperience = $row['experience'];

        //time based
        $loginTime = $row['lastlogin_timestamp'];

        if ($DBCode == $code) {
            // Start a session and store user information (e.g., user ID)
            session_start();
            $_SESSION["user_id"] = $row["id"];

            // Redirect based on user experience
            if ($userExperience == 'mentor') {
                header("Location: ../views/HomePage.html");
            } else {
                header("Location: ../views/dash.html");
            }

            // Delete the code from the database

            exit();
        } else {
            // Code is incorrect
            $error_message = "Invalid code entered";
        }
    } else {
        // User with the provided userId does not exist
        $error_message = "User not found";
    }

    $conn->close();
}
?>
