<?php
session_start();

// Conectare la baza de date
$servername = "localhost";
$username = "root";
$password = "";
$database = "shop_db";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Verificăm dacă formularul de autentificare a fost trimis
if(isset($_POST['login'])) {
    $admin_username = $_POST['username'];
    $admin_password = $_POST['password'];
    
    // Interogare pentru a verifica existența administratorului în baza de date
    $sql = "SELECT * FROM admins WHERE name='$admin_username' AND password='$admin_password'";
    $result = mysqli_query($conn, $sql);
    
    if(mysqli_num_rows($result) == 1) {
        // Administratorul a fost găsit, deci setăm variabila de sesiune și redirecționăm către pagina de administrare
        $_SESSION['admin_logged_in'] = true;
        header("Location: dashboard.php");
        exit();
    } else {
        // Autentificare eșuată, afișăm un mesaj de eroare
        $error_message = "Invalid username or password!";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
</head>
<body>
    <h2>Admin Login</h2>
    <?php if(isset($error_message)) { echo "<p>$error_message</p>"; } ?>
    <form action="" method="post">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" required><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" name="login" value="Login">
    </form>
</body>
</html>

<?php
// Închidem conexiunea la baza de date
mysqli_close($conn);
?>
