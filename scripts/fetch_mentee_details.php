<?php
// get_mentee_details.php

if (isset($_GET['mentee_id'])) {
    $menteeId = $_GET['mentee_id'];

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

    // Query to retrieve mentee details from user_details table
    $query = "SELECT first_name, last_name, age, location, gender, bio FROM user_details WHERE user_id = ?";
    $stmt = $conn->prepare($query);

    // Bind the parameter
    $stmt->bind_param("i", $menteeId);

    // Execute the query
    $stmt->execute();

    // Bind the result variables
    $stmt->bind_result($firstName, $lastName, $age, $location, $gender, $bio);

    // Fetch the result
    $stmt->fetch();

    // Close the statement and connection
    $stmt->close();
    $conn->close();

    // Return mentee details as JSON
    $menteeDetails = array(
        'first_name' => $firstName,
        'last_name' => $lastName,
        'age' => $age,
        'location' => $location,
        'gender' => $gender,
        'bio' => $bio
    );

    header('Content-Type: application/json');
    echo json_encode($menteeDetails);
} else {
    // Invalid request
    echo 'Invalid request';
}
?>
