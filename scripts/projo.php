<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = $_SESSION["user_id"];

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

    // Handle image upload
    $image_path = null; 

    if (isset($_FILES["chat-image"]) && $_FILES["chat-image"]["error"] === UPLOAD_ERR_OK) {
        $target_dir = "../images/project_images/"; // Specify the directory for project images
        $target_file = $target_dir . basename($_FILES["chat-image"]["name"]);

        if (move_uploaded_file($_FILES["chat-image"]["tmp_name"], $target_file)) {
            $image_path = $target_file;
        } else {
            echo "Error uploading project image.";
            exit(); // Terminate the script
        }
    } else {
        echo "No image uploaded.";
        exit(); // Terminate the script
    }

    // Check if the description field exists in the POST request
    if (!isset($_POST["chat-description"])) {
        echo "Description is required.";
        exit(); // Terminate the script
    }

    // Retrieve and sanitize user input for description
    $description = filter_var($_POST["chat-description"], FILTER_SANITIZE_STRING);

    // Insert the project into the database
    $insert_sql = "INSERT INTO projects (user_id, image_path, description) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($insert_sql);
    $stmt->bind_param("iss", $user_id, $image_path, $description);

    if ($stmt->execute()) {
        // Redirect back to the projects page or display a success message
        header("Location: view.php");
        exit();
    } else {
        echo "Error inserting project: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
