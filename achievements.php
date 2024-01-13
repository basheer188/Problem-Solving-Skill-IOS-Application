<?php
require_once('dbh.php');
require_once('session.php');

// Initialize the response array
$response = [];

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Retrieve the existing scores from the database
    $sql = "SELECT points, quiz_score, level3, level4, int_level1, int_level2, int_level3, int_level4, exp_level1, exp_level2, exp_level3, exp_level4 FROM user_info WHERE user_id = $user_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Get the existing scores from the database
        $points = $row['points'];
        $quiz_score = $row['quiz_score'];
        $level3 = $row['level3'];
        $level4 = $row['level4'];
        $int_level1 = $row['int_level1'];
        $int_level2 = $row['int_level2'];
        $int_level3 = $row['int_level3'];
        $int_level4 = $row['int_level4'];
        $exp_level1 = $row['exp_level1'];
        $exp_level2 = $row['exp_level2'];
        $exp_level3 = $row['exp_level3'];
        $exp_level4 = $row['exp_level4'];

        // Calculate the updated scores for each category
        $beginner_score = (int)($points + $quiz_score +  $level3 + $level4); // Convert to integer
        $intermediate_score = (int)($int_level1 + $int_level2 + $int_level3 + $int_level4); // Convert to integer
        $expert_score = (int)($exp_level1 + $exp_level2 + $exp_level3 + $exp_level4); // Convert to integer

        // Update the scores in the table
        $updateSql = "UPDATE user_info SET 
            beginner_score = $beginner_score,
            intermediate_score = $intermediate_score,
            expert_score = $expert_score,
            quiz_score = quiz_score + $quiz_score,
            level3 = level3 + $level3,
            level4 = level4 + $level4
            WHERE user_id = $user_id";

        if ($conn->query($updateSql) === TRUE) {
            $response['update_status'] = 'Scores updated successfully';
        } else {
            $response['update_status'] = 'Error updating scores: ' . $conn->error;
        }
    } else {
        $response['update_status'] = 'User not found.';
    }
} else {
    $response['update_status'] = 'User not found in the session.';
}

// Retrieve the updated scores for the user
$user_id_for_scores = $_SESSION['user_id'];

// Retrieve scores for the specified user from the database
$sql = "SELECT beginner_score, intermediate_score, expert_score FROM user_info WHERE user_id = $user_id_for_scores";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    $response['Data'] = [
        [
            'beginner_score' => (int)$row['beginner_score'], // Convert to integer
            'intermediate_score' => (int)$row['intermediate_score'], // Convert to integer
            'expert_score' => (int)$row['expert_score'] // Convert to integer
        ]
    ];
} else {
    $response['update_status'] = 'User not found.';
}

// Close the database connection
$conn->close();

// Encode the response array as JSON and output it
header('Content-Type: application/json');
echo json_encode($response);
?>
