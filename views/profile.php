
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

// SQL query to select data from both tables
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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Sofia">
    <!-- <link rel="stylesheet" type="text/css" href="../css/profileStyle.css"> -->
    <title>Profile</title>
    <style>
        /* background color */

        /* Navbar */
        body{
            z-index: 1;
            background: linear-gradient(-45deg, red, black, orange, black, green );
            background-size: 400% 400%;
            width: 100%;
            height: 100vh;
            animation: animate 15s ease infinite;    
         }
         @keyframes animate {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }

        .navbar {
            width: 100%;
            background-color: #555;
            overflow: auto;
        }
        .navbar a {
            float: left;
            padding: 12px;
            color: white;
            text-decoration: none;
            font-size: 17px;
        }

        .navbar a:hover {
            background-color: #000;
        }

        .active {
            background-color: orange;
            font-family: "Sofia";
        }

        @media screen and (max-width: 500px) {
        .navbar a {
            float: none;
            display: block;
        }
        }
        /* centered content */
        .centered-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(255, 255, 255, 0.3); 
            padding: 20px; 
            border-radius: 10px; 
            backdrop-filter: blur(10px);
            width: 800px;
            height: 480px;
            }
        .view-button {
            background-color: #373535;
            color: #fff; 
            border: none;
            padding: 10px 20px;
            margin-left: 220px;
            cursor: pointer; 
            font-family: ubuntu;
            border-radius: 40px;
            top: 75%;
        }
        .image{
            border-radius: 15%;
        }
        .text {
            width:300px;
            padding:10px;
            height:150px;
            float:left;
            margin:10px;
            font-size: 17px;
            color: #fff;
        }
        .image {
            width:325px;
            padding:10px;
            height:340px;
            float:right;
            margin:10px;
        }
    </style>
</head>


<body>
    <div class="navbar">
        <a href="mentors.php"><i class="fa fa-fw fa-home"></i> Home</a>
        <a href="#"><i class="fa fa-fw fa-search"></i> Search</a>
        <a href="#"><i class="fa fa-fw fa-envelope"></i> Contact</a>
        <a href="profile.php" class="active"><i class="fa fa-fw fa-user"></i> Profile </a>
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