<?php
session_start();

// Check if the user is logged in (you should have authentication in place)
if (!isset($_SESSION["user_id"])) {
    // Redirect to the login page if the user is not logged in
    header("Location: login.php");
    exit();
}

// Assuming you have the user's ID, retrieve information from both tables
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

$sql = "SELECT u.first_name, u.last_name, u.email, u.profession, ud.phone_number, ud.age, ud.location, ud.gender, ud.bio, ud.profile_photo
        FROM users u
        LEFT JOIN user_details ud ON u.id = ud.user_id
        WHERE u.id = $user_id";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Retrieve and store data in variables
    $first_name = $row["first_name"];
    $last_name = $row["last_name"];
    $email = $row["email"];
    $profession = $row["profession"];
    $phone_number = $row["phone_number"];
    $age = $row["age"];
    $location = $row["location"];
    $gender = $row["gender"];
    $bio = $row["bio"];
    $profile_photo = $row["profile_photo"];
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../css/profileStyle.css"> 
    <title>Profile</title>
</head>


<body>
    <div class="navbar">
        <a href="mentors.php">Home</a>
        <a href="addProject.html"> Add project </a>
        <a href="view.php">View projects</a>
        <a href="myprojects.php"> My projects </a>
        <a href="chat"> My mentees </a>
        <a href="profile.php" class="active"> Profile </a>
        <a href="logout.html">Log out </a>
    </div>
    
    <div class="centered-content">
        <div class="image">
            <img src="<?php echo $profile_photo ?>" alt=""  class="image"/>
        </div>
        <div class="text">
            <?php echo $first_name . ' ' . $age; ?></p>
            <p>Email: <?php echo $email; ?></p>
            <p>Profession: <?php echo $profession; ?></p>
            <p>Phone Number: <?php echo $phone_number; ?></p>
            <p>Location: <?php echo $location; ?></p>
            <p>Gender: <?php echo $gender; ?></p>
            <p>About me: </br><?php echo $bio; ?></p>
        </div>
    </div>
        <a href="edit.html">
            <button class="view-button"> Edit your Info </button>
        </a>
    

    
</body>