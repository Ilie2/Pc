<?php

include 'config-1.php';
include 'PHPMailer/src/PHPMailer.php';
include 'PHPMailer/src/SMTP.php';
include 'PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

session_start();

// Funcție pentru generarea unui cod de verificare
function generateVerificationCode() {
    return rand(100000, 999999);
}

if (isset($_POST['submit'])) {

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, md5($_POST['password']));

    $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE email = '$email' AND password = '$password'") or die('query failed');

    if (mysqli_num_rows($select) > 0) {
        $row = mysqli_fetch_assoc($select);

        // Verificăm dacă utilizatorul este deja verificat
        if ($row['is_verified']) {
            $_SESSION['user_id'] = $row['id'];
            header('location: shoping cart.php');
        } else {
            // Dacă utilizatorul nu este verificat, generăm un cod de verificare
            $verificationCode = generateVerificationCode();

            // Salvăm codul de verificare în tabelul email_verification pentru utilizatorul respectiv
            mysqli_query($conn, "INSERT INTO `email_verification` (user_id, verification_code) VALUES ({$row['id']}, $verificationCode)");

            // Trimitem e-mailul utilizând PHPMailer
            $mail = new PHPMailer(true);

            try {
                // Configurăm serverul SMTP
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; 
                $mail->SMTPAuth = true;
                $mail->Username = 'alexandrescudan19@gmail.com';
                $mail->Password = 'djmr qktm ouik zhes';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                // Configurăm expeditorul și destinatarul
                $mail->setFrom('alexandrescudan19@gmail.com', 'Your Name'); // Adresa și numele expeditorului
                $mail->addAddress($email, $row['name']); // Adresa și numele destinatarului

                // Subiectul și conținutul e-mailului
                $mail->Subject = 'Email Verification Code';
                $mail->Body = 'Your verification code is: ' . $verificationCode;

                // Trimitem e-mailul
                $mail->send();

                // Redirecționăm la pagina de verificare
                header("Location: verify.php?code=$verificationCode");
                exit(); // Asigură-te că scriptul se oprește după redirecționare
            } catch (Exception $e) {
                // Afișăm un mesaj de eroare în caz de problemă cu trimiterea e-mailului
                $message[] = 'Error sending verification code. Please try again later.';
            }
        }
    } else {
        $message[] = 'Incorrect password or email!';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- custom css file link  -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/scrollbar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

</head>

<body>

    <?php
    if (isset($message)) {
        foreach ($message as $message) {
            echo '<div class="message" onclick="this.remove();">' . $message . '</div>';
        }
    }
    ?>

    <!-- header section starts  -->
    <?php
    include 'components/header.php';
    ?>

    <!-- header section ends -->

    <div class="form-container">

        <form action="" method="post">
            <h3>Login now</h3>
            <input type="email" name="email" required placeholder="Enter email" class="box">
            <input type="password" name="password" required placeholder="Enter password" class="box">
            <input type="submit" name="submit" class="btn" value="Login now">
            <p>Don't have an account? <a href="register-1.php">Register now</a> or <a href="verify.php?code=123456">Verify your account</a></p>

        </form>

    </div>

</body>

</html>
