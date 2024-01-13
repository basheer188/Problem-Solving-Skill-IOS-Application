<?php
// Include your database connection code here
require_once('dbh.php');
// Query to retrieve user scores
$query = "SELECT username, points FROM user_info ORDER BY points DESC";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $scoreboardData = array();
    while ($row = $result->fetch_assoc()) {
        $scoreboardData[] = $row;
    }
} else {
    $scoreboardData = array();
}

// Close the database connection
$conn->close();

// Create a response array
$response = array();

// Check if scoreboard data is available
if (!empty($scoreboardData)) {
    $response['status'] = 'success';
    $response['message'] = 'Scoreboard data retrieved successfully';
    $response['data'] = $scoreboardData;
} else {
    $response['status'] = 'error';
    $response['message'] = 'No scores found.';
}

// Set the response content type to JSON
header('Content-Type: application/json');

// Output the JSON response
echo json_encode($response);
?>
