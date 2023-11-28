<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: ../views/login.html");
    exit();
}

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

// SQL query to retrieve mentorship requests data from the database
$query = "SELECT users.id AS mentee_id, users.first_name AS mentee_first_name, users.last_name AS mentee_last_name, mentors.id AS mentor_id, mentors.first_name AS mentor_first_name, mentors.last_name AS mentor_last_name, mentorship_requests.status
          FROM mentorship_requests
          JOIN users ON mentorship_requests.mentee_id = users.id
          JOIN users AS mentors ON mentorship_requests.mentor_id = mentors.id
          WHERE mentorship_requests.mentee_id = {$_SESSION['user_id']}";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/request.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Sofia">
    <title>My Mentors</title>
</head>
<body>
<div class="navbar">
    <a href="home.html">Home</a>
    <a href="mentor.php">Mentors</a>
    <a href="viewProjects.php">View projects</a>
    <a href="accepted_projects.php">Accepted Projects</a>
    <a href="MyMentors.php" class="active">My Mentors </a>
    <a href="chat.php">Chat</a>
    <a href="profileBeginner.php">Profile</a>
    <a href="../views/logout.html">Log out</a>
</div>

    <div class="mentorship-requests">
        <h2>My Mentorship Requests</h2>
        <table>
            <tr>
                <th>Mentee Name</th>
                <th>Mentor Name</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . $row['mentor_first_name'] . ' ' . $row['mentor_last_name'] . '</td>';
                    echo '<td>' . $row['status'] . '</td>';
                    echo '<td>';
                    if ($row['status'] == 'accepted') {
                        // Pass the mentor ID to the openChat function
                        // Output the button with the onclick event
                        echo '<button class="chat-button" onclick="openChat(' . $row['mentor_id'] . ', 
                        \'' . $row['status'] . '\')">Chat</button>';
                    }
                    echo '</td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="4">No mentorship requests found.</td></tr>';
            }
            ?>
        </table>
    </div>
    <!-- JavaScript function for opening the chat -->
    <script>
    function openChat(mentorId, status) {
        // Check if the mentor has accepted the request
        if (status === 'accepted') {
            // Redirect to chat.php with the valid mentorId
            window.location.href = "../view_beginner/chat.php?mentor_id=" + mentorId;
        } else {
            // Handle the case when the mentor has not accepted the request
            console.log("Mentor has not accepted the request.");
        }
    }
    </script>




    

</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
