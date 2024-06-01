<?php
session_start();

// Verificăm dacă utilizatorul este autentificat ca administrator
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

// Conectarea la baza de date
$servername = "localhost";
$username = "root";
$password = "";
$database = "shop_db";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Verificăm dacă a fost trimisă o cerere de ștergere a unei recenzii
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    
    // Verificăm în ce tabel trebuie să căutăm recenzia
    if ($_GET['table'] === 'comments') {
        $table = 'comments';
    } elseif ($_GET['table'] === 'comment_1') {
        $table = 'comment_1';
    } else {
        echo "<script>alert('Invalid table');</script>";
        exit();
    }

    // Ștergem recenzia din baza de date
    $sql_delete = "DELETE FROM $table WHERE id = $delete_id";
    if (mysqli_query($conn, $sql_delete)) {
        echo "<script>alert('Review deleted successfully');</script>";
    } else {
        echo "<script>alert('Error deleting review');</script>";
    }
}

// Interogarea pentru a obține recenziile din tabelul 'comments'
$sql_comments = "SELECT * FROM comments";
$result_comments = mysqli_query($conn, $sql_comments);

// Interogarea pentru a obține recenziile din tabelul 'comment_1'
$sql_comment_1 = "SELECT * FROM comment_1";
$result_comment_1 = mysqli_query($conn, $sql_comment_1);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Manage Reviews</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="dashboard-container">
        <h2>Manage Reviews</h2>
        <h3>Comments</h3>
        <table>
            <thead>
                <tr>
                    <th>Review ID</th>
                    <th>Product ID</th>
                    <th>Content</th>
                    <th>Author</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Afisarea recenziilor din tabelul 'comments'
                if (mysqli_num_rows($result_comments) > 0) {
                    while ($row = mysqli_fetch_assoc($result_comments)) {
                        echo "<tr>";
                        echo "<td>{$row['id']}</td>";
                        echo "<td>{$row['product_id']}</td>";
                        echo "<td>{$row['comment_content']}</td>";
                        echo "<td>{$row['comment_author']}</td>";
                        echo "<td>{$row['created_at']}</td>";
                        echo "<td><a href='?delete_id={$row['id']}&table=comments' onclick='return confirm(\"Are you sure you want to delete this review?\")'>Delete</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No reviews found</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <h3>Comment_1</h3>
        <table>
            <thead>
                <tr>
                    <th>Review ID</th>
                    <th>Product ID</th>
                    <th>Content</th>
                    <th>Author</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Afisarea recenziilor din tabelul 'comment_1'
                if (mysqli_num_rows($result_comment_1) > 0) {
                    while ($row = mysqli_fetch_assoc($result_comment_1)) {
                        echo "<tr>";
                        echo "<td>{$row['id']}</td>";
                        echo "<td>{$row['product_id']}</td>";
                        echo "<td>{$row['comment_content']}</td>";
                        echo "<td>{$row['comment_author']}</td>";
                        echo "<td>{$row['created_at']}</td>";
                        echo "<td><a href='?delete_id={$row['id']}&table=comment_1' onclick='return confirm(\"Are you sure you want to delete this review?\")'>Delete</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No reviews found</td></tr>";
                }
                ?>
            </tbody>
        </table>
        
        <a href="dashboard.php">Back to Dashboard</a>
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>

<?php
// Închidem conexiunea la baza de date
mysqli_close($conn);
?>
