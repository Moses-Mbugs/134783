<?php
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

        // SQL query to retrieve user information
        $query = "SELECT first_name, last_name, profession FROM users";
        $result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Mentors</title>
</head>
<body>
    <!-- Navbar information -->
    <div class="navbar">
        <a href="mentors.php" class="active">Home</a>
        <a href="addProject.html"> Add project </a>
        <a href="view.php">View projects</a>
        <a href="myprojects.php"> My projects </a>
        <a href="chat"> My mentees </a>
        <a href="profile.php" class="active"> Profile </a>
        <a href="logout.html">Log out </a>
    </div>
    <!-- Place where mentor cards will be displayed -->
    <div class="arrangement">
        <?php
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="cards">';
                // echo '<img src="' . $row['profile_photo'] . '" alt="' . $row['first_name'] . ' ' . $row['last_name'] . '">';
                echo '<h2>' . $row['first_name'] . ' ' . $row['last_name'] . '</h2>';
                echo '<p class="title">' . $row['profession'] . '</p>';
                echo '<p><button>Checkout Profile</button></p>';
                echo '<p><button>Request Mentorship</button></p>';
                echo '</div>';
            }
        } else {
            echo "Failed to fetch mentor data: " . $conn->error;
        }
        ?> 

        
    </div>
</body>
</html>
