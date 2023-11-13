<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
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
$query = "SELECT id, title, category, start_date, end_date, description FROM projects WHERE user_id = ?";
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
        <a href="mentors.php">Home</a>
        <a href="addProject.html"> Add project </a>
        <a href="view.php">View projects</a>
        <a href="myprojects.php" class="active"> My projects </a>
        <a href="chat"> My mentees </a>
        <a href="profile.php"> Profile </a>
        <a href="logout.html">Log out </a>
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

        // Send an AJAX request to delete the project
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Check the response from the server
                if (xhr.responseText.trim() === 'success') {
                    console.log('Project deleted successfully');
                    // Optionally, you can update the UI or perform additional actions here
                } else {
                    console.error('Failed to delete project');
                }
                // Close the delete confirmation modal
                document.getElementById("deleteConfirmation").style.display = "none";
            }
        };

        // Specify the server-side script that handles the deletion
        var deleteScript = 'deleteproject.php?id=' + projectID;
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
