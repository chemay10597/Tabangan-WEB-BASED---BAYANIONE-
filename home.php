<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
    include_once("header.php");
    //session_start();
    if(!isset($_SESSION["username"])){
        header("location:index.php");
    } else {
?>

  <body style="margin:0;">
      <?php include_once("homenav.php");?>
  </body>
</html>
<?php
}
?>
