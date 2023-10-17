<?php
// Connect to the database
$conn = new mysqli("localhost", "root", "", "apprentice");
// Write a query to select the desired information from the database
$sql = "SELECT first_name, second_name, bio, photo, email, profession FROM users";
// Execute the query and store the results in a variable
$result = $conn->query($sql);
// Use a loop to iterate through the results and display the information on the page
while ($row = $result->fetch_assoc()) {
  echo "First Name: " . $row["first_name"] . "<br>";
  echo "Last Name: " . $row["last_name"] . "<br>";
  echo "Bio: " . $row["bio"] . "<br>";
  echo "Photo: " . $row["photo"] . "<br>";
  echo "Email: " . $row["email"] . "<br>";
  echo "Profession: " . $row["profession"] . "<br>";
}
// Close the connection to the database
$conn->close();
?>
<!-- <!DOCTYPE html> 
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

        
        </div>
    </div>
    
    
</body>
</html> -->