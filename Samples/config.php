<?php
mysql_connect("localhost","root","");
mysql_select_db("bayanione_db");

define("SITE_URL","http://" . $_SERVER['SERVER_NAME']."/BayaniOne Web");
session_start();
?>
