<?php

include '../components/connect.php';

session_start();

if(isset($_POST['submit'])){
    
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);

   $select_admin = $conn->prepare("SELECT * FROM admins WHERE name = ? AND password = ?");
   $select_admin->bindParam(1, $name);
   $select_admin->bindParam(2, $pass);
   $select_admin->execute();
 

   if($select_admin->rowCount() > 0){
      $fetch_admin_id = $select_admin->fetch(PDO::FETCH_ASSOC);
      $_SESSION['admin_id'] = $fetch_admin_id['id'];
      header('location:dashboard.php');
   }else{
      $message[] = 'incorrect  username or password';
   }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login</title>
  <!-- font awesome link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <!-- css file link -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>



<?php
if(isset($message)){
   foreach($message as $message){
      echo '<div class="message">
      <span>'.$message.'</span>
      <i class="fas fa-time" onclick="this.parentElement.remove();"></i>
   </div>';
   }
}
?>

<!-- admin login form start -->

<section class="form-container">
    <form action="" method="POST">
      <h3>Login now</h3>
      <p>default username = <span>Thant</span> & password = <span>11111</span></p>
      <input type="text" name="name" maxlength="20" required placeholder="Please Enter Your Username" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name ="pass" maxlength="20" require placeholder="Please Enter Your Password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="Login now" name="submit" class="btn">
      <a href="../user_login.php" class="option-btn">Login as User?</a>
</form>
</section>   
</body>
</html>