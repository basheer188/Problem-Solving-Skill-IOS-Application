<?php
require_once('session.php');
require_once('dbh.php');

// Assuming you have set the 'username' in the session
// If not, make sure to set it in your 'session.php' file

// Get the username from the session
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    // SQL query to fetch data for the logged-in user
    $loginqry = "SELECT username, quiz_score FROM user_info WHERE username='$username'";

    $qry = mysqli_query($conn, $loginqry);

    if (mysqli_num_rows($qry) > 0) {

        $i = 0;
        $student = array();

        while ($row = mysqli_fetch_assoc($qry)) {
            $student[$i]['username'] = $row['username'];
            $student[$i]['quiz_score'] = $row['quiz_score'];

            $i = $i + 1;
        }
        $response['status'] = true;
        $response['message'] = "Login Successfully";
        $response['data'] = $student;
    } else {
        $response['status'] = false;
        $response['message'] = "No Data";
    }
} else {
    $response['status'] = false;
    $response['message'] = "Username not found in the session";
}

header('Content-Type: application/json; charset=UTF-8');
echo json_encode($response);
?>
