
document.addEventListener("DOMContentLoaded", function() {
    const chatMessages = document.getElementById("chat-messages");
    const messageInput = document.getElementById("message-input");
    const sendButton = document.getElementById("send-button");

    // Function to add a message to the chat container
    function addMessage(message, sender) {
        const messageElement = document.createElement("div");
        messageElement.className = sender === "user" ? "user-message" : "mentor-message";
        messageElement.textContent = message;
        chatMessages.appendChild(messageElement);
    }

    // Example usage to receive messages (you can replace this with your actual chat logic)
    addMessage("Hello! How can I help you?", "mentor");
    addMessage("Hi, I have a question about AI.", "user");

    // Function to send a message (you can replace this with your actual chat logic)
    sendButton.addEventListener("click", function() {
        const userMessage = messageInput.value;
        if (userMessage) {
            addMessage(userMessage, "user");
            messageInput.value = "";
            // Send the message to the server using AJAX or WebSocket
            // Handle the server's response, e.g., receiving a message from the mentor
            // Add the mentor's message to the chat
        }
    });
});
