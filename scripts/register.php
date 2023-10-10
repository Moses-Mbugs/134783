<?php
// registration script
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
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $email = $_POST["email"];
    $experience = $_POST["experience"];
    $profession = $_POST["profession"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Hash the password

    // Insert user details database
    $sql = "INSERT INTO users (first_name, last_name, email, experience, profession, password) 
            VALUES ('$first_name', '$last_name', '$email', '$experience', '$profession', '$password')";

    if ($conn->query($sql) === TRUE) {
        // Registration successful, redirect to main page or login page
        header("Location: main_page.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>
