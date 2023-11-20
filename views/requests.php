<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/request.css">

    <title>Requests</title>
</head>
<body>
    <!-- Inside the loop where you display mentorship requests -->
    <div class="request-entry">
        <table>
            <tr>
                <th>Request ID</th>
                <th>Mentee Name</th>
                <th>Action</th>
                <th>Details</th>
            </tr>
            <tr>
                <td><?php echo $row['request_id']; ?></td>
                <td><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></td>
                <td>
                    <button onclick="acceptRequest(<?php echo $row['request_id']; ?>)">Accept</button>
                    <button onclick="declineRequest(<?php echo $row['request_id']; ?>)">Decline</button>
                </td>
                <td>
                    <button onclick="viewDetails(<?php echo $row['mentee_id']; ?>)">View Details</button>
                </td>
            </tr>
        </table>
    </div>

</body>
</html>