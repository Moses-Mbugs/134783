<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: ../views/login.html");
    exit();
}

// Get mentor ID from the URL
$mentorId = isset($_GET['mentor_id']) ? $_GET['mentor_id'] : null;

// Validate mentor ID
if (empty($mentorId) || !is_numeric($mentorId)) {
    echo "Invalid mentor ID.";
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

// Retrieve mentor's information
$query = "SELECT * FROM users WHERE id = $mentorId";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $mentorInfo = $result->fetch_assoc();
} else {
    echo "Mentor not found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/chat.css">
    <title>Chat with <?php echo $mentorInfo['first_name'] . ' ' . $mentorInfo['last_name']; ?></title>
</head>
<body>
<div class="navbar">
    <a href="home.html">Home</a>
    <a href="mentor.php">Mentors</a>
    <a href="viewProjects.php">View projects</a>
    <a href="accepted_projects.php">Accepted Projects</a>
    <a href="MyMentors.php" >My Mentors</a>
    <a href="chat.php" class="active">Chat</a>
    <a href="profileBeginner.php">Profile</a>
    <a href="../views/logout.html">Log out</a>
</div>

<div class="chat-container">
    <div class="mentors-section">
        <!-- Display previous messaged mentors here -->
        <div id="previousMentors" class="previous-mentors">
            Click on a mentor to chat
        </div>
    </div>
    <div class="chat-section">
        <div class="chat-header">
            <h2>Chat with <?php echo $mentorInfo['first_name'] . ' ' . $mentorInfo['last_name']; ?></h2>
        </div>
        <div class="chat-messages" id="chatMessages">
            <!-- Display chat messages here -->
        </div>
        <div class="chat-input">
            <textarea id="messageInput" placeholder="Type your message..."></textarea>
            <button onclick="sendMessage()">Send</button>
        </div>
    </div>
</div>

<script>
    function sendMessage() {
        // Get the message from the input field
        var message = document.getElementById('messageInput').value;

        // Validate the message
        if (message.trim() === '') {
            alert('Please enter a message.');
            return;
        }

        // Perform AJAX request to send the message to the server
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    // Message sent successfully, clear the input field
                    document.getElementById('messageInput').value = '';

                    // Refresh the chat messages
                    getChatMessages();
                } else {
                    console.error('Error sending message:', xhr.status);
                }
            }
        };

        xhr.open('POST', '../scripts/send_message.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.send('mentor_id=<?php echo $mentorId; ?>&message=' + encodeURIComponent(message));
    }

    function getChatMessages() {
        // Perform AJAX request to get the chat messages from the server
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    // Display the chat messages
                    document.getElementById('chatMessages').innerHTML = xhr.responseText;
                } else {
                    console.error('Error getting chat messages:', xhr.status);
                }
            }
        };

        xhr.open('GET', '../scripts/get_messages.php?mentor_id=<?php echo $mentorId; ?>', true);
        xhr.send();
    }

    // Refresh the chat
