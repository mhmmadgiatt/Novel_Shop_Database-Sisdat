<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['add_to_cart'])){

   $film_nama = $_POST['film_nama'];
   $film_harga = $_POST['film_harga'];
   $film_gambar = $_POST['film_gambar'];
   $film_jumlah = $_POST['film_jumlah'];

   $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `keranjang` WHERE nama = '$film_nama' AND user_id = '$user_id'") or die('query failed');

   if(mysqli_num_rows($check_cart_numbers) > 0){
      $message[] = 'Sudah ditambahkan ke keranjang!';
   }else{
      mysqli_query($conn, "INSERT INTO `keranjang`(user_id, nama, harga, jumlah, gambar) VALUES('$user_id', '$film_nama', '$film_harga', '$film_jumlah', '$film_gambar')") or die('query failed');
      $message[] = 'Film ditambahkan ke keranjang!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>home</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<section class="home">

   <div class="content">
      <h3>NIKMATI SENJAMU DENGAN FILM.</h3>
      <p>Website ini berisi tentang film-film terbaik yang sudah lulus sensor.</p>
   </div>

</section>

<section class="products">

   <h1 class="title">Film yang tersedia</h1>

   <div class="box-container">

      <?php  
         $select_film = mysqli_query($conn, "SELECT * FROM `film`") or die('query failed');
         if(mysqli_num_rows($select_film) > 0){
            while($fetch_film = mysqli_fetch_assoc($select_film)){
      ?>
     <form action="" method="post" class="box">
      <img class="image" src="uploaded_img/<?php echo $fetch_film['gambar']; ?>" alt="">
      <div class="name"><?php echo $fetch_film['nama']; ?></div>
      <div class="price">$<?php echo $fetch_film['harga']; ?>/-</div>
      <input type="number" min="1" name="film_jumlah" value="1" class="qty">
      <input type="hidden" name="film_nama" value="<?php echo $fetch_film['nama']; ?>">
      <input type="hidden" name="film_harga" value="<?php echo $fetch_film['harga']; ?>">
      <input type="hidden" name="film_gambar" value="<?php echo $fetch_film['gambar']; ?>">
      <input type="submit" value="masukkan ke keranjang" name="add_to_cart" class="btn">
     </form>
      <?php
         }
      }else{
         echo '<p class="empty">Yahh, belum ada film yang dijual</p>';
      }
      ?>
   </div>

</section>

<section class="home-contact">

   <div class="content">
      <h3>Apakah kamu memiliki pertanyaan?</h3>
      <p>Jika kalian memiliki kendala, silahkan hubungi kami dengan memencet tombol dibawah!</p>
      <a href="about.php" class="white-btn">kontak kami</a>
   </div>

</section>





<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>