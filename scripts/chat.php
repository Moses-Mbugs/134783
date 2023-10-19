<?php
session_start();

// Database connection parameters
$host = "localhost";
$username = "";
$password = "";
$dbname = "apprentice";

// Create a database connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check for database connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to send a chat message
function sendChatMessage($senderId, $receiverId, $message) {
    global $conn;

    // Sanitize user input to prevent SQL injection
    $senderId = mysqli_real_escape_string($conn, $senderId);
    $receiverId = mysqli_real_escape_string($conn, $receiverId);
    $message = mysqli_real_escape_string($conn, $message);

    // Insert the message into the database
    $query = "INSERT INTO chat_messages (sender_id, receiver_id, message_text) 
              VALUES ('$senderId', '$receiverId', '$message')";
    $result = $conn->query($query);

    if ($result) {
        return true; // Message sent successfully
    } else {
        return false; // Error occurred
    }
}

// Function to retrieve chat messages
function getChatMessages($senderId, $receiverId) {
    global $conn;

    // Sanitize user input to prevent SQL injection
    $senderId = mysqli_real_escape_string($conn, $senderId);
    $receiverId = mysqli_real_escape_string($conn, $receiverId);

    // Retrieve chat messages between the sender and receiver
    $query = "SELECT * FROM chat_messages 
              WHERE (sender_id = '$senderId' AND receiver_id = '$receiverId') 
              OR (sender_id = '$receiverId' AND receiver_id = '$senderId') 
              ORDER BY timestamp ASC";
    $result = $conn->query($query);

    $messages = array();
    while ($row = $result->fetch_assoc()) {
        $messages[] = $row;
    }

    return $messages;
}

// Example usage to send a chat message
$senderId = $_SESSION['id']; // Assuming you have a user session
$receiverId = 3; // Replace with the receiver's user ID
$message = "Hello, how can I help you?";
if (sendChatMessage($senderId, $receiverId, $message)) {
    echo "Message sent successfully!";
} else {
    echo "Failed to send the message.";
}

// Example usage to retrieve chat messages
$chatMessages = getChatMessages($senderId, $receiverId);
foreach ($chatMessages as $message) {
    $senderId = $message['sender_id'];
    $messageText = $message['message_text'];
    echo "User $senderId: $messageText<br>";
}
?>
