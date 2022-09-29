<?php

@include 'config.php';

if(isset($_POST['add_cake'])){

   $cake_name = $_POST['cake_name'];
   $cake_ingredients = $_POST['cake_ingredients'];
   $recipesteps = $_POST['recipesteps'];

   $cake_image = $_FILES['cake_image']['name'];
   $cake_image_tmp_name = $_FILES['cake_image']['tmp_name'];
   $cake_image_folder = 'uploaded_img/'.$cake_image;

   if(empty($cake_name) || empty($cake_ingredients) ||empty($recipesteps)|| empty($cake_image)){
      $message[] = 'please fill out all';
   }else{
      $insert = "INSERT INTO cakes(name, ingredients,recipesteps, image) VALUES('$cake_name', '$cake_ingredients','$recipesteps', '$cake_image')";
      $upload = mysqli_query($conn,$insert);
      if($upload){
         move_uploaded_file($cake_image_tmp_name, $cake_image_folder);
         $message[] = 'new cake added successfully';
      }else{
         $message[] = 'could not add the cake';
      }
   }

};

if(isset($_GET['delete'])){
   $id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM cakes WHERE id = $id");
   header('location:admin_page.php');
};

?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>admin page</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

   <!-- custom css file link  -->
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

   <div class="admin-cake-form-container">

      <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
         <h3>add a new cake</h3>
         <input type="text" placeholder="enter cake name" name="cake_name" class="box">
         <input type="text" placeholder="enter cake ingredients" name="cake_ingredients" class="box">
         <input type="text" placeholder="enter recipe steps" name="recipesteps" class="box">
         <input type="file" accept="image/png, image/jpeg, image/jpg" name="cake_image" class="box">
         <input type="submit" class="btn" name="add_cake" value="add cake">
      </form>

   </div>

   <?php

   $select = mysqli_query($conn, "SELECT * FROM cakes");
   
   ?>

   
   <div class="cake-display">
      <table class="cake-display-table">
         <thead>
         <tr>
            <th>cake image</th>
            <th>cake name</th>
            <th>cake ingredients</th>
            <th>recipesteps</th>
            <th>action</th>
         </tr>
         </thead>
         <?php while($row = mysqli_fetch_assoc($select)){ ?>
         <tr>
            <td><img src="uploaded_img/<?php echo $row['image']; ?>" height="100" alt=""></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['ingredients']; ?></td>
            <td><?php echo $row['recipesteps']; ?></td>
            <td>
               <a href="admin_update.php?edit=<?php echo $row['id']; ?>" class="btn"> <i class="fas fa-edit"></i> edit </a>
               <a href="admin_page.php?delete=<?php echo $row['id']; ?>" class="btn"> <i class="fas fa-trash"></i> delete </a>
            </td>
         </tr>
      <?php } ?>
      </table>
   </div>

</div>


</body>
</html>