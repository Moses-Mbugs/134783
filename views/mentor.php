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
$query = "SELECT users.id, users.first_name, users.last_name, users.experience, users.profession, user_details.age, user_details.location, user_details.gender, user_details.bio, user_details.profile_photo
          FROM users
          JOIN user_details ON users.id = user_details.user_id
          WHERE users.experience = 'mentor'";
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
                // buttons
                echo '<button class="request-button" onclick="requestMentorship(' . $row['id'] . ')">Request Mentorship</button>';
                echo '<button class="view-button" onclick="openModal(\'' . $row['first_name'] . ' ' .
                    $row['last_name'] . '\', \'' .
                    $row['profile_photo'] . '\', \'' .
                    $row['age'] . '\', \'' .
                    $row['location'] . '\', \'' .
                    $row['gender'] . '\', \'' .
                    $row['bio'] . '\')">View More</button>';
                echo '</div>';
            }
        } else {
            echo "No mentors found.";
        }
        ?>
    </div>
    <div id="notificationContainer">
        <div class="notification success" id="successNotification">
            Mentorship request sent successfully!
        </div>

        <div class="notification error" id="errorNotification">
            Failed to send mentorship request.
        </div>
    </div>
   

                    
    
   <!-- The Modal -->
   <div id="myModal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <div class="modal-text" id="modalText"></div>
        </div>
    </div>
    <!-- js script for displaying more info -->
    <script>
        function openModal(name, image, age, location , gender, bio) {
            var modalText = '<img src="' + image + '" alt="' + name + '">' +
                            '<p><strong>FUll name :</strong> ' + name + '</p>' +
                            '<p><strong>Age:</strong> ' + age + '</p>' +
                            '<p><strong>Location</strong> ' + location + '</p>' +
                            '<p><strong>Gender:</strong> ' + gender + '</p>' +
                            '<p><strong>About </strong> ' + bio + '</p>' + '</br>' + '</br>'+ '</br>'+ '</br>'+ '</br>';
            document.getElementById("modalText").innerHTML = modalText;
            document.getElementById("myModal").style.display = "block";
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

    //  request 
    
    function requestMentorship(mentorID) {
        // Send an AJAX request to request_mentorship.php
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Check the response from the server
                if (xhr.responseText.trim() === 'success') {
                    console.log('Mentorship request sent successfully');
                    showNotification();
                }
                else {
                    console.error('Failed to send mentorship request');
                    showNotification('errorNotification');
                }
            }
        };

        // Specify the server-side script that handles the mentorship request
        var requestScript = '../scripts/request_mentorship.php';
        xhr.open("POST", requestScript, true);

        // Set the request header
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        // Send the mentorID as POST data
        xhr.send("mentor_id=" + mentorID);
    }

    // the notification
        function showNotification() {
            // Display the success notification
            var notification = document.getElementById('successNotification');
            notification.style.display = 'block';

            // Optionally, you can add a delay and hide the notification after a few seconds
            setTimeout(function () {
                notification.style.display = 'none';
            }, 3000); // 3000 milliseconds (3 seconds) delay
        }

    </script>

</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
