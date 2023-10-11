<?php
// Start the session to access session variables
session_start();

// Database connection parameters
$host = "localhost";
$username = "root";
$password = "";
$dbname = "apprentice";

// Create a database connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check for database connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the user's ID from the session
$user_id = $_SESSION['id'];

$first_name = $last_name = $email = $profile_photo = $bio = '';

// SQL query to retrieve user information
$sql = "SELECT first_name, last_name, email, profession, profile_photo, bio FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if the user was found in the database
if ($result->num_rows > 0) {
    // Fetch user information
    $row = $result->fetch_assoc();

    // Store user information in variables
    $first_name = $row['first_name'];
    $last_name = $row['last_name'];
    $email = $row['email'];
    $profession = $row['profession']; // You can display this if needed
    $profile_photo = $row['profile_photo'];
    $bio = $row['bio'];
} else {
    // Handle the case where the user is not found, you can redirect or display an error message
    // For example, you can use header("Location: error.php") to redirect to an error page.
    echo "User not found";
}
?>
<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Sofia">
    <link rel="stylesheet" href="../css/profileStyle.css">
        <title>Profile</title>
</head>
<body>
    
    <div class="navbar">
        <a href="mentors.php"><i class="fa fa-fw fa-home"></i> Home</a>
        <a href="#"><i class="fa fa-fw fa-search"></i> Search</a>
        <a href="#"><i class="fa fa-fw fa-envelope"></i> Contact</a>
        <a href="profile.php" class="active"><i class="fa fa-fw fa-user"></i> Profile </a>
    </div>
    <div class="profile-info">
        <div class="card">
            <img id="profile-photo" src="<?php echo $profile_photo; ?>" alt="Profile Photo">
            <?php if(isset($first_name) && isset($last_name)): ?>
                <h2 id="name"><?php echo $first_name . ' ' . $last_name; ?></h2>
            <?php endif; ?>
            <?php if(isset($email)): ?>
                <p id="email"><?php echo $email; ?></p>
            <?php endif; ?>
            <?php if(isset($bio)): ?>
                <p id="bio"><?php echo $bio; ?></p>
            <?php endif; ?>

        <!-- xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx -->
            <!-- <img src="../images/profile.jpg" alt="John" style="width:100%"> 
            <img id="profile-photo" src="" alt="Profile Photo"> 
            <h2 id = "name">  </h2>
            <p id="email"></p>
            <p class="title" id="profession" ></p>
            <p id="bio"></p> -->
        </div>
    </div>
    
    
</body>
</html>