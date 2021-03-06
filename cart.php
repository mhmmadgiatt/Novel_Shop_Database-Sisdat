<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['update_keranjang'])){
   $cart_id = $_POST['keranjang_id'];
   $cart_quantity = $_POST['keranjang_jumlah'];
   mysqli_query($conn, "UPDATE `keranjang` SET jumlah = '$cart_quantity' WHERE id = '$cart_id'") or die('query failed');
   $message[] = 'Jumlah keranjang diperbarui!';
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `keranjang` WHERE id = '$delete_id'") or die('query failed');
   header('location:cart.php');
}

if(isset($_GET['delete_all'])){
   mysqli_query($conn, "DELETE FROM `keranjang` WHERE user_id = '$user_id'") or die('query failed');
   header('location:cart.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>cart</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>Keranjang Belanja</h3>
   <p> <a href="home.php">home</a> / keranjang </p>
</div>

<section class="shopping-cart">

   <h1 class="title">novel ditambah</h1>

   <div class="box-container">
      <?php
         $grand_total = 0;
         $select_cart = mysqli_query($conn, "SELECT * FROM `keranjang` WHERE user_id = '$user_id'") or die('query failed');
         if(mysqli_num_rows($select_cart) > 0){
            while($fetch_cart = mysqli_fetch_assoc($select_cart)){   
      ?>
      <div class="box">
         <a href="cart.php?delete=<?php echo $fetch_cart['id']; ?>" class="fas fa-times" onclick="return confirm('delete this from keranjang?');"></a>
         <img src="uploaded_img/<?php echo $fetch_cart['gambar']; ?>" alt="">
         <div class="name"><?php echo $fetch_cart['nama']; ?></div>
         <div class="price">Rp.<?php echo $fetch_cart['harga']; ?></div>
         <form action="" method="post">
            <input type="hidden" name="keranjang_id" value="<?php echo $fetch_cart['id']; ?>">
            <input type="number" min="1" name="keranjang_jumlah" value="<?php echo $fetch_cart['jumlah']; ?>">
            <input type="submit" name="update_keranjang" value="update" class="option-btn">
         </form>
         <div class="sub-total"> sub total : <span>Rp.<?php echo $sub_total = ($fetch_cart['jumlah'] * $fetch_cart['harga']); ?></span> </div>
      </div>
      <?php
      $grand_total += $sub_total;
         }
      }else{
         echo '<p class="empty">Keranjang kamu masih kosong</p>';
      }
      ?>
   </div>

   <div style="margin-top: 2rem; text-align:center;">
      <a href="cart.php?delete_all" class="delete-btn <?php echo ($grand_total > 1)?'':'disabled'; ?>" onclick="return confirm('Yakin hapus dari keranjang?');">Hapus Semua </a>
   </div>

   <div class="cart-total">
      <p>Hasil Akhir : <span>Rp.<?php echo $grand_total; ?></span></p>
      <div class="flex">
         <a href="home.php" class="option-btn">Tambah novel lain</a>
         <a href="checkout.php" class="btn <?php echo ($grand_total > 1)?'':'disabled'; ?>">Proses untuk checkout</a>
      </div>
   </div>

</section>








<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>