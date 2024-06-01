<?php

include 'config-1.php';


function getResponseFromDatabase($question, $conn) {
    $question = mysqli_real_escape_string($conn, $question);

    $sql = "SELECT response FROM chatbot_responses WHERE question = '$question'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row["response"];
    } else {
        return "Nu am găsit un răspuns potrivit pentru această întrebare.";
    }
}

$userQuestion = $_GET['q'];


$response = getResponseFromDatabase($userQuestion, $conn);


echo $response;

mysqli_close($conn);

?>
