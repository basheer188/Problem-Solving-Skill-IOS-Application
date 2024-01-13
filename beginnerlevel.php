<?php
require_once('session.php');
require_once('dbh.php');

// Initialize the response array
$response = [];

// Get the user's progress based on the username
$username = $_SESSION['username']; // Replace with the actual username
$query = "SELECT * FROM user_info WHERE username = '$username'";
$result = mysqli_query($conn, $query);

$userProgress = [];

if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);

    // Populate the user progress array with relevant data from the user_info table
    $userProgress[] = [
        'level_1_points' => $row['points'],
        'level_2_points' => $row['quiz_score'],
        'level_3_points' => $row['level3'],
        'level_4_points' => $row['level4'],
    ];

    // Add the user progress to the response
    $response['userProgress'] = $userProgress;
    $response['status'] = 'success';
} else {
    // Handle the case when the user's progress record is not found
    $response['status'] = 'error';
    $response['message'] = 'User progress not found.';
}

// Close the database connection
mysqli_close($conn);

// Set the response content type to JSON
header('Content-Type: application/json');

// Output the JSON response
echo json_encode($response);
?>
