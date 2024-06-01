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
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, md5($_POST['password']));
    $cpassword = mysqli_real_escape_string($conn, md5($_POST['cpassword']));

    // Verificăm dacă parolele coincid
    if($password !== $cpassword) {
      $message[] = 'Passwords do not match!';
  } else {
      // Verificăm dacă utilizatorul există deja
      $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE email = '$email'") or die('query failed');
      if(mysqli_num_rows($select) > 0) {
          $message[] = 'User already exists!';
      } else {
          // Inserăm utilizatorul în tabelul `user_form`
          mysqli_query($conn, "INSERT INTO `user_form` (name, email, password) VALUES ('$name', '$email', '$password')") or die(mysqli_error($conn));
          
          // Obținem ID-ul utilizatorului inserat
          $user_id = mysqli_insert_id($conn);

          // Generăm un cod de verificare
          $verificationCode = generateVerificationCode();

          // Salvăm codul de verificare în baza de date pentru utilizatorul respectiv
          mysqli_query($conn, "INSERT INTO `email_verification` (user_id, verification_code) VALUES ('$user_id', '$verificationCode')") or die(mysqli_error($conn));


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
                $mail->addAddress($email, $name); // Adresa și numele destinatarului

                // Subiectul și conținutul e-mailului
                $mail->Subject = 'Email Verification Code';
                $mail->Body = 'Your verification code is: ' . $verificationCode;

                // Trimitem e-mailul
                $mail->send();

                // Redirectăm la pagina de verificare
                header("Location: verify.php?email=$email");
                exit(); // Asigură-te că scriptul se oprește după redirecționare
            } catch (Exception $e) {
                // Afișăm un mesaj de eroare în caz de problemă cu trimiterea e-mailului
                $message[] = 'Error sending verification code. Please try again later.';
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" type="text/css" href="css/style.css">
   <link rel="stylesheet" type="text/css" href="css/scrollbar.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">


</head>
<body>

<?php
include 'components/header.php';
?>

<?php
if(isset($message)){
   foreach($message as $message){
      echo '<div class="message" onclick="this.remove();">'.$message.'</div>';
   }
}
?>
   
<div class="form-container">

   <form action="" method="post">
      <h3>register now</h3>
      <input type="text" name="name" required placeholder="enter username" class="box">
      <input type="email" name="email" required placeholder="enter email" class="box">
      <input type="password" name="password" required placeholder="enter password" class="box">
      <input type="password" name="cpassword" required placeholder="confirm password" class="box">
      <input type="submit" name="submit" class="btn" value="register now">
      <p>already have an account? <a href="login-1.php">login now</a></p>
   </form>

</div>



</body>
</html>