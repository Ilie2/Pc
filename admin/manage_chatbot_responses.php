<?php
session_start();

include 'config-1.php';

// Verificăm dacă a fost trimisă o cerere de adăugare a unei conversații
if (isset($_POST['add'])) {
    $question = $_POST['question'];
    $response = $_POST['response'];
    
    // Adăugăm noua conversație în baza de date
    $sql_add = "INSERT INTO chatbot_responses (question, response) VALUES ('$question', '$response')";
    if (mysqli_query($conn, $sql_add)) {
        echo "<script>alert('Conversation added successfully');</script>";
    } else {
        echo "<script>alert('Error adding conversation');</script>";
    }
}

// Verificăm dacă a fost trimisă o cerere de ștergere a unei conversații
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    
    // Ștergem conversația din baza de date
    $sql_delete = "DELETE FROM chatbot_responses WHERE id = $delete_id";
    if (mysqli_query($conn, $sql_delete)) {
        echo "<script>alert('Conversation deleted successfully');</script>";
    } else {
        echo "<script>alert('Error deleting conversation');</script>";
    }
}

// Interogarea pentru a obține conversațiile
$sql = "SELECT * FROM chatbot_responses";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Manage Chat Conversations</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="dashboard-container">
        <h2>Manage Chat Conversations</h2>
        
        <!-- Formular pentru adăugarea unei noi conversații -->
        <form action="" method="post">
            <label for="question">Question:</label><br>
            <input type="text" id="question" name="question" required><br>
            <label for="response">Response:</label><br>
            <textarea id="response" name="response" required></textarea><br><br>
            <input type="submit" name="add" value="Add Conversation">
        </form>
        
        <table>
            <thead>
                <tr>
                    <th>Conversation ID</th>
                    <th>Question</th>
                    <th>Response</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Verificăm dacă s-au găsit rezultate
                if (mysqli_num_rows($result) > 0) {
                    // Parcurgem rezultatele și le afișăm în tabel
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>{$row['id']}</td>";
                        echo "<td>{$row['question']}</td>";
                        echo "<td>{$row['response']}</td>";
                        echo "<td><a href='?delete_id={$row['id']}' onclick='return confirm(\"Are you sure you want to delete this conversation?\")'>Delete</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No conversations found</td></tr>";
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
