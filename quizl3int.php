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
$sql = "SELECT * FROM quiz_questionsint LIMIT 20, 10";

$result = $conn->query($sql);

// Initialize an array to store the quiz questions and answers
$quizData = array();

// Check if there are results
if ($result->num_rows > 0) {
    // Fetch each row and add it to the quizData array
    while ($row = $result->fetch_assoc()) {
        $quizData[] = array(
            "id" => $row["id"],
            "question" => $row["question"],
            "answer_1" => $row["answer_1"],
            "answer_2" => $row["answer_2"],
            "answer_3" => $row["answer_3"],
            "answer_4" => $row["answer_4"],
            "correct_answer" => $row["correct_answer"]
        );
    }
}

// Convert the quizData array to JSON
$jsonData = json_encode($quizData, JSON_PRETTY_PRINT);

// Output the JSON data
header("Content-Type: application/json");


// Close the database connection
$conn->close();
?>

<?php
// Alternatively, you can place this section at the end of the file to transform the JSON structure
$jsonResponse = $jsonData;

// Decode the original JSON response
$data = json_decode($jsonResponse, true);

// Initialize an empty array for the new JSON structure
$newJson = [];

// Iterate through the original data and create the new structure
foreach ($data as $item) {
    $newItem = [
        "question" => $item["question"],
        "answer" => []
    ];

    // Iterate through answer options
    for ($i = 1; $i <= 4; $i++) {
        $newItem["answer"][] = [
            "text" => $item["answer_" . $i],
            "correct" => ($i == $item["correct_answer"])
        ];
    }

    $newJson[] = $newItem;
}

// Encode the new JSON structure
$newJsonResponse = json_encode($newJson, JSON_PRETTY_PRINT);

// Output the new JSON
header("Content-Type: application/json");
echo $newJsonResponse;
?>
