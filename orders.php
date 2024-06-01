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

if (!isset($user_id)) {
   header('location: login-1.php');
   exit;
}

if (isset($_GET['logout'])) {
   // Update is_verified to 0 for the logged-out user
   mysqli_query($conn, "UPDATE `user_form` SET is_verified = 0 WHERE id = '$user_id'") or die('query failed');

   unset($user_id);
   session_destroy();
   header('location: login-1.php');
   exit;
}

if (isset($_POST['add_to_cart'])) {
   $product_id = $_POST['product_id'];
   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_quantity = $_POST['product_quantity'];

   // Check if the product is already in the cart
   $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE product_id = '$product_id' AND user_id = '$user_id'") or die('query failed');

   if (mysqli_num_rows($select_cart) > 0) {
       $message[] = 'Product already added to cart!';
   } else {
       // Check if there is enough stock for the product
       $select_product = mysqli_query($conn, "SELECT * FROM `produse` WHERE id = '$product_id'") or die('query failed');
       $fetch_product = mysqli_fetch_assoc($select_product);

       if ($fetch_product['stock'] >= $product_quantity) {
           // Insert the product into the cart
           mysqli_query($conn, "INSERT INTO `cart`(user_id, product_id, name, price, image, quantity) VALUES('$user_id', '$product_id', '$product_name', '$product_price', '$product_image', '$product_quantity')") or die('query failed');

           // Decrease the stock for the product
           $new_stock = $fetch_product['stock'] - $product_quantity;
           mysqli_query($conn, "UPDATE `produse` SET stock = '$new_stock' WHERE id = '$product_id'") or die('query failed');

           $message[] = 'Product added to cart!';
       } else {
           $message[] = 'Insufficient stock for the selected quantity!';
       }
   }
}

// Funcția pentru trimiterea emailului de confirmare a comenzii
function sendOrderConfirmationEmail($user_id, $conn) {
   $to = 'recipient@example.com';  // Adresa de email a destinatarului - înlocuiește cu adresa reală
   $subject = 'Order Confirmation';

   // Se preiau elementele din coș pentru utilizator
   $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
   $products = '';

   while ($fetch_cart = mysqli_fetch_assoc($cart_query)) {
       $products .= $fetch_cart['name'] . ' - Quantity: ' . $fetch_cart['quantity'] . "\n";
   }

   // Se calculează timpul estimat de livrare (poți ajusta această logică în funcție de regulile afacerii tale)
   $estimatedDeliveryTime = date('Y-m-d H:i:s', strtotime('+2 days')); // Exemplu: Livrare în termen de 2 zile

   // Corpul emailului
   $message = "Thank you for your order!\n\n";
   $message .= "Products in your order:\n" . $products . "\n";
   $message .= "Estimated delivery time: " . $estimatedDeliveryTime . "\n\n";
   $message .= "Thank you for shopping with us!";

   // Se creează o nouă instanță PHPMailer
   $mail = new PHPMailer(true);

   try {
       // Setări server
       $mail->isSMTP();
       $mail->Host = 'smtp.gmail.com'; 
       $mail->SMTPAuth = true;
       $mail->Username = 'alexandrescudan19@gmail.com'; // Adresa de email a expeditorului - înlocuiește cu adresa ta reală
       $mail->Password = 'djmr qktm ouik zhes'; // Parola de autentificare a expeditorului - înlocuiește cu parola reală
       $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
       $mail->Port = 587;

       // Destinatari
       $mail->setFrom('your_sender_email@example.com');  // Adresa ta de email - înlocuiește cu adresa ta reală
       $mail->addAddress($to);

       // Conținut
       $mail->isHTML(false);
       $mail->Subject = $subject;
       $mail->Body = $message;

       // Se trimite emailul
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
   <title>orders</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style-0.css">
   <link rel="stylesheet" type="text/css" href="css/scrollbar.css">

</head>
<body>
   
<?php include 'components/header.php'; ?>

<section class="checkout-orders">

   <form action="" method="POST">

   <h3>your orders</h3>

      <div class="display-orders">
      <?php
         $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
         $grand_total = 0;
         $cart_items[] = '';
         if(mysqli_num_rows($cart_query) > 0){
            while($fetch_cart = $fetch_cart = mysqli_fetch_assoc($cart_query)){
               $cart_items[] = $fetch_cart['name'].' ('.$fetch_cart['price'].' x '. $fetch_cart['quantity'].') - ';
               $total_products = implode($cart_items);
               $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']);
      ?>
         <p> <?= $fetch_cart['name']; ?> <span>(<?= $fetch_cart['price'].' Lei'.'/- x '. $fetch_cart['quantity']; ?>)</span> </p>
      <?php
            }
         }else{
            echo '<p class="empty">your cart is empty!</p>';
         }
      ?>
         <input type="hidden" name="total_products" value="<?= $total_products; ?>">
         <input type="hidden" name="total_price" value="<?= $grand_total; ?>" value="">
         <div class="grand-total">grand total : <span><?= $grand_total; ?> Lei</span></div>
      </div>

      <h3>place your orders</h3>

      <div class="flex">
         <div class="inputBox">
            <span>your name :</span>
            <input type="text" name="name" placeholder="enter your name" class="box" maxlength="20" required>
         </div>
         <div class="inputBox">
            <span>your number :</span>
            <input type="number" name="number" placeholder="enter your number" class="box" min="0" max="9999999999" onkeypress="if(this.value.length == 10) return false;" required>
         </div>
         <div class="inputBox">
            <span>your email :</span>
            <input type="email" name="email" placeholder="enter your email" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>payment method :</span>
            <select name="method" class="box" required>
               <option value="cash on delivery">cash on delivery</option>
               <option value="credit card">credit card</option>
               <option value="paypal">paypal</option>
            </select>
         </div>
         <div class="inputBox">
            <span>number of the street:</span>
            <input type="text" name="flat" placeholder="e.g. flat number" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>street :</span>
            <input type="text" name="street" placeholder="e.g. street name" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>city :</span>
            <input type="text" name="city" placeholder="e.g. Timisoara" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>state :</span>
            <input type="text" name="state" placeholder="e.g. Timis" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>country :</span>
            <input type="text" name="country" placeholder="e.g. Romania" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>pin code :</span>
            <input type="number" min="0" name="pin_code" placeholder="e.g. 123456" min="0" max="999999" onkeypress="if(this.value.length == 6) return false;" class="box" required>
         </div>
      </div>

      <input type="submit" name="order" class="btn <?= ($grand_total > 1)?'':'disabled'; ?>" value="place order">

   </form>

</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
