<?php
include 'dbh.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmpassword'];

    if ($password === $confirmPassword) {
        // Password and confirm password match
        // Prepare the SQL statement to insert the user
        $insertqry = "INSERT INTO user_info(username, email, password) VALUES(?, ?, ?)";
        $stmt = $conn->prepare($insertqry);
        $stmt->bind_param("sss", $username, $email, $password);

        $response = [];

        if ($stmt->execute()) {
            $response['status'] = true;
            $response['message'] = "Signup Successfully";
        } else {
            $response['status'] = false;
            $response['message'] = "Signup Failed";
        }

        $stmt->close();
    } else {
        $response = [
            'status' => false,
            'message' => 'Password and Confirm Password do not match'
        ];
    }
} else {
    $response = [
        'status' => false,
        'message' => 'Invalid Request Method'
    ];
}

header('Content-Type: application/json; charset=UTF-8');
echo json_encode($response);
?>
