<?php
// connection
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection parameters
    $host = "localhost";
    $username = "root";
    $password = "";
    $dbname = "apprentice";

    // Create a database connection
    $conn = new mysqli($host, $username, $password, $dbname);

    $user_id = $_SESSION['id']; 

    // SQL query to retrieve user information
    $sql = "SELECT first_name, last_name, email, experience, profession, profile_photo, bio FROM users WHERE id = $user_id";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch user information
        $row = $result->fetch_assoc();

        // Return user information as JSON
        header('Content-Type: application/json');
        echo json_encode($row);
    } else {
        echo "User not found";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Sofia">
    <title>Mentors</title>
    
</head>
<body>
    <!-- Navabar information -->
    <div class="navbar">
        <a  href="mentors.php" class="active"><i class="fa fa-fw fa-home"></i> Home</a>
        <a href="#"><i class="fa fa-fw fa-search"></i> Search</a>
        <a href="#"><i class="fa fa-fw fa-envelope"></i> Contact</a>
        <a href="profile.php" ><i class="fa fa-fw fa-user"></i> Profile </a>
    </div>
    <!-- we link the mentor.php in this line below -->

    <div class="card">
        <img src="../images/profile.jpg" alt="John" style="width:100%">
        <h2 id = "name">  </h2>
        <p class="title" ></p>
        <p>Harvard University</p>
        <p><button> Request mentorship </button></p>
    </div>
   
      
    
</body>
</html>