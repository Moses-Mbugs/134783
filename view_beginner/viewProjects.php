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

// SQL query to retrieve project data from the database
$query = "SELECT users.first_name, users.last_name, projects.id, projects.image_path, projects.title, projects.category, projects.start_date, projects.end_date, projects.description
          FROM projects
          JOIN users ON projects.user_id = users.id";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/viewprojects.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>View Projects</title>
</head>
<body>
<div class="navbar">
        <a href="home.html">Home</a>
        <a href="mentor.php">Mentors</a>
        <a href="viewProjects.php" class="active">View projects</a>
        <a href="accepted_projects.php"> My Projects</a>
        <a href="MyMentors.php">My Mentors </a>
        <a href="chat.php">Chat</a>
        <a href="profileBeginner.php" >Profile</a>
        <a href="../views/logout.html">Log out</a>
    </div>

    <div class="project-cards">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="project-card">';
                echo '<img src="' . $row['image_path'] . '" alt="' . $row['first_name'] . ' ' . $row['last_name'] . '" style="width: 210px; height: 150px;">';
                echo '<h2>' . $row['title'] . '</h2>';
                echo '<h3>' . $row['category'] . '</h3>';
                echo '<p><strong>Start Date:</strong> ' . $row['start_date'] . '</p>';
                echo '<p><strong>End Date:</strong> ' . $row['end_date'] . '</p>';
                echo '<button class="view-button" onclick="openModal(\'' . $row['first_name'] . ' ' . 
                    $row['last_name'] . '\', \'' .
                    $row['image_path'] . '\', \'' . 
                    $row['title'] . '\', \'' . 
                    $row['category'] . '\', \'' . 
                    $row['start_date'] . '\', \'' . 
                    $row['end_date'] . '\', \'' . 
                    $row['description'] . '\')">View</button>';
                echo '<button class="accept-button" onclick="acceptProject(\'' . $row['id'] . '\')">Accept Project</button>';
                echo '</div>';
            }
        } else {
            echo "No projects found.";
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
    <!-- js script for displaying the description -->
    <script>
        function openModal(name, image, title, category, startDate, endDate, description) {
            var modalText = '<img src="' + image + '" alt="' + name + '">' +
                            '<p><strong>Project by :</strong> ' + name + '</p>' +
                            '<p><strong>Title:</strong> ' + title + '</p>' +
                            '<p><strong>Category:</strong> ' + category + '</p>' +
                            '<p><strong>Start Date:</strong> ' + startDate + '</p>' +
                            '<p><strong>End Date:</strong> ' + endDate + '</p>' +
                            '<p><strong>Description:</strong> ' + description + '</p>' + '</br>' + '</br>'+ '</br>'+ '</br>'+ '</br>';
            document.getElementById("modalText").innerHTML = modalText;
            document.getElementById("myModal").style.display = "block";

            var acceptButton = document.createElement("button");
            acceptButton.className = "accept-button";
            acceptButton.textContent = "Accept Project";
            acceptButton.onclick = function() {
                acceptProject(projectId);
            };

            // Append the accept button to the modal text
            document.getElementById("modalText").appendChild(acceptButton);
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

        function acceptProject(projectId) {
            // Show a confirmation dialog before accepting the project
            var isConfirmed = confirm("Do you want to accept this project?");

            if (isConfirmed) {
                // Use AJAX to send the project_id to accept_project.php
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4) {
                        if (xhr.status == 200) {
                            // Handle the response from the server
                            if (xhr.responseText.trim() === "success") {
                                console.log("Project accepted!");
                            } else {
                                console.error("Error accepting project");
                            }
                        } else {
                            console.error("Error: " + xhr.status);
                        }
                    }
                };

                // Send the request to accept_project.php
                xhr.open("POST", "../scripts/accept_projects.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.send("project_id=" + projectId);
            } else {
                console.log("Project not accepted.");
            }
        }
        
    </script>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
