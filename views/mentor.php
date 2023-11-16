<?php
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

// SQL query to retrieve mentor data
$query = "SELECT first_name, last_name, experience, profession
          FROM users
          WHERE experience = 'mentor'";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/mentor.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Mentors</title>
</head>
<body>
    <div class="navbar">
        <a href="mentors.php" class="active">Mentors</a>
        <a href="view.php">View projects</a>
        <a href="myprojects.php">My projects</a>
        <a href="chat.php">Chat</a>
        <a href="profile.php">Profile</a>
        <a href="logout.html">Log out</a>
    </div>

    <div class="project-cards">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="project-card">';
                // might add the image sector
                echo '<h2>' . $row['first_name'] . ' ' . $row['last_name'] . '</h2>';
                echo '<p><strong>Expertise:</strong> ' . $row['profession'] . '</p>';
                echo '</div>';
            }
        } else {
            echo "No mentors found.";
        }
        ?>
    </div>

    <!-- The Modal -->
    <div id="myModal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <div class="modal-text" id="modalText"></div>
        </div>
    </div>

    <script>
        function openModal(mentorId) {
            // AJAX request to fetch mentor details
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById("modalText").innerHTML = xhr.responseText;
                    document.getElementById("myModal").style.display = "block";
                }
            };

            // Specify the server-side script that handles mentor details retrieval
            var fetchDetailsScript = 'fetch_mentor_details.php?id=' + mentorId;
            xhr.open("GET", fetchDetailsScript, true);
            xhr.send();
        }

        function closeModal() {
            document.getElementById("myModal").style.display = "none";
        }

        // Close the modal if the user clicks outside the modal content
        window.onclick = function(event) {
            var modal = document.getElementById("myModal");
            if (event.target == modal) {
                closeModal();
            }
        };
    </script>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
