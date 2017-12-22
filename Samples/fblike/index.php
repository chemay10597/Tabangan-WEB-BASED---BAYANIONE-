<?php
include_once("header.php");

if(isset($_SESSION['username']) && $_SESSION['username'] != ""){
    header("location:wall.php");
}

if(isset($_POST['submit']) && $_POST['submit'] == "Login"){
  if(!empty($_POST['username']) && !empty($_POST['password']))
             {
                 $username=$_POST['username'];
                 $password=$_POST['password'];
                 $connect=mysqli_connect('localhost','root','','bayanione_db') or die(mysqli_error());
                 $result=mysqli_query($connect, "SELECT username, password FROM users WHERE username='".$username."' AND password='".$password."'");
                 $numrows=mysqli_num_rows($result);
                 if($numrows!=0)
                 {
                   while($row=mysqli_fetch_assoc($result))
                 {
                 $dbusername=$row['username'];
                 $dbpassword=$row['password'];
                 }

                 if($username == $dbusername && $password == $dbpassword)
                 {
                   session_start();
                   $_SESSION['username']=$username;

                   /* Redirect browser */
                   header("Location: wall.php");
                 }
                 } else {
                   echo "username and password does not match!";
                 }

             } else {
                 echo "All fields are required!";
               }
            }
            ?>
<div class="wrapper">
    <div class="middle_box">
      <form action="" method="POST">
              <ul class="nav navbar-nav navbar-right">
                <li><input style="border: 2px solid red;border-radius: 4px;" type="text" name="username"></li>
                <li><input style="border: 2px solid red;border-radius: 4px;" type="password" name="password"></li>
                <li><input class="btn-signup" type="submit" value="Login" name="submit" /></li>
              </ul>
      </form>
    </div>
    <div class="clear"></div>
</div>
<div class="clear"></div>
<?php
include_once("footer.php");
?>
