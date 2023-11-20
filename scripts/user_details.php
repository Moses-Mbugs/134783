<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: ../views/login.html");
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve and sanitize user input
    
    $age = filter_var($_POST["age"], FILTER_SANITIZE_NUMBER_INT);
    $bio = filter_var($_POST["bio"], FILTER_SANITIZE_STRING);
    $location = filter_var($_POST["location"], FILTER_SANITIZE_STRING);
    $gender = filter_var($_POST["gender"], FILTER_SANITIZE_STRING);
    $user_id = $_SESSION["user_id"];

    // Handle profile photo upload (if any)
    $profile_photo = null;

    if (isset($_FILES["pic"]) && $_FILES["pic"]["error"] === UPLOAD_ERR_OK) {
        $target_dir = "../images/profile_photos/";
        $target_file = $target_dir . basename($_FILES["pic"]["name"]);

        if (move_uploaded_file($_FILES["pic"]["tmp_name"], $target_file)) {
            $profile_photo = $target_file;
        } else {
            echo "Error uploading profile photo.";
        }
    }

    // Update or insert the user's details in the database
    $host = "localhost";
    $username = "root";
    $password = "";
    $dbname = "apprentice";

    // Create a database connection
    $conn = new mysqli($host, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if user details already exist
    $check_sql = "SELECT * FROM user_details WHERE user_id = ?";
    $stmt_check = $conn->prepare($check_sql);
    $stmt_check->bind_param("i", $user_id);
    $stmt_check->execute();
    $result = $stmt_check->get_result();

    if ($result->num_rows > 0) {
        // User details exist, update them
        $update_sql = "UPDATE user_details SET  age = ?, location = ?, gender = ?, bio = ?, profile_photo = ? WHERE user_id = ?";
        $stmt_update = $conn->prepare($update_sql);
        $stmt_update->bind_param("iisssb",$user_id, $age, $location, $gender, $bio, $profile_photo);

        if ($stmt_update->execute()) {
            // Redirect back to the profile page or display a success message
            header("Location: ../views/profile.php");
            exit();
        } else {
            echo "Error updating user details: " . $conn->error;
        }
    } else {
        // User details do not exist, insert them
        $insert_sql = "INSERT INTO user_details (user_id, age, location, gender, bio) VALUES (?, ?, ?, ?, ?)";
        $stmt_insert = $conn->prepare($insert_sql);
        $stmt_insert->bind_param("iisss", $user_id,  $age, $location, $gender, $bio);


        if ($stmt_insert->execute()) {
            // Redirect back to the profile page or display a success message
            header("Location: ../views/profile.php");
            exit();
        } else {
            echo "Error inserting user details: " . $conn->error;
        }
      

    }
    $stmt_check->close();
    $stmt_update->close();
    $stmt_insert->close();
    $conn->close();
}
?>
