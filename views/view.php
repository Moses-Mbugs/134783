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
$query = "SELECT users.first_name, users.last_name, projects.image_path, projects.title, projects.category, projects.start_date, projects.end_date, projects.description
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
        <a href="HomePage.html">Home</a>
        <a href="addProject.html"> Add project </a>
        <a href="view.php" class="active">View projects</a>
        <a href="myprojects.php"> My projects </a>
        <a href="chat"> My mentees </a>
        <a href="profile.php" > Profile </a>
        <a href="logout.html">Log out </a>
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
