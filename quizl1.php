<?php
// Replace with your database connection information
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "javaboi";

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to retrieve data from the quiz_questions table
$sql = "SELECT * FROM quiz_questions LIMIT 0, 10";

$result = $conn->query($sql);

// Initialize an array to store the quiz questions and answers
$quizData = array();

// Check if there are results
if ($result->num_rows > 0) {
    // Fetch each row and add it to the quizData array
    while ($row = $result->fetch_assoc()) {
        $quizData[] = array(
            "question" => $row["question"],
            "answer" => [
                array("text" => $row["answer_1"], "correct" => 1 == $row["correct_answer"]),
                array("text" => $row["answer_2"], "correct" => 2 == $row["correct_answer"]),
                array("text" => $row["answer_3"], "correct" => 3 == $row["correct_answer"]),
                array("text" => $row["answer_4"], "correct" => 4 == $row["correct_answer"]),
            ],
        );
    }
}

// Create an associative array with the "questions" key
$response = ["questions" => $quizData];

// Convert the response array to JSON
$jsonData = json_encode($response, JSON_PRETTY_PRINT);

// Output the JSON data
header("Content-Type: application/json");
echo $jsonData;

// Close the database connection
$conn->close();
?>
