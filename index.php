<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<?php
    //code to check login user
    session_start();
    if(isset($_SESSION["username"])){
        header('location:home.php');
    }
?>

<html xmlns="http://www.w3.org/1999/xhtml">
  <head runat="server">
      <title>BayaniOne</title>
      <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans|Candal|Alegreya+Sans">
      <link rel="stylesheet" type="text/css" href="../fonts/font-awesome.min.css">
      <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
      <link rel="stylesheet" type="text/css" href="../css/style.css">
  </head>
  <body>
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
  		      <a class = "navbar-brand" href="index.php"><span><image src = "Images/logo.png" height= "30px" width="30px"></span><span>BayaniOne</span></a>
  		    </div>
          <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav navbar-right">
              <li>
                <form action="" method="POST">
                  <ul class="nav navbar-nav navbar-right">
                    <li><input class="form-control" style="border: 1px solid green;border-radius: 4px;" placeholder="username" type="text" name="username"></li>
                    <li>&nbsp;</li>
                    <li><input class="form-control" style="border: 1px solid green;border-radius: 4px;" placeholder="password" type="password" name="password"></li>
                    <li><input id="btnlogin" type="submit" value="Login" name="submit" /></li>
                  </ul>
                </form>
                <?php
                //code to validate and login users
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
              </li>
              <li><a></a></li>
              <li>
                  <li ><a class="btn-signup" href= "signup.php">Sign Up</a></li>
              </li>
            </ul>
          </div>
        </div>
    </nav>
    <div class="modal fade" id="login" role="dialog">
      <div class="modal-dialog modal-sm">
        <!-- Modal content no 1-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title text-center form-title">Login</h4>
          </div>
          <div class="modal-body padtrbl">
            <div class="login-box-body">
              <p class="login-box-msg">Sign in to start your session</p>
              <div class="form-group">
                <form name="" id="loginForm">
                 <div class="form-group has-feedback"> <!----- username -------------->
                      <input class="form-control" placeholder="Username"  id="loginid" type="text" autocomplete="off" />
                      <span style="display:none;font-weight:bold; position:absolute;color: red;position: absolute;padding:4px;font-size: 11px;background-color:rgba(128, 128, 128, 0.26);z-index: 17;  right: 27px; top: 5px;" id="span_loginid"></span><!---Alredy exists  ! -->
                      <span class="glyphicon glyphicon-user form-control-feedback"></span>
                  </div>
                  <div class="form-group has-feedback"><!----- password -------------->
                      <input class="form-control" placeholder="Password" id="loginpsw" type="password" autocomplete="off" />
                      <span style="display:none;font-weight:bold; position:absolute;color: grey;position: absolute;padding:4px;font-size: 11px;background-color:rgba(128, 128, 128, 0.26);z-index: 17;  right: 27px; top: 5px;" id="span_loginpsw"></span><!---Alredy exists  ! -->
                      <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                  </div>
                  <div class="row">
                      <div class="col-xs-12">
                          <div class="checkbox icheck">
                              <label>
                                <input type="checkbox" id="loginrem" > Remember Me
                              </label>
                          </div>
                      </div>
                      <div class="col-xs-12">
                          <button type="button" class="btn btn-green btn-block btn-flat" onclick="userlogin()">Login</button>
                      </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
    <!--/ Modal box-->
    <!--Banner-->
  <div class="banner">
    <div class="bg-color">
      <div class="container">
        <div class="row">
          <div class="banner-text text-center">
            <div class="text-border">
                <h2 class="text-dec">Welcome to BayaniOne</h2>
            </div>
            <div class="intro-para text-center quote">
                <p class="big-text">Together we can make things happen</p>
                 <p class="small-text">A person has two hands, one is for helping himself.<br>The other is for helping others. </p>
                <a href="#footer" class="btn get-quote">About Us</a>
            </div>
            <a href="#work-shop" class="mouse-hover"><div class="mouse"></div></a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <section id="work-shop" class="section-padding">

  <center>
    <div class="container">
      <div class="row">
        <div class="header-section text-center">
            <h2>Programs</h2>
            <p>The list below are the list of activities done by charities and group activities used to help people.<br></p>
            <hr class="bottom-line">
        </div>
          <div>
          <?php
            //code to diplays post comment, and insert comment for individual user
            $connect=mysqli_connect("localhost","root","","bayanione_db");
            // Check connection
            if (mysqli_connect_errno())
            {
              echo "Failed to connect to MySQL: " . mysqli_connect_error();
            }

            //code to display posts
            $result = mysqli_query($connect,"SELECT * FROM post INNER JOIN users ON post.user_id=users.user_id ");
            echo "<table style='width:100%;'>";
              echo "<tbody>";
                echo "<tr>";
            $i = 0;
            while($row = mysqli_fetch_assoc($result) AND $i<5)
            {
              $i++;
              $post_id=$row['post_id'];
              $user_id=$row['user_id'];


                      echo "<td>";
                            echo "<img src='Uploads/",$row['post_photo'],"' width='200' height='200' />";
                            echo "</br>";
                            echo $row['username'];
                            echo "</br>";
                            echo $row['post_description'];
                      echo "</td>";

            }
                echo "</tr>";
              echo "</tbody>";
            echo "</table>";
            mysqli_close($connect);
          ?>
        </div>
    </div>
  </section>
	    <!--/ work-shop-->
    <!--Faculity member-->
  <section id="faculity-member" class="section-padding">
    <div class="container">
      <div class="row">
        <div class="header-section text-center">
            <h2>Testimonies</h2>
            <p>Below are the list of testimonies of the users who have help by the system<br></p>
            <hr class="bottom-line">
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4">
          <div class="pm-staff-profile-container" >
            <div class="pm-staff-profile-image-wrapper text-center">
              <div class="pm-staff-profile-image">
                  <img src="../images/tes.jpg" alt="" class="img-thumbnail img-circle" />
              </div>
            </div>
            <div class="pm-staff-profile-details text-center">
                <p class="pm-staff-profile-name">Susan and Aurora</p>
                <p class="pm-staff-profile-title">Homeless Children</p>
                <p class="pm-staff-profile-bio">This two kids were so happy when they received a donation from a good samaritan.</p>
                <p>This two kids were so happy when they received a donation from a good samaritan.<br></p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4">
          <div class="pm-staff-profile-container" >
            <div class="pm-staff-profile-image-wrapper text-center">
              <div class="pm-staff-profile-image">
                  <img src="../images/mentor.jpg" alt="" class="img-thumbnail img-circle" />
              </div>
            </div>
            <div class="pm-staff-profile-details text-center">
                <p class="pm-staff-profile-name">Bryan Johnson</p>
                <p class="pm-staff-profile-title">Lead Software Engineer</p>

                <p class="pm-staff-profile-bio">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec et placerat dui. In posuere metus et elit placerat tristique. Maecenas eu est in sem ullamcorper tincidunt. </p>
            </div>
          </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4">
            <div class="pm-staff-profile-container" >
              <div class="pm-staff-profile-image-wrapper text-center">
                <div class="pm-staff-profile-image">
                    <img src="../images/mentor.jpg" alt="" class="img-thumbnail img-circle" />
                </div>
              </div>
              <div class="pm-staff-profile-details text-center">
                <p class="pm-staff-profile-name">Bryan Johnson</p>
                <p class="pm-staff-profile-title">Lead Software Engineer</p>

                <p class="pm-staff-profile-bio">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec et placerat dui. In posuere metus et elit placerat tristique. Maecenas eu est in sem ullamcorper tincidunt. </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</center>
    <!--/Testimonial-->
    <footer id="myFooter">
      <div class="container">
        <div class="row">
          <div class="col-sm-3 myCols">
              <h5>Get started</h5>
              <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="signup.php">Sign up</a></li>
                <li><a href="#">Downloads</a></li>
              </ul>
          </div>
            <div class="col-sm-3 myCols">
                <h5>About us</h5>
                <ul>
                    <li><a href="#">Company Information</a></li>
                    <li><a href="#">Contact us</a></li>
                    <li><a href="#">Reviews</a></li>
                </ul>
            </div>
            <div class="col-sm-3 myCols">
                <h5>Support</h5>
                <ul>
                  <li><a href="#">FAQ</a></li>
                  <li><a href="#">Help desk</a></li>
                  <li><a href="#">Forums</a></li>
                </ul>
            </div>
            <div class="col-sm-3 myCols">
                <h5>Legal</h5>
                <ul>
                    <li><a href="#">Terms of Service</a></li>
                    <li><a href="#">Terms of Use</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                </ul>
            </div>
          </div>
        </div>
        <div class="social-networks">
            <a href="https://twitter.com" class="twitter"><img src="../images/twitterIcon.jpg" alt="" class="img-thumbnail img-circle"/></a>
            <a href="https://facebook.com" class="facebook"><img src="../images/facebookIcon.jpg" alt="" class="img-thumbnail img-circle"/></a>
            <a href="https://plus.google.com/" class="google"><img src="../images/googlePlusIcon.jpg" alt="" class="img-thumbnail img-circle"/></a>
        </div>
        <div class="footer-copyright">
            <p>© 2017 BayaniOne </p>
        </div>
    </footer>
    <script src="Library/jquery.min.js"></script>
    <script src="Library/bootstrap.min.js"></script>
</body>
</html>
