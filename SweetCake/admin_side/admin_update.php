<?php

@include 'config.php';

$id = $_GET['edit'];

if(isset($_POST['update_cake'])){

   $cake_name = $_POST['cake_name'];
   $cake_ingredients = $_POST['cake_ingredients'];
   $cake_image = $_FILES['cake_image']['name'];
   $cake_image_tmp_name = $_FILES['cake_image']['tmp_name'];
   $cake_image_folder = 'uploaded_img/'.$cake_image;

   if(empty($cake_name) || empty($cake_ingredients) || empty($cake_image)){
      $message[] = 'please fill out all!';    
   }else{

      $update_data = "UPDATE cakes SET name='$cake_name', ingredients='$cake_ingredients', image='$cake_image'  WHERE id = '$id'";
      $upload = mysqli_query($conn, $update_data);

      if($upload){
         move_uploaded_file($cake_image_tmp_name, $cake_image_folder);
         header('location:admin_page.php');
      }else{
         $$message[] = 'please fill out all!'; 
      }

   }
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php
   if(isset($message)){
      foreach($message as $message){
         echo '<span class="message">'.$message.'</span>';
      }
   }
?>

<div class="container">


<div class="admin-cake-form-container centered">

   <?php
      
      $select = mysqli_query($conn, "SELECT * FROM cakes WHERE id = '$id'");
      while($row = mysqli_fetch_assoc($select)){

   ?>
   
   <form action="" method="post" enctype="multipart/form-data">
      <h3 class="title">update the cake</h3>
      <input type="text" class="box" name="cake_name" value="<?php echo $row['name']; ?>" placeholder="enter the cake name">
      <input type="text" class="box" name="cake_ingredients" value="<?php echo $row['ingredients']; ?>" placeholder="enter the cake ingredients">
      <input type="file" class="box" name="cake_image"  accept="image/png, image/jpeg, image/jpg">
      <input type="submit" value="update cake" name="update_cake" class="btn">
      <a href="admin_page.php" class="btn">go back!</a>
   </form>
   


   <?php }; ?>

   

</div>

</div>

</body>
</html>