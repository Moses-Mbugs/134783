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

// Get user ID from the session
$user_id = $_SESSION["user_id"];

// SQL query to retrieve projects for the logged-in user
$query = "SELECT id, title, category, start_date, end_date, description FROM projects WHERE user_id = ? AND is_deleted = 0";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/myprojo.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Mentor Projects</title>
</head>
<body>
    <div class="navbar">
        <a href="HomePage.html">Home</a>
        <a href="addProject.html" ></i></i> Add project </a>
        <a href="view.php"></i> View projects</a>
        <a href="myprojects.php" class="active"></i> My projects </a>
        <a href="requests.php"></i> My requests </a>
        <a href="profile.php"></i> Profile </a>
        <a href="logout.html"></i>Log out </a>
    
    </div>

    <div class="project-cards">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="project-card">';
                echo '<h2>' . $row['title'] . '</h2>';
                echo '<h3>' . $row['category'] . '</h3>';
                echo '<p><strong>Start Date:</strong> ' . $row['start_date'] . '</p>';
                echo '<p><strong>End Date:</strong> ' . $row['end_date'] . '</p>';
                echo '<p><strong>Description:</strong> ' . $row['description'] . '</p>';
                echo '<button class="edit-button" onclick="location.href=\'editProject.php?id=' . $row['id'] . '\'">Edit</button>';
                echo '<button class="delete-button" onclick="confirmDelete(' . $row['id'] . ')">Delete</button>';
                echo '</div>';
            }
        } else {
            echo "No projects found.";
        }
        ?>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteConfirmation" class="confirm-delete">
        <div class="confirm-delete-popup">
            <p>Are you sure you want to delete this project?</p>
            <button onclick="deleteProject()">Yes, Delete</button>
            <button onclick="cancelDelete()">Cancel</button>
        </div>
    </div>

    <script>
        function confirmDelete(projectID) {
            document.getElementById("deleteConfirmation").style.display = "block";
            // Pass the projectID to the delete confirmation modal
            document.getElementById("deleteConfirmation").dataset.projectId = projectID;
        }

        function deleteProject() {
            // Get the projectID from the modal dataset
            var projectID = document.getElementById("deleteConfirmation").dataset.projectId;

            // Log the deleteScript variable
            console.log('Delete Script:', '../scripts/deleteProjectMentor.php?id=' + projectID);

            // Send an AJAX request to delete the project
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Check the response from the server
                    if (xhr.responseText.trim() === 'success') {
                        console.log('Project deleted successfully');
                        document.getElementById('project-' + projectID).remove();
                    } else {
                        console.error('Failed to delete project');
                        setTimeout(function() {
                            location.reload();
                        }, 500);
                    }
                    // Close the delete confirmation modal
                    document.getElementById("deleteConfirmation").style.display = "none";
                }
            };

            // Specify the server-side script that handles the deletion
            var deleteScript = '../scripts/deleteProjectMentor.php?id=' + projectID;
            xhr.open("GET", deleteScript, true);
            xhr.send();
        }


        function cancelDelete() {
            document.getElementById("deleteConfirmation").style.display = "none";
        }
    </script>
</body>
</html>

<?php
// Close the database connection
$stmt->close();
$conn->close();
?>
