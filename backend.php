<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Funcție pentru a obține un răspuns la întrebare
function getBotResponse($userInput) {
    // Transformă întrebarea utilizatorului în litere mici pentru o verificare mai flexibilă
    $userInputLower = strtolower($userInput);

    // Lista de întrebări și răspunsuri asociate
    $qaPairs = [
        'cum te numesti?' => 'Bot: Sunt un chatbot creat de tine!',
        'cat e ceasul?' => 'Bot: Momentan nu pot să-ți spun ora, dar te pot ajuta cu altceva!',
        'cum pot să plasez o comandă online?'=>'Pentru a plasa o comandă, trebuie să accesați site-ul nostru, să selectați produsul dorit și să urmați pașii indicați în procesul de checkout.',
        'care sunt opțiunile de plată disponibile?'=>'Acceptăm plata la cash on delivery.',
        'care este timpul estimat de livrare?'=>'Timpul de livrare poate varia în funcție de locație și de produs. În general, veți primi informații detaliate privind livrarea în timpul procesului de checkout. în contul dvs. online.',
        'ce fac dacă am probleme cu un produs primit?'=>'Dacă întâmpinați probleme cu un produs, vă rugăm să ne contactați imediat. Puteți utiliza formularul nostru de contact de pe site sau să ne sunați la numărul de suport indicat pentru a primi asistență rapidă.',
        'există reduceri sau oferte speciale disponibile?'=>'Verificați periodic site-ul nostru pentru a descoperi reduceri, oferte speciale și promoții curente. De asemenea, puteți subscrie la newsletter pentru a fi la curent cu cele mai recente noutăți și oferte.'
    ];

    // Verifică dacă întrebarea se află în lista de întrebări și returnează răspunsul corespunzător
    if (isset($qaPairs[$userInputLower])) {
        return $qaPairs[$userInputLower];
    }

    // Dacă întrebarea nu este găsită în lista predefinită, alege un răspuns aleator din lista generală
    $responses = [
        "Salut!",
        "Bună ziua!",
        "Cum te pot ajuta astăzi?",
        "Interesant! Spune-mi mai multe.",
        "Îmi pare bine să te întâlnesc!",
    ];

    return $responses[array_rand($responses)];
}

// Verifică dacă există input de la utilizator
if (isset($_POST['user_input'])) {
    $userInput = $_POST['user_input'];

    // Salvează întrebarea utilizatorului în sesiune
    $_SESSION['chat_history'][] = "Tu: " . $userInput;

    // Obține răspunsul botului
    $botResponse = getBotResponse($userInput);

    // Salvează răspunsul botului în sesiune
    $_SESSION['chat_history'][] = $botResponse;
} else {
    // Inițializează sau resetează istoricul chat-ului
    $_SESSION['chat_history'] = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Chatbot</title>
    <!-- Adaugă link-urile către Bootstrap CSS și Font Awesome pentru iconițe -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
       

        #chat-container {
            max-width: 400px;
            margin: 20px;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow-y: scroll;
            height: 300px;
        }

        #chat-container p {
            margin: 5px 0;
        }

        .chat-form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .input-group {
            width: 100%;
            max-width: 300px;
            margin-top: 10px;
        }

        input {
            padding: 8px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            width: 70%;
        }

        button {
            padding: 8px 16px;
            background-color: #28a745;
            color: #ffffff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card" id="chat-container">
            <?php
            // Afișează istoricul chat-ului
            foreach ($_SESSION['chat_history'] as $message) {
                echo "<p>$message</p>";
            }
            ?>
        </div>
        
        <form method="POST" action="" class="chat-form mt-3">
            <div class="input-group">
                <input type="text" name="user_input" class="form-control" placeholder="Introdu o întrebare...">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-success"><i class="fas fa-paper-plane"></i> Trimite</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Adaugă scripturile către jQuery și Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

