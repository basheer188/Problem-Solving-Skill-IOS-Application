<?php
require_once('dbh.php');
session_start();

$username = "";
$password = "";

$username = $_GET['username'];
$provided_password = $_GET['password'];

$loginqry = "SELECT user_id, username, password FROM user_info WHERE username = '$username'";
$qry = mysqli_query($conn, $loginqry);

if ($qry) {
    $userObj = mysqli_fetch_assoc($qry);

    if ($userObj && $provided_password === $userObj['password']) {
        // Store user data in session
        $_SESSION['user_id'] = $userObj['user_id'];
        $_SESSION['username'] = $userObj['username'];

        $response['status'] = true;
        $response['message'] = "Login Successfully";
        $response['data'] = [$userObj]; // Wrap user data in an array
    } else {
        $response['status'] = false;
        $response['message'] = "Login Failed";
    }
} else {
    $response['status'] = false;
    $response['message'] = "Database query error";
}

header('Content-Type: application/json; charset=UTF-8');
echo json_encode($response);
?>