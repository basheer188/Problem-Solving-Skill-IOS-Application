<?php
include('session.php');

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "javaboi";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to update the 'allpoints' column
$updateQuery = "UPDATE user_info SET allpoints = points + quiz_score + level3 + level4 + int_level1 + int_level2 + int_level3 + int_level4 + exp_level1 + exp_level2 + exp_level3 + exp_level4";
if ($conn->query($updateQuery) === TRUE) {
    // No need to echo a response here
} else {
    echo "Error updating allpoints: " . $conn->error;
}

// SQL query to fetch the overall points and username
$sql = "SELECT username, allpoints FROM user_info  ORDER BY allpoints DESC";
$result = $conn->query($sql);

$response = array(); // Initialize an array to store the response

if ($result->num_rows > 0) {
    $leaderboard = array();
    while ($row = $result->fetch_assoc()) {
        $leaderboard[] = array(
            'username' => $row["username"],
            'overall_points' => $row["allpoints"]
        );
    }
    $response['leaderboard'] = $leaderboard;
} else {
    $response['message'] = 'No results found';
}

// Close the database connection
$conn->close();

// Set the response content type to JSON
header('Content-Type: application/json');

// Output the JSON response
echo json_encode($response);
?>
