<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$feedback_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = isset($_POST['nume']) ? $_POST['nume'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $experienta = isset($_POST['experienta']) ? $_POST['experienta'] : '';
    $placut = isset($_POST['placut']) ? $_POST['placut'] : '';
    $imbunatatiri = isset($_POST['imbunatatiri']) ? $_POST['imbunatatiri'] : '';
    $comentarii = isset($_POST['comentarii']) ? $_POST['comentarii'] : '';

    if (empty($name) || empty($email) || empty($experienta) || empty($placut) || empty($imbunatatiri)) {
        $feedback_message = "Toate câmpurile sunt obligatorii. Te rugăm să completezi toate informațiile.";
    } else {
        $mail = new PHPMailer(true);

        try {

            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; 
            $mail->SMTPAuth = true;
            $mail->Username = 'alexandrescudan19@gmail.com';
            $mail->Password = 'djmr qktm ouik zhes';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom($email, $name);
            $mail->addAddress('your_email@example.com');


            $mail->isHTML(false);
            $mail->Subject = "Feedback Magazin Online";
            $mail->Body = "Nume: $name\nE-mail: $email\nExperienta: $experienta\nPlacut: $placut\nImbunatatiri: $imbunatatiri\nComentarii:\n$comentarii";

            $mail->send();
            $feedback_message = "Feedback trimis cu succes!";
        } catch (Exception $e) {
            $feedback_message = "Eroare la trimiterea feedback-ului: {$mail->ErrorInfo}";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Feedback Magazin Online</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 0;
      align-items: center;
      justify-content: center;
    }

    form {
      background-color: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      width: 400px;
      max-width: 100%;
    }

    h2 {
      text-align: center;
      color: #333;
    }

    label {
      display: block;
      margin-bottom: 8px;
      color: #333;
    }

    input,
    textarea {
      width: 100%;
      padding: 8px;
      margin-bottom: 16px;
      box-sizing: border-box;
    }

    textarea {
      resize: vertical;
    }

    input[type="submit"] {
      background-color: #4caf50;
      color: #fff;
      cursor: pointer;
    }

    p {
      color: <?php echo (!empty($feedback_message) && strpos($feedback_message, "succes") !== false ? '#4caf50' : '#f00'); ?>;
      font-weight: bold;
    }
  </style>
</head>
<body>

  <form action="" method="post">
    <h2>Feedback pentru Magazinul Nostru Online</h2>

    <?php if (!empty($feedback_message)): ?>
      <p><?php echo $feedback_message; ?></p>
    <?php endif; ?>

    <label for="nume">Nume:</label>
    <input type="text" id="nume" name="nume" required>

    <label for="email">Adresa de e-mail:</label>
    <input type="email" id="email" name="email" required>

    <h3>1. Experiența de Cumpărare:</h3>
    <label for="experienta">a. Cum ai descris experiența ta generală de cumpărare de la noi?</label>
    <textarea id="experienta" name="experienta" rows="4" required></textarea>

    <label for="placut">b. Ce ți-a plăcut cel mai mult?</label>
    <textarea id="placut" name="placut" rows="4" required></textarea>

    <label for="imbunatatiri">c. Există aspecte pe care crezi că le-am putea îmbunătăți?</label>
    <textarea id="imbunatatiri" name="imbunatatiri" rows="4" required></textarea>

    <h3>2. Sugestii și Comentarii Adiționale:</h3>
    <label for="comentarii">Lăsați spațiu pentru orice alt feedback, sugestii sau comentarii:</label>
    <textarea id="comentarii" name="comentarii" rows="4"></textarea>

    <input type="submit" value="Trimite Feedback">
  </form>

</body>
</html>
