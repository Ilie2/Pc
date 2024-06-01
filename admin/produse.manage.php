<?php
session_start();
include 'config-1.php';

function getProducts($conn) {
    $sql = "SELECT * FROM produse";
    $rez = $conn->query($sql);
    $products = [];
    if ($rez->num_rows > 0) {
        while ($row = $rez->fetch_assoc()) {
            $products[] = $row;
        }
    }
    return $products;
}

function deleteProduct($conn, $productId) {
    $sql = "DELETE FROM produse WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $stmt->close();
}

function addProduct($conn, $productName, $productPrice, $productImage, $productStock, $productCategory) {
    $sql = "INSERT INTO produse (name, price, image, stock, categorie) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssis", $productName, $productPrice, $productImage, $productStock, $productCategory);
    $stmt->execute();
    $stmt->close();
}

function updateProduct($conn, $productId, $productName, $productPrice, $productImage, $productStock, $productCategory) {
    $sql = "UPDATE produse SET name = ?, price = ?, image = ?, stock = ?, categorie = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssisi", $productName, $productPrice, $productImage, $productStock, $productCategory, $productId);
    $stmt->execute();
    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_product_id'])) {
    $productIdToDelete = $_POST['delete_product_id'];
    deleteProduct($conn, $productIdToDelete);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_product'])) {
    $productName = $_POST['p_name'];
    $productPrice = $_POST['p_price'];
    $productImage = $_POST['p_image'];
    $productStock = $_POST['p_stock'];
    $productCategory = $_POST['p_category'];
    addProduct($conn, $productName, $productPrice, $productImage, $productStock, $productCategory);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_prod_id'])) {
    $productId = $_POST['update_prod_id'];
    $productName = $_POST['p_name'];
    $productPrice = $_POST['p_price'];
    $productImage = $_POST['p_image'];
    $productStock = $_POST['p_stock'];
    $productCategory = $_POST['p_category'];
    updateProduct($conn, $productId, $productName, $productPrice, $productImage, $productStock, $productCategory);
}

$products = getProducts($conn);
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="dashboard-container">
        <h2>Manage Products</h2>
        <table>
            <tr>
                <th>Name</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Category</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($products as $product) { ?>
            <tr>
                <td><?php echo htmlspecialchars($product['name']); ?></td>
                <td><?php echo htmlspecialchars($product['price']); ?></td>
                <td><?php echo htmlspecialchars($product['stock']); ?></td>
                <td><?php echo htmlspecialchars($product['categorie']); ?></td>
                <td>
                    <form action="" method="post" style="display:inline;">
                        <input type="hidden" name="delete_product_id" value="<?php echo $product['id']; ?>">
                        <button type="submit">Delete</button>
                    </form>
                    <button onclick="document.getElementById('editForm<?php echo $product['id']; ?>').style.display='block'">Edit</button>
                </td>
            </tr>
            <tr id="editForm<?php echo $product['id']; ?>" style="display:none;">
                <td colspan="5">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <input type="hidden" name="update_prod_id" value="<?php echo $product['id']; ?>">
                        <input type="text" name="p_name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
                        <input type="text" name="p_price" value="<?php echo htmlspecialchars($product['price']); ?>" required>
                        <input type="text" name="p_image" value="<?php echo htmlspecialchars($product['image']); ?>" required>
                        <input type="text" name="p_stock" value="<?php echo htmlspecialchars($product['stock']); ?>" required>
                        <input type="text" name="p_category" value="<?php echo htmlspecialchars($product['categorie']); ?>" required>
                        <button type="submit">Update</button>
                    </form>
                </td>
            </tr>
            <?php } ?>
        </table>
        <h3>Add New Product</h3>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="text" name="p_name" placeholder="Product Name" required>
            <input type="text" name="p_price" placeholder="Price" required>
            <input type="text" name="p_image" placeholder="Image URL" required>
            <input type="text" name="p_stock" placeholder="Stock" required>
            <input type="text" name="p_category" placeholder="Category" required>
            <button type="submit" name="add_product">Add Product</button>
        </form>
        <a href="dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>
