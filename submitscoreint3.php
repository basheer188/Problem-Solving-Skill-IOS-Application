<?php
include 'dbh.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start(); // Start the session

    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        $points = $_POST['points']; // Points are received from POST data

        if (!empty($username) && is_numeric($points)) {
            // Assuming that 'points' is an integer value, you should validate its format.

            if ($conn) {
                $update_query = "UPDATE user_info SET int_level3 = ? WHERE username = ?";
                $stmt = $conn->prepare($update_query);

                $response = [];

                if ($stmt) {
                    $stmt->bind_param("ss", $points, $username);

                    if ($stmt->execute()) {
                        $response['username'] = $username;
                        $response['score'] = $points;
                    } else {
                        $response['status'] = false;
                        $response['error'] = "Error updating points: " . $stmt->error;
                    }

                    $stmt->close();
                } else {
                    $response['status'] = false;
                    $response['error'] = "Error preparing statement: " . $conn->error;
                }
            } else {
                $response['status'] = false;
                $response['error'] = "Database connection error.";
            }
        } else {
            $response = [
                'status' => false,
                'error' => 'Invalid or missing data in the request.'
            ];
        }
    } else {
        $response = [
            'status' => false,
            'error' => 'Username not found in session.'
        ];
    }
} else {
    $response = [
        'status' => false,
        'error' => 'Invalid Request Method'
    ];
}

header('Content-Type: application/json; charset=UTF-8');
echo json_encode($response);
?>
