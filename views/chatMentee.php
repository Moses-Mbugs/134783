<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: ../views/login.html");
    exit();
}

$menteeId = isset($_GET['mentee_id']) ? $_GET['mentee_id'] : null;

if (empty($menteeId) || !is_numeric($menteeId)) {
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
$query = "SELECT * FROM users WHERE id = $menteeId";
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
    <title>Chat </title>
</head>
<body>
    <div class="navbar">
        <a href="HomePage.html">Home</a>
        <a href="addProject.html" ></i></i> Add project </a>
        <a href="view.php"></i> View projects</a>
        <a href="myprojects.php"></i> My projects </a>
        <a href="requests.php"></i> My requests </a>
        <a href="profile.php"></i> Profile </a>
        <a href="chatMentee.php" class="active"> Chat </a>
        <a href="logout.html"></i>Log out </a>
    </div>

        <h2>Chat with <?php echo $mentorInfo['first_name'] . ' ' . $mentorInfo['last_name']; ?></h2>
            <div id="chatMessages"></div>
            <div class="inputContainer">
                <input type="text" id="messageInput" placeholder="Type your message...">
                <button onclick="sendMessages()">Send</button>
            </div>







            
        <script>
            function sendMessages() {
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

                xhr.open('POST', '../scripts/send_message_mentor.php', true);
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhr.send('mentee_id=<?php echo $menteeId; ?>&message=' + encodeURIComponent(message));
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

                xhr.open('GET', '../scripts/get_messages_mentor.php?mentor_id=<?php echo $mentorId; ?>', true);
                xhr.send();
            }

            // Set up an interval to periodically update the chat messages
            setInterval(getChatMessages, 5000); // Update every 5 seconds, adjust as needed
        </script>

            
</body>
</html>
