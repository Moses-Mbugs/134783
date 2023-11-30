<?php
// Function to fetch mentorship requests from the database
function fetchMentorshipRequests() {
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

    // Query to fetch mentorship requests with mentee names
    $query = "SELECT m.request_id, u1.first_name AS mentor_first_name, m.status, u1.last_name AS mentor_last_name, u2.first_name AS mentee_first_name, u2.last_name AS mentee_last_name, m.mentee_id
              FROM mentorship_requests m
              JOIN users u1 ON m.mentor_id = u1.id
              JOIN users u2 ON m.mentee_id = u2.id";
    $result = $conn->query($query);

    // Check if the query was successful
    if ($result) {
        // Fetch the results as an associative array
        $requests = $result->fetch_all(MYSQLI_ASSOC);

        // Close the database connection
        $conn->close();

        return $requests;
    } else {
        // Handle the case where the query failed
        echo "Error: " . $conn->error;
        $conn->close();
        return [];
    }
}

// Fetch mentorship requests and store them in $requests variable
$requests = fetchMentorshipRequests();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/request.css">

    <title>Requests</title>
</head>
<body>
    <!-- navbar -->
    <div class="navbar">
        <a href="HomePage.html">Home</a>
        <a href="addProject.html" ></i></i> Add project </a>
        <a href="view.php"></i> View projects</a>
        <a href="myprojects.php"></i> My projects </a>
        <a href="requests.php" class="active"> My requests </a>
        <a href="profile.php"></i> Profile </a>
        <a href="logout.html"></i>Log out </a>
    </div>

    <!-- Inside the mentors.php file or any relevant page -->
    <div class="request-entry">
    <h2>My Requests</h2>
        <table>
            <tr>
                <th>Request ID</th>
                <th>Mentee Name</th>
                <th>Status</th>
                <th>Action</th>
                
            </tr>
            <?php
            // Iterate over mentorship requests
            foreach ($requests as $row) {
                echo '<tr>';
                echo '<td>' . $row['request_id'] . '</td>';
                echo '<td>' . $row['mentee_first_name'] . ' ' . $row['mentee_last_name'] . '</td>';
                echo '<td>' . $row['status'] . '</td>';
                echo '<td>';
                echo '<button class="accept-button" onclick="acceptRequest(' . $row['request_id'] . ')">Accept</button>';
                echo '<button class="decline-button" onclick="declineRequest(' . $row['request_id'] . ')">Decline</button>';
                echo '</td>';
                echo '<td>';
                echo '<button class= "info" onclick="viewDetails(' . $row['mentee_id'] . ')">View Details</button>';
                echo '</td>';
                echo '</tr>';
            }
            ?>
        </table>
            <!-- the script -->
        <script>
            function acceptRequest(requestID) {
                // Display pop-up/modal for acceptance
                var isAccepted = confirm("Are you sure you want to accept this mentorship request?");
                if (isAccepted) {
                    // Make an AJAX call to update the status to 'accepted' in the database
                    updateRequestStatus(requestID, 'accepted');
                }
            }

            function declineRequest(requestID) {
                var isDeclined = confirm("Are you sure you want to decline this mentorship request?");
                if (isDeclined) {
                    updateRequestStatus(requestID, 'declined');
                }
            }

            function updateRequestStatus(requestID, action) {
                // Make an AJAX call to update the status in the database
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {

                    if (xhr.readyState == 4 && xhr.status == 200) {
                        var response = xhr.responseText;

                        if (response.trim() === 'success') {
                            alert('Request ' + action + 'ed successfully.');
                            
                        } else {
                            alert('Failed to ' + action + ' request.');
                        }
                    }
                };
                xhr.open("POST", "../scripts/request_mentorship.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.send("request_id=" + requestID + "&action=" + action);
            }

            // a modal to display mentees information
            function viewDetails(menteeId) {
                // Fetch mentee details using AJAX
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function () {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        // Parse the JSON response
                        var menteeDetails = JSON.parse(xhr.responseText);

                        // Display mentee details in the modal
                        document.getElementById("menteeName").innerText = menteeDetails.first_name + " " + menteeDetails.last_name;
                        document.getElementById("menteeAge").innerText = "Age: " + menteeDetails.age;
                        document.getElementById("menteeLocation").innerText = "Location: " + menteeDetails.location;
                        document.getElementById("menteeGender").innerText = "Gender: " + menteeDetails.gender;
                        document.getElementById("menteeBio").innerText = "Bio: " + menteeDetails.bio;

                        // Show the modal
                        document.getElementById("menteeModal").style.display = "block";
                    }
                };

                // Specify the server-side script that handles the mentee details retrieval
                var getMenteeDetailsScript = '../scripts/fetch_mentee_details.php?mentee_id=' + menteeId;
                xhr.open("GET", getMenteeDetailsScript, true);
                xhr.send();
            }

            // Close the modal
            function closeMenteeModal() {
                document.getElementById("menteeModal").style.display = "none";
            }
            


        </script>

            <!-- Mentee Details Modal -->
        <div id="menteeModal" class="modal">
            <div id="menteeModalContent">
                <span id="closeMenteeModal" onclick="closeMenteeModal">&times;</span>
                <h2 id="menteeName"></h2>
                <p id="menteeAge"></p>
                <p id="menteeLocation"></p>
                <p id="menteeGender"></p>
                <p id="menteeBio"></p>
            </div>
        </div>

</body>
</html>