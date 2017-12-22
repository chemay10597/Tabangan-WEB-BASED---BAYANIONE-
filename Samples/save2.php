<?php
    session_start();
    if(isset($_SESSION["username"])){
        header('location:home.php');
    }
?>

<html>
  <head>
    <title>Sign In</title>

  </head>
  <body>
     <p><a href="registration.php">Register</a> | <a href="signin.php">Sign In</a></p>
     <h3>Login Form</h3>
     <form action="" method="POST">
       <table>
         <tr>
           <td>
           <label>Username:</label>
           </td>
           <td>
           <input type="text" name="username">
           </td>
         </tr>
         <tr>
           <td>
           <label>Password:</label>
           </td>
          <td>
           <input type="password" name="password">
          </td>
        </tr>
      </table>
      </br>
       <input type="submit" value="Login" name="submit" />
     </form>
  <?php
  if(isset($_POST["submit"]))
  {
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
      header("Location: home.php");
      }
      } else {
      echo "username and password does not match!";
      }

  } else {
      echo "All fields are required!";
    }
  }
  ?>
  </body>
</html>
