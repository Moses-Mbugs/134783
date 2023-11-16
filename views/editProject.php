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

// Check if project ID is provided in the URL
if (!isset($_GET['id'])) {
    echo "Project ID not provided.";
    exit();
}

$projectID = $_GET['id'];

// SQL query to retrieve project data
$query = "SELECT id, title, category, start_date, end_date, description FROM projects WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $projectID, $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if the project exists and belongs to the logged-in user
if ($result->num_rows !== 1) {
    echo "Project not found or does not belong to the user.";
    exit();
}

// Fetch project details
$project = $result->fetch_assoc();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve and sanitize user input
    $title = filter_var($_POST["title"], FILTER_SANITIZE_STRING);
    $category = filter_var($_POST["category"], FILTER_SANITIZE_STRING);
    $start_date = $_POST["start_date"];
    $end_date = $_POST["end_date"];
    $description = filter_var($_POST["description"], FILTER_SANITIZE_STRING);

    // Update the project in the database
    $update_sql = "UPDATE projects SET title = ?, category = ?, start_date = ?, end_date = ?, description = ? WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("sssssi", $title, $category, $start_date, $end_date, $description, $projectID, $user_id);

    if ($stmt->execute()) {
        // Redirect back to the projects page or display a success message
        header("Location: myprojects.php");
        exit();
    } else {
        echo "Error updating project: " . $conn->error;
    }

    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/editproject.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Edit Project</title>
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

    <div class="container">
        <form action="editProject.php?id=<?php echo $projectID; ?>" method="post">

            <!-- title -->
            <label for="title">Project Title</label>
            <input type="text" id="title" name="title" value="<?php echo $project['title']; ?>" required>

            <!-- categories -->
            <label for="category">Project Category</label>
            <select id="category" name="category" required>
                <option value="ArtificialIntelligence" <?php if ($project['category'] === 'ArtificialIntelligence') echo 'selected'; ?>>Artificial Intelligence</option>
                <option value="FrontEnd" <?php if ($project['category'] === 'FrontEnd') echo 'selected'; ?>>FrontEnd</option>
                <option value="BackEnd" <?php if ($project['category'] === 'BackEnd') echo 'selected'; ?>>BackEnd</option>
                <option value="IOT" <?php if ($project['category'] === 'IOT') echo 'selected'; ?>>IOT</option>
                <option value="Database" <?php if ($project['category'] === 'Database') echo 'selected'; ?>>Database</option>
                <option value="Full stack" <?php if ($project['category'] === 'Full stack') echo 'selected'; ?>>Full stack</option>
                <option value="Cyber Security" <?php if ($project['category'] === 'Cyber Security') echo 'selected'; ?>>Cyber Security</option>
            </select><br/> 

            <!-- start and end dates -->
            <label for="start_date">Start Date</label>
            <input type="date" id="start_date" name="start_date" value="<?php echo $project['start_date']; ?>" required>
            <label for="end_date">End Date</label>
            <input type="date" id="end_date" name="end_date" value="<?php echo $project['end_date']; ?>" required>

            <!-- description -->
            <label for="description">Project Description</label>
            <textarea name="description" rows="5" required><?php echo $project['description']; ?></textarea>
            <button type="submit">Update Project</button>
        </form>
    </div>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
