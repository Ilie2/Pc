<?php
session_start();

include 'config-1.php';

// Interogarea pentru a obține comenzile
$sql = "SELECT * FROM orders";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Manage Orders</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="dashboard-container">
        <h2>Manage Orders</h2>
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Number</th>
                    <th>Email</th>
                    <th>Method</th>
                    <th>Address</th>
                    <th>Total Products</th>
                    <th>Total Price</th>
                    <th>Placed On</th>
                    <th>Payment Status</th>
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
                        echo "<td>{$row['user_id']}</td>";
                        echo "<td>{$row['name']}</td>";
                        echo "<td>{$row['number']}</td>";
                        echo "<td>{$row['email']}</td>";
                        echo "<td>{$row['method']}</td>";
                        echo "<td>{$row['address']}</td>";
                        echo "<td>{$row['total_products']}</td>";
                        echo "<td>{$row['total_price']}</td>";
                        echo "<td>{$row['placed_on']}</td>";
                        echo "<td>{$row['payment_status']}</td>";
                        echo "<td><a href='?delete_id={$row['id']}' onclick='return confirm(\"Are you sure you want to delete this order?\")'>Delete</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='12'>No orders found</td></tr>";
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
