<?php
require_once('dbh.php');
require_once('session.php'); // Include your session management script

// Retrieve the logged-in user's username from the session
$username = $_SESSION['username'];

// SQL query to select "username," "email," and "points" for the logged-in user
$sql = "SELECT username, email, allpoints FROM user_info WHERE username = '$username'";
$result = $conn->query($sql);

$response = array(); // Initialize an array to store the response

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $response['data'] = array(
        array(
            'username' => $row["username"],
            'email' => $row["email"],
            'points' => $row["allpoints"]
        )
    );
} else {
    $response['message'] = 'User data not found';
}

// Close the database connection
$conn->close();

// Set the response content type to JSON
header('Content-Type: application/json');

// Output the JSON response
echo json_encode($response);
?>
