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

// SQL query to retrieve project information with user details
$query = "SELECT p.id, p.image_path, p.description, p.title, p.category, CONCAT(u.first_name, ' ', u.last_name) AS creator_name
          FROM projects p
          JOIN users u ON p.user_id = u.id";


$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/request.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Sofia">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>

    <title>Dashboard</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <!-- Your navigation links -->
    </div>

    <div class="dashboard">
        <h2>Project Information</h2>
        <button onclick="downloadPDF()">Download PDF</button>
        <table id="projectTable">
            <thead>
                <tr>
                    <th>ID</th>
                    
                    <th>Description</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Creator Name</th>
                </tr>
            </thead>
            <tbody id="projectData">
                <?php
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['id']}</td>";
                    
                    echo "<td>{$row['description']}</td>";
                    echo "<td>{$row['title']}</td>";
                    echo "<td>{$row['category']}</td>";
                    echo "<td>{$row['creator_name']}</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <?php
    // Close the database connection
    $conn->close();
    ?>

    <script>
        function downloadPDF() {
            // Initialize jsPDF
            var doc = new jsPDF();

            // Add content to PDF
            doc.text("Project Information", 20, 10);
            doc.autoTable({ html: '#projectTable' });

            // Save the PDF
            doc.save('project_information.pdf');
        }
    </script>
</body>
</html>
