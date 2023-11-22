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

// SQL query to retrieve accepted projects data from the database
$query = "SELECT users.first_name, users.last_name, projects.id, projects.image_path, projects.title, projects.category, projects.start_date, projects.end_date, projects.description
          FROM projects
          JOIN users ON projects.user_id = users.id
          JOIN accepted_projects ON projects.id = accepted_projects.project_id
          WHERE accepted_projects.mentee_id = {$_SESSION['user_id']} AND accepted_projects.is_deleted = 0";
 // Filter accepted projects
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/viewprojects.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Accepted Projects</title>
</head>
<body>
<div class="navbar">
        <a href="home.html">Home</a>
        <a href="mentor.php">Mentors</a>
        <a href="viewProjects.php">View projects</a>
        <a href="accepted_projects.php" class="active">Accepted Projects</a>
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
                echo '<button class="delete-button" onclick="deleteProject(\'' . $row['id'] . '\')">Delete</button>';
                echo '</div>';
            }
        } else {
            echo "No accepted projects found.";
        }
        ?>
    </div>

    <!-- js script for deleting the project -->
    <script>
        function deleteProject(projectId) {
            // Show a confirmation dialog before deleting the project
            var isConfirmed = confirm("Do you want to delete this project?");

            if (isConfirmed) {
                // Use AJAX to send the project_id to delete_project.php
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4) {
                        if (xhr.status == 200) {
                            // Handle the response from the server
                            if (xhr.responseText.trim() === "success") {
                                console.log("Project deleted!");
                                // Remove the project card from the page
                                var projectCard = document.querySelector("[data-project-id='" + projectId + "']");
                                if (projectCard) {
                                    projectCard.remove();
                                }
                            } else {
                                console.error("Error deleting project");
                            }
                        } else {
                            console.error("Error: " + xhr.status);
                        }
                    }
                };

                // Send the request to delete_project.php
                xhr.open("POST", "../scripts/delete_project.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.send("project_id=" + projectId);
            } else {
                console.log("Project not deleted.");
            }
        }
        // delete
        function deleteProject(projectId) {
        // Show a confirmation dialog before deleting the project
        var isConfirmed = confirm("Do you want to delete this project?");

        if (isConfirmed) {
            // Use AJAX to send the project_id to delete_project.php
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4) {
                    if (xhr.status == 200) {
                        // Handle the response from the server
                        if (xhr.responseText.trim() === "success") {
                            console.log("Project deleted!");
                            // Remove the project card from the page
                            var projectCard = document.querySelector("[data-project-id='" + projectId + "']");
                            if (projectCard) {
                                projectCard.remove();
                            }
                        } else {
                            console.error("Error deleting project");
                        }
                    } else {
                        console.error("Error: " + xhr.status);
                    }
                }
            };

            // Send the request to delete_project.php
            xhr.open("POST", "../scripts/delete_Project_Beginner.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send("project_id=" + projectId);
        } else {
            console.log("Project not deleted.");
        }
    }

    </script>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
