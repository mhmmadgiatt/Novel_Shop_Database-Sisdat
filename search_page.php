<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

if(isset($_POST['add_to_cart'])){

   $novel_nama = $_POST['novel_nama'];
   $novel_harga = $_POST['novel_harga'];
   $novel_gambar = $_POST['novel_gambar'];
   $novel_jumlah = $_POST['novel_jumlah'];

   $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `keranjang` WHERE nama = '$novel_nama' AND user_id = '$user_id'") or die('query failed');

   if(mysqli_num_rows($check_cart_numbers) > 0){
      $message[] = 'Sudah ditambahkan ke keranjang!';
   }else{
      mysqli_query($conn, "INSERT INTO `keranjang`(user_id, nama, harga, jumlah, gambar) VALUES('$user_id', '$novel_nama', '$novel_harga', '$novel_jumlah', '$novel_gambar')") or die('query failed');
      $message[] = 'novel ditambahkan ke keranjang!';
   }

};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>search page</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>Cari novel</h3>
   <p> <a href="home.php">home</a> / search </p>
</div>

<section class="search-form">
   <form action="" method="post">
      <input type="text" name="search" placeholder="Cari novel..." class="box">
      <input type="submit" name="submit" value="cari" class="btn">
   </form>
</section>

<section class="products" style="padding-top: 0;">

   <div class="box-container">
   <?php
      if(isset($_POST['submit'])){
         $search_item = $_POST['search'];
         $select_products = mysqli_query($conn, "SELECT * FROM `novel` WHERE nama LIKE '%{$search_item}%'") or die('query failed');
         if(mysqli_num_rows($select_products) > 0){
         while($fetch_product = mysqli_fetch_assoc($select_products)){
   ?>
   <form action="" method="post" class="box">
      <img src="uploaded_img/<?php echo $fetch_product['gambar']; ?>" alt="" class="image">
      <div class="name"><?php echo $fetch_product['nama']; ?></div>
      <div class="price">$<?php echo $fetch_product['harga']; ?>/-</div>
      <input type="number"  class="qty" name="novel_jumlah" min="1" value="1">
      <input type="hidden" name="novel_nama" value="<?php echo $fetch_product['nama']; ?>">
      <input type="hidden" name="novel_harga" value="<?php echo $fetch_product['harga']; ?>">
      <input type="hidden" name="novel_gambar" value="<?php echo $fetch_product['gambar']; ?>">
      <input type="submit" class="btn" value="add to cart" name="add_to_cart">
   </form>
   <?php
            }
         }else{
            echo '<p class="empty">Hasil tidak ditemukan!</p>';
         }
      }else{
         echo '<p class="empty">Cari novel menarik!</p>';
      }
   ?>
   </div>
  

</section>









<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>