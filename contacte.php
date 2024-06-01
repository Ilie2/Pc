<?php
include 'config-2.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Ajustează calea relativă în funcție de structura proiectului tău
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $number = isset($_POST['number']) ? $_POST['number'] : '';
    $subject = isset($_POST['subject']) ? $_POST['subject'] : '';
    $message = isset($_POST['message']) ? $_POST['message'] : '';

    // Validare simplă a datelor
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        echo "Toate câmpurile sunt obligatorii. Te rugăm să completezi toate informațiile.";
        exit;
    }

    // Crează o instanță PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Setări server
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';  // Folosește 'localhost' pentru că utilizezi XAMPP
        $mail->SMTPAuth = true;  // Nu este nevoie de autentificare pentru localhost
        $mail->Username = 'alexandrescudan19@gmail.com';
        $mail->Password = 'djmr qktm ouik zhes';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;  // Folosește portul 25 pentru XAMPP

        // Destinatari
        $mail->setFrom($email, $name);
        $mail->addAddress('your_email@example.com'); // Înlocuiește cu adresa ta de email

        // Conținut
        $mail->isHTML(false);
        $mail->Subject = "New Contact Form Submission: $subject";
        $mail->Body = "Name: $name\nEmail: $email\nPhone Number: $number\nSubject: $subject\n\nMessage:\n$message";

        $mail->send();
        echo "Email trimis cu succes. Mulțumim pentru contactare!";
    } catch (Exception $e) {
        echo "Eroare la trimiterea email-ului. Te rugăm să încerci din nou mai târziu. Eroare: {$mail->ErrorInfo}";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>GadgetHub</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="css/style-0.css">
    <link rel="stylesheet" type="text/css" href="css/scrollbar.css">
</head>
<body>
    <?php
    include 'components/header.php';
    ?>

    <section class="contact" id="contact">
        <h1 class="heading"> <span>contact</span> us </h1>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="inputBox">
                <input type="text" name="name" placeholder="Name" required>
                <input type="email" name="email" placeholder="Email" required>
            </div>
            <div class="inputBox">
                <input type="tel" name="number" placeholder="Phone Number">
                <input type="text" name="subject" placeholder="Subject" required>
            </div>
            <textarea name="message" placeholder="Message" cols="30" rows="10" required></textarea>
            <input type="submit" value="Send Message" class="btn">
        </form>
    </section>

    <?php
    include 'components/footer.php';
    ?>
</body>
</html>
