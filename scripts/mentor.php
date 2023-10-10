<!-- well in this php file we will be retrieving all the mentors in the database and displaying them in the mentor.html file -->

<?php
// Database connection parameters
$host = "localhost";
$username = "root";
$password = "";
$dbname = "apprentice";

// Create a database connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to select mentors from the "users" table
$sql = "SELECT id, first_name, last_name, email, expertise FROM users WHERE experience = 'mentor'";

// Execute the query
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each mentor
    while ($row = $result->fetch_assoc()) {
        $mentorId = $row["id"];
        $firstName = $row["first_name"];
        $lastName = $row["last_name"];
        $email = $row["email"];
        $expertise = $row["expertise"];

        // Display mentor information (e.g., in HTML format)
        echo "<div class='mentor-card'>";
        echo "<h2>$firstName $lastName</h2>";
        echo "<p>Email: $email</p>";
        echo "<p>Expertise: $expertise</p>";
        // Add a button or link for selecting this mentor
        echo "<form method='post' action='select_mentor.php'>";
        echo "<input type='hidden' name='mentor_id' value='$mentorId'>";
        echo "<input type='submit' value='Select Mentor'>";
        echo "</form>";
        echo "</div>";
    }
} else {
    echo "No mentors available.";
}

// Close the database connection
$conn->close();
?>
