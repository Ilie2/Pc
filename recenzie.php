<?php
include 'config-2.php';

// Validarea și filtrarea recenziilor
function validateReview($text, $rating) {
    $errors = [];
    
    if (strlen($text) < 10) {
        $errors[] = "Recenzia trebuie să conțină cel puțin 10 caractere.";
    }
    
    if ($rating < 1 || $rating > 5) {
        $errors[] = "Rating-ul trebuie să fie între 1 și 5.";
    }
    
    $forbidden_words = ["spam", "offensive", "hate"];
    foreach ($forbidden_words as $word) {
        if (stripos($text, $word) !== false) {
            $errors[] = "Recenzia conține cuvinte interzise.";
            break;
        }
    }
    
    return $errors;
}

// Adăugarea unei recenzii (în cazul în care utilizatorul a trimis un formular)
if (isset($_POST['submit_review'])) {
    $product_id = $_POST['product_id'];
    $user_id = $_POST['user_id'];
    $text = $_POST['text'];
    $rating = $_POST['rating'];
    
    // Validarea recenziei
    $errors = validateReview($text, $rating);
    
    if (empty($errors)) {
        $date = date("Y-m-d H:i:s");
        $sql = "INSERT INTO reviews (product_id, user_id, text, rating, date) VALUES ($product_id, $user_id, '$text', $rating, '$date')";
        
        if ($conn->query($sql) === TRUE) {
            echo "Recenzia a fost adăugată cu succes!";
        } else {
            echo "Eroare: " . $sql . "<br>" . $conn->error;
        }
    } else {
        foreach ($errors as $error) {
            echo $error . "<br>";
        }
    }
}

// Afișarea recenziilor
$sql = "SELECT * FROM reviews WHERE product_id = X"; // Înlocuiește X cu ID-ul produsului
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $user_id = $row['user_id'];
        $text = $row['text'];
        $rating = $row['rating'];
        $date = $row['date'];
        
        // Afișează recenzia pe pagină
        echo "Utilizator: $user_id<br>";
        echo "Rating: $rating<br>";
        echo "Recenzie: $text<br>";
        echo "Data: $date<br>";
        echo "<hr>";
    }
} else {
    echo "Nicio recenzie disponibilă pentru acest produs.";
}

$conn->close();
?>

<!-- Formular pentru adăugarea unei noi recenzii -->
<form method="post">
    <input type="hidden" name="product_id" value="X"> <!-- Înlocuiește X cu ID-ul produsului -->
    <input type="hidden" name="user_id" value="Y"> <!-- Înlocuiește Y cu ID-ul utilizatorului -->
    
    <label for="rating">Rating (1-5):</label>
    <input type="number" name="rating" id="rating" min="1" max="5" required><br>
    
    <label for="text">Recenzie:</label>
    <textarea name="text" id="text" required></textarea><br>
    
    <input type="submit" name="submit_review" value="Adaugă recenzie">
</form>
