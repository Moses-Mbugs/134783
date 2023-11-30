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

// SQL query to retrieve accepted mentorship requests data from the database
$query = "SELECT users.id AS mentor_id, users.first_name AS mentor_first_name, users.last_name AS mentor_last_name, mentors.id AS mentee_id, mentors.first_name AS mentee_first_name, mentors.last_name AS mentee_last_name, mentorship_requests.status
          FROM mentorship_requests
          JOIN users ON mentorship_requests.mentor_id = users.id
          JOIN users AS mentors ON mentorship_requests.mentee_id = mentors.id
          WHERE mentorship_requests.mentor_id = {$_SESSION['user_id']} AND mentorship_requests.status = 'accepted'";

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
    <title>My Mentees</title>
</head>
<body>
<div class="navbar">
<a href="HomePage.html">Home</a>
        <a href="addProject.html"></i></i> Add project </a>
        <a href="view.php"></i> View projects</a>
        <a href="myprojects.php"></i> My projects </a>
        <a href="requests.php"></i> My requests </a>
        <a href="MyMentees.php" class="active"></i></i> My Mentees </a>
        <a href="profile.php"></i> Profile </a>
        <a href="logout.html"></i>Log out </a>
</div>

    <div class="mentorship-requests">
        <h2>My Mentees </h2>
        <table>
            <tr>
                <th>Mentor Name</th>
                <th>Mentee Name</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . $row['mentee_first_name'] . ' ' . $row['mentee_last_name'] . '</td>';
                    echo '<td>' . $row['status'] . '</td>';
                    echo '<td>';
                    if ($row['status'] == 'accepted') {
                        // Pass the mentee ID to the openChat function
                        // Output the button with the onclick event
                        echo '<button class="chat-button" onclick="openChat(' . $row['mentee_id'] . ', 
                        \'' . $row['status'] . '\')">Chat</button>';
                    }
                    echo '</td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="4">No accepted mentorship requests found.</td></tr>';
            }
            ?>
        </table>
    </div>
    <!-- JavaScript function for opening the chat -->
    <script>
    function openChat(menteeId, status) {
        // Check if the mentee has accepted the request
        if (status === 'accepted') {
            // Redirect to chat.php with the valid menteeId
            window.location.href = "../view_mentor/chat.php?mentee_id=" + menteeId;
        } else {
            // Handle the case when the mentee has not accepted the request
            console.log("Mentee has not accepted the request.");
        }
    }
    </script>

</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
