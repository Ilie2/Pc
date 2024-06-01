<?php
include 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalii Produs</title>
    <style>

        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .product-details {
            text-align: center;
        }

        img {
            max-width: 100%;
            height: auto;
        }

        .comment, .comment-form {
            margin-top: 20px;
        }

        .author {
            font-style: italic;
        }

        .comment-form form {
            display: grid;
            gap: 10px;
        }

        label {
            display: block;
        }

        input, textarea {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            cursor: pointer;
        }
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Leaf PC</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" type="text/css" href="css/style-0.css">
    <link rel="stylesheet" type="text/css" href="css/scrollbar.css">

</head>
<body>
<?php
    include 'components/header.php';
    ?>
<div class="container">
    <?php
    include 'db.php';
    
    if (isset($_POST['product_id'])) {
        $product_id = $_POST['product_id'];
    
        // Get product details from the database
        $sql_product = "SELECT * FROM produse WHERE id = ?";
        $stmt_product = $conn->prepare($sql_product);
    
        if (!$stmt_product) {
            die("Prepare failed: " . $conn->error);
        }
    
        $stmt_product->bind_param("i", $product_id);
        $stmt_product->execute();
        $result_product = $stmt_product->get_result();
    
        if (!$result_product) {
            die("Query failed: " . $stmt_product->error);
        }
    
        if ($result_product->num_rows > 0) {
            $row_product = $result_product->fetch_assoc();
    
            echo '<div class="product-details">';
            echo '<h2>' . $row_product['name'] . '</h2>';
            echo '<p>Preț: ' . $row_product['price'] . ' RON</p>';
            echo '<img src="' . $row_product['image'] . '" alt="' . $row_product['name'] . '" width="300">';
            echo '</div>';
    
            // Display comments for this product
            $sql_comments = "SELECT * FROM comment_1 WHERE product_id = ?";
            $stmt_comments = $conn->prepare($sql_comments);
    
            if (!$stmt_comments) {
                die("Prepare failed: " . $conn->error);
            }
    
            $stmt_comments->bind_param("i", $product_id);
            $stmt_comments->execute();
            $result_comments = $stmt_comments->get_result();
    
            if (!$result_comments) {
                die("Query failed: " . $stmt_comments->error);
            }
    
            if ($result_comments->num_rows > 0) {
                echo '<h3>Comentarii:</h3>';
                while ($row_comment = $result_comments->fetch_assoc()) {
                    echo '<div class="comment">';
                    echo '<p>' . $row_comment['comment_content'] . '</p>';
                    echo '<p class="author">Scris de: ' . $row_comment['comment_author'] . '</p>';
                    echo '</div>';
                }
            } else {
                echo '<p>Niciun comentariu încă.</p>';
            }
    
            // Add a form for adding comments
            echo '<div class="comment-form">';
            echo '<h3>Adaugă un comentariu:</h3>';
            echo '<form action="add_comment.php" method="post">';
            echo '<input type="hidden" name="product_id" value="' . $product_id . '">';
            echo '<label for="author">Nume:</label>';
            echo '<input type="text" name="author" required>';
            echo '<label for="comment">Comentariu:</label>';
            echo '<textarea name="comment" rows="4" required></textarea>';
            echo '<input type="submit" value="Trimite">';
            echo '</form>';
            echo '</div>';
        } else {
            echo '<p>Produsul nu a fost găsit.</p>';
        }
    
        // Close the database connection
        $stmt_product->close();
        $stmt_comments->close();
    } else {
        echo '<p>Id-ul produsului lipsește sau este invalid.</p>';
    }
    $conn->close();
    ?>
    
    ?>
</div>

</body>
</html>



