<?php
include 'config-1.php';
include 'PHPMailer/src/PHPMailer.php';
include 'PHPMailer/src/SMTP.php';
include 'PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

session_start();


if (!isset($_SESSION['user_id'])) {
   header('location: login-1.php');
   exit;
}
$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login-1.php');
};

if (isset($_GET['logout'])) {
   // Update is_verified to 0 for the logged-out user
   mysqli_query($conn, "UPDATE `user_form` SET is_verified = 0 WHERE id = '$user_id'") or die('query failed');

   unset($user_id);
   session_destroy();
   header('location:login-1.php');
}


if (isset($_POST['add_to_cart'])) {
   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_quantity = $_POST['product_quantity'];

   // Check if the product is already in the cart
   $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

   if (mysqli_num_rows($select_cart) > 0) {
       $message[] = 'Product already added to cart!';
   } else {
       // Check if there is enough stock for the product
       $select_product = mysqli_query($conn, "SELECT * FROM `produse` WHERE name = '$product_name'") or die('query failed');
       $fetch_product = mysqli_fetch_assoc($select_product);

       if ($fetch_product['stock'] >= $product_quantity) {
           // Insert the product into the cart
           mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, image, quantity) VALUES('$user_id', '$product_name', '$product_price', '$product_image', '$product_quantity')") or die('query failed');

           // Decrease the stock for the product
           $new_stock = $fetch_product['stock'] - $product_quantity;
           mysqli_query($conn, "UPDATE `produse` SET stock = '$new_stock' WHERE name = '$product_name'") or die('query failed');

           $message[] = 'Product added to cart!';
       } else {
           $message[] = 'Insufficient stock for the selected quantity!';
       }
   }
}


if(isset($_POST['update_cart'])){
   $update_quantity = $_POST['cart_quantity'];
   $update_id = $_POST['cart_id'];
   mysqli_query($conn, "UPDATE `cart` SET quantity = '$update_quantity' WHERE id = '$update_id'") or die('query failed');
   $message[] = 'cart quantity updated successfully!';
}

if(isset($_GET['remove'])){
   $remove_id = $_GET['remove'];
   mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$remove_id'") or die('query failed');
   header('location:shoping cart.php');
}
  
if(isset($_GET['delete_all'])){
   mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
   header('location:shoping cart.php');
   sendOrderConfirmationEmail($user_id, $conn);
}
function sendOrderConfirmationEmail($user_id, $conn) {
   $to = 'recipient@example.com';  // Replace with the actual recipient email address
   $subject = 'Order Confirmation';

   // Fetch cart items for the user
   $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
   $products = '';

   while ($fetch_cart = mysqli_fetch_assoc($cart_query)) {
       $products .= $fetch_cart['name'] . ' - Quantity: ' . $fetch_cart['quantity'] . "\n";
   }

   // Calculate estimated delivery time (you can adjust this logic based on your business rules)
   $estimatedDeliveryTime = date('Y-m-d H:i:s', strtotime('+2 days')); // Example: Deliver within 2 days

   // Email body
   $message = "Thank you for your order!\n\n";
   $message .= "Products in your order:\n" . $products . "\n";
   $message .= "Estimated delivery time: " . $estimatedDeliveryTime . "\n\n";
   $message .= "Thank you for shopping with us!";

   // Create a new PHPMailer instance
   $mail = new PHPMailer(true);

   try {
       //Server settings
       $mail->isSMTP();
      $mail->Host = 'smtp.gmail.com'; 
      $mail->SMTPAuth = true;
      $mail->Username = 'alexandrescudan19@gmail.com';
      $mail->Password = 'djmr qktm ouik zhes';
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
      $mail->Port = 587;

       //Recipients
       $mail->setFrom('your_sender_email@example.com');  // Replace with your sender email
       $mail->addAddress($to);

       //Content
       $mail->isHTML(false);
       $mail->Subject = $subject;
       $mail->Body = $message;

       // Send the email
       $mail->send();
       echo 'Email has been sent.';
   } catch (Exception $e) {
       echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>shopping cart</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
   <link rel="stylesheet" type="text/css" href="css/style.css">
   <link rel="stylesheet" type="text/css" href="css/scrollbar.css">




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

<div class="container">

<div class="user-profile">

   <?php
      $select_user = mysqli_query($conn, "SELECT * FROM `user_form` WHERE id = '$user_id'") or die('query failed');
      if(mysqli_num_rows($select_user) > 0){
         $fetch_user = mysqli_fetch_assoc($select_user);
      };
   ?>

   <p> username : <span><?php echo $fetch_user['name']; ?></span> </p>
   <p> email : <span><?php echo $fetch_user['email']; ?></span> </p>
   <div class="flex">
      <a href="login-1.php" class="btn">login</a>
      <a href="register-1.php" class="option-btn">register</a>
      <a href="shoping cart.php?logout=<?php echo $user_id; ?>" onclick="return confirm('are your sure you want to logout?');" class="delete-btn">logout</a>
   </div>

</div>

<div class="shopping-cart">

   <h1 class="heading">shopping<span> cart</span></h1>

   <table>
      <thead>
         <th>image</th>
         <th>name</th>
         <th>price</th>
         <th>quantity</th>
         <th>total price</th>
         <th>action</th>
      </thead>
      <tbody>
      <?php
         $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
         $grand_total = 0;
         if(mysqli_num_rows($cart_query) > 0){
            while($fetch_cart = mysqli_fetch_assoc($cart_query)){
      ?>
         <tr>
            <td><img src="<?php echo $fetch_cart['image']; ?>" height="100"  alt=""></td>
            <td><?php echo $fetch_cart['name']; ?></td>
            <td><?php echo $fetch_cart['price']; ?>Lei</td>
            <td>
               <form action="" method="post">
                  <input type="hidden" name="cart_id" value="<?php echo $fetch_cart['id']; ?>">
                  <input type="number" min="1" name="cart_quantity" value="<?php echo $fetch_cart['quantity']; ?>">
                  <input type="submit" name="update_cart" value="update" class="option-btn">
               </form>
            </td>
            <td><?php echo $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']); ?>Lei</td>
            <td><a href="shoping cart.php?remove=<?php echo $fetch_cart['id']; ?>" class="delete-btn" onclick="return confirm('remove item from cart?');">remove</a></td>
         </tr>
      <?php
         $grand_total += $sub_total;
            }
         }else{
            echo '<tr><td style="padding:20px; text-transform:capitalize;" colspan="6">no item added</td></tr>';
         }
      ?>
      <tr class="table-bottom">
         <td colspan="4">grand total :</td>
         <td><?php echo $grand_total; ?>Lei </td>
         <td><a href="shoping cart.php?delete_all" onclick="return confirm('delete all from cart?');" class="delete-btn <?php echo ($grand_total > 1)?'':'disabled'; ?>">delete all</a></td>
      </tr>
   </tbody>
   </table>

   <div class="cart-btn">  
      <a href="orders.php" class="btn <?php echo ($grand_total > 1)?'':'disabled'; ?>">proceed to checkout</a>
   </div>

   </div>

</div>

</body>
</html>