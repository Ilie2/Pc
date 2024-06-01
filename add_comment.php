<?php
include 'config-1.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST["product_id"];
    $author = $_POST["author"];
    $comment_content = $_POST["comment"];

    $sql_insert_comment = "INSERT INTO comment_1 (product_id, comment_author, comment_content) VALUES ($product_id, '$author', '$comment_content')";

    if ($conn->query($sql_insert_comment) === TRUE) {
        header("Location: HOME.php");
        exit();
    } else {
        echo "Eroare la adăugarea comentariului: " . $conn->error;
    }
} else {
    echo "Metoda de acces incorectă.";
}

// Închideți conexiunea la baza de date
$conn->close();
?>
