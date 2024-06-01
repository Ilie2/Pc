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
    <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title>FAQ</title>
  <style>
   

    h1 {
      margin: 0;
    }

    section.category {
      background-color: #fff;
      margin: 20px;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h2 {
      color:green;
    }

    ul {
      list-style-type: none;
      padding: 0;
    }

    li {
      margin-bottom: 20px;
      border-bottom: 1px solid #eee;
      padding-bottom: 10px;
    }

    h3 {
      color: #333;
    }
  </style>

</head>
<body>

<!-- header section starts  -->

<?php
include 'components/header.php';
?>
  <?php
  // Simulare de date dintr-o bază de date
  $faqData = array(
    'Intrebari frecvente' => array(
      'Cum plasez o comandă?'=>'Pentru a plasa o comandă, navigați pe site, adăugați produsele dorite în coșul de cumpărături și urmați pașii de checkout.',
      'Care sunt opțiunile de livrare disponibile?'=>'Oferim optiuni de livrare doar delivery',
      'Ce metode de plată acceptați?'=>'Acceptăm plăți cash on delivery.',
      'Cum pot primi o factură pentru comanda mea?'=>'O copie a facturii dvs. va fi trimisă automat pe adresa de e-mail asociată cu contul dvs. după finalizarea comenzii.',
      'Care este politica de returnare a produselor?'=>'Avem o politică flexibilă de returnare în termen de 30 de zile.',
      'Ce se întâmplă dacă produsul meu este defect sau deteriorat?'=>'Vă rugăm să ne contactați imediat și vom rezolva problema prin înlocuirea produsului sau returnarea banilor.'


    ),
    // Alte categorii și întrebări aici
  );

  // Iterare prin categorii și întrebări
  foreach ($faqData as $category => $questions) {
    echo "<section class='category' id='" . strtolower(str_replace(' ', '-', $category)) . "'>";
    echo "<h2>$category</h2>";
    echo "<ul>";

    foreach ($questions as $question => $answer) {
      echo "<li>";
      echo "<h3>$question</h3>";
      echo "<p>$answer</p>";
      echo "</li>";
    }

    echo "</ul>";
    echo "</section>";
  }
  ?>



<?php
include 'components/footer.php';
?>

</body>
</html>