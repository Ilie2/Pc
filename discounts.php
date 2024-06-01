<?php
   $select_product = mysqli_query($conn, "SELECT * FROM `discounts`") or die('query failed');
   if(mysqli_num_rows($select_product) > 0){
      while($fetch_product = mysqli_fetch_assoc($select_product)){

?>
<div class="box">
   <?php
      $discountnr=$fetch_product['price'];
      $discountnr2=$discountnr;
      $discountper=$fetch_product['discountper'];
      $discountperf=$discountnr;
      $discountperf=($discountper*$discountnr)/100;
      $discountnr2-=$discountperf;
      ?>
   <span class="discount">-<?php echo $discountper?>%</span>
   <form method="post" action="">
         <img src="<?php echo $fetch_product['image']; ?>" alt="">
         <h3><div class="name"><?php echo $fetch_product['name']; ?></div></h3>
         <div class="stars">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>
            </div>
         <div class="price"><?php echo $discountnr2?> Lei<span><?php echo $discountnr; ?> Lei</span></div>
      <div class="quantity">
         <span>quantity : </span>
         <input type="number" min="1" name="product_quantity" value="1">
      </div>
         <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
         <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
         <input type="hidden" name="product_price" value="<?php echo $discountnr2; ?>">
         <input type="submit" value="add to cart" name="add_to_cart" class="btn">
      </form>
      <form method="post" action="product.php">
         <input type="hidden" name="product_id" value="<?php echo $fetch_product['id']; ?>">
         <input type="submit" value="Detalii produs" name="view_product" class="btn">
      </form>
</div>
   
<?php
      };
};
?>

