<?php

include 'config-2.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>GadgetHub</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" type="text/css" href="css/style-0.css">
    <link rel="stylesheet" type="text/css" href="css/scrollbar.css">

</head>
<body>

<!-- header section starts  -->

<?php
include 'components/header.php';
?>


<section class="product" id="product">

    <h1 class="heading">Smart<span>Wear</span></h1>

    <div class="box-container">
        <?php
        include "p.smartwear.php";
        ?>
</div>
</section>

<?php
include 'components/footer.php';
?>

</body>
</html>