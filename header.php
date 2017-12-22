<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<?php
    //code to verify user login
    session_start();
    if(!isset($_SESSION["username"])){
        header("location:index.php");
    }
?>

<html xmlns="http://www.w3.org/1999/xhtml"runat="server">
<head >
    <title>BayaniOne</title>
</head>
