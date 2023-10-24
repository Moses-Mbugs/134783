<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve and sanitize user input
    $phone_number = filter_var($_POST["phone_number"], FILTER_SANITIZE_STRING);
    $age = filter_var($_POST["age"], FILTER_SANITIZE_NUMBER_INT);
    $bio = filter_var($_POST["bio"], FILTER_SANITIZE_STRING);
    $location = filter_var($_POST["location"], FILTER_SANITIZE_STRING);
    $gender = filter_var($_POST["gender"], FILTER_SANITIZE_STRING);
    $user_id = $_SESSION["user_id"];

    // Handle profile photo upload (if any)
    $profile_photo = null;

    if (isset($_FILES["profile_photo"]) && $_FILES["profile_photo"]["error"] === UPLOAD_ERR_OK) {
        $target_dir = "../images/profile_photos/";
        $target_file = $target_dir . basename($_FILES["profile_photo"]["name"]);

        if (move_uploaded_file($_FILES["profile_photo"]["tmp_name"], $target_file)) {
            $profile_photo = $target_file;
        } else {
            echo "Error uploading profile photo.";
        }
    }

    // Update the user's details in the database
    $host = "localhost";
    $username = "root";
    $password = "";
    $dbname = "apprentice";

    // Create a database connection
    $conn = new mysqli($host, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Update the user's details in the database
    $sql = "INSERT INTO user_details (user_id, phone_number, age, location, gender, bio, profile_photo) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iisssss", $user_id, $phone_number, $age, $location, $gender, $bio, $profile_photo);

    if ($stmt->execute()) {
        // Redirect back to the profile page or display a success message
        header("Location: ../views/profile.php");
        exit();
    } else {
        echo "Error inserting user details: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
