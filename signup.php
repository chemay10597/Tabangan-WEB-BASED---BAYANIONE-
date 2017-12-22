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
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Sign-up</title>
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans|Candal|Alegreya+Sans">
    <link rel="stylesheet" type="text/css" href="../fonts/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <script type="text/javascript" src="../jquery/jquery.min.js"></script>
    <!-- script to choose account type -->
    <script type="text/javascript">
      //code to display textboxes based on the account_type
      $(document).ready(function(){
        $('#account_type').on('change', function() {
          if ( this.value == 'individual')
          {
            $("#individual_user").show();
            $("#organization_user").hide();
          }
          else if ( this.value == 'organization')
          {
            $("#organization_user").show();
            $("#individual_user").hide();
          }
        });
      });
    </script>
  </head>
  <body>
  <body>
      <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class = "navbar-brand" href="index.php"><span><image src = "../images/logo.png" height= "50px" width="50px"></span><span><image src = "../images/logotext.png" height= "50px" width="200px"></span></a>
          <!-- <a class="navbar-brand" href="index.html">BayaniOne<span>.</span></a> -->
          </div>
          <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav navbar-right">
              <li>
                <form action="" method="POST">
                  <ul class="nav navbar-nav navbar-right">
                    <li><input class="form-control" style="border: 1px solid green;border-radius: 4px;" placeholder="username" type="text" name="username"></li>
                    <li>&nbsp;</li>
                    <li><input class="form-control" style="border: 1px solid green;border-radius: 4px;" placeholder="password" type="password" name="password"></li>
                    <li><input class="btnlogin" type="submit" value="Login" name="submit" /></li>
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


  <body>
  <section id="goodwork" class="section-padding">
    <div class="main">
      <div class="header" >
        <h1>Register Now</h1>
      </div>
      <p>We make a living by what we get, but we make a life by what we give.</p>
      <form class="modal-content animate" id="UserFormReg" name="UserFormReg" action="signup.php" method="post">
        <fieldset class="left-form">
          <h2>Personal Information:</h2>
          </br></br></br>
            <?php
              //code to get user_id
              $connect=mysqli_connect("localhost","root","","bayanione_db");
              // Check connection
              if (mysqli_connect_errno())
              {
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
              }
              $result = mysqli_query($connect,"SELECT MAX(user_id) FROM users GROUP BY user_id");
              if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_array($result)){
                  $next = $row['MAX(user_id)'] + 1;
                }
                  echo "<input value='". $next ."' type='hidden' name='user_id' id='user_id'>";
                  echo "</input>";
              }
              mysqli_close($connect);
            ?>
            <div class="clear"> </div>
          	<label>Type of account:</label><i>&nbsp &nbsp</i>
            <select class="input" runat="server" id="account_type" name="account_type" value="" Height="22px" Width="187px"required>
              <option value="">choose type ..</option>
              <option value="individual">Individual</option>
              <option value="organization">Organization</option>
            </select>
            <li>
            </li>
            <div id="individual_user" style="display:none;">
              <ul>
                <li>
                  <input id="first_name" name="first_name" type="text" placeholder="first name ..."/>
                  <a href="#" class="icon into"></a>
                  <div class="clear"> </div>
                </li>
                  <li>
                    <input id="last_name" name="last_name" type="text"   placeholder="last name ..."/>
                    <a href="#" class="icon into"> </a>
                    <div class="clear"> </div>
                  </li>
                  <li>
                    <input id="middle_name" name="middle_name" type="text"   placeholder="middle name ..."/>
                    <a href="#" class="icon into"> </a>
                    <div class="clear"> </div>
                  </li>
                  <li>
                    <input id="birthdate" name="birthdate" type="date"/>
                    <a href="#" class="icon into"> </a>
                    <div class="clear"> </div>
                  </li>
                </ul>
              </div>
            <div id="organization_user" style="display:none;">
              <ul>
                <li>
                  <input id = "org_name" name="org_name" type="text" placeholder="organization name ..."/>
                  <a href="#" class="icon into"> </a>
                  <div class="clear"> </div>
                </li>
                <li>
                  <input id = "rep_name" name="rep_name" type="text" placeholder="representative full name ..."/>
                  <a href="#" class="icon into"> </a>
                  <div class="clear"> </div>
                </li>
              </ul>
            </div>
            <li>
              <input id = "residential_address" name="residential_address" type="text" placeholder="complete address ..." required/>
              <a href="#" class="icon into"> </a>
              <div class="clear"> </div>
            </li>
            <li>
              <input id="email_address" name="email_address" type="email" placeholder="user@domain.com" required/>
              <a href="#" class="icon into"> </a>
              <div class="clear"> </div>
            </li>
        </fieldset>
        <ul class="right-form">
          <h3>Login Information:</h3>
          <div>
            <li>
              <center><img id="user_image" name="user_image" runat="server" height="150" width="150"/></center>
            </br>
              <center><input type="file" id="user_photo" name="user_photo" accept="image/*" onchange="readURL(this);" required/></center>
              <!-- script to display image on select -->
              <script>
                //script code to display photo during selection
                function readURL(input) {
                  if (input.files && input.files[0]) {
                      var reader = new FileReader();
                      reader.onload = function (e) {
                            $('#user_image')
                            .attr('src', e.target.result)
                            .width(150)
                            height(150);
                      };
                      reader.readAsDataURL(input.files[0]);
                  }
                }
              </script>
            </li>
              <li>
                <input id="username" name="username" type="text" placeholder="username ..." required/>
                <a href="#" class="icon into"> </a>
                <div class="clear"> </div>
              </li>
              <li>
                <input id="password" name="password" type="password" placeholder="password ..." required/>
                <a href="#" class="icon into"> </a>
                <div class="clear"> </div>
              </li>
                <button type="submit" class="signupbtn" height="59px"width="341px" id="registerUser" name="registerUser" >Sign Up</button>
            </div>
            <div class="clear"> </div>
          </ul>
          <div class="clear"> </div>
        </form>
      </div>
     </section>
     <script src="../jquery/jquery.min.js"></script>
     <script src="../jquery/bootstrap.min.js"></script>
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

        <?php include 'databaseconn.php' ?>
        <?php
          //code to insert records in users table, individual_user table, and organization_user table
          if(isset($_POST['registerUser']))
          {
            //variables
            $user_id = $_POST['user_id'];
            $account_type = $_POST['account_type'];
            $first_name = $_POST['first_name'];
            $last_name = $_POST['last_name'];
            $middle_name = $_POST['middle_name'];
            $birthdate = $_POST['birthdate'];
            $org_name = $_POST['org_name'];
            $rep_name = $_POST['rep_name'];
            $user_photo = $_POST['user_photo'];
            $residential_address = $_POST['residential_address'];
            $email_address = $_POST['email_address'];
            $username = $_POST['username'];
            $password = $_POST['password'];

            if(isset($_FILES['user_photo'])) {
              $user_photo=addslashes(file_get_contents($_FILES['user_photo']['tmp_name'])); //will store the image to fp
            }

            //query to insert data
            if($account_type!='' && $first_name!='' && $last_name!='' && $middle_name!='' && $birthdate!='' && $org_name!='' && $rep_name!=''){
            mysqli_query($connect, "INSERT INTO users (user_id,account_type,user_photo,residential_address,email_address,username,password)
                        VALUES('$user_id','$account_type','$user_photo','$residential_address','$email_address','$username','$password')");
                              if(mysqli_affected_rows($connect) > 0){
                                echo "      ";
                              }else {
                                echo mysqli_error($connect);
                                echo "Not Added!";
                              }
            }
            //code to insert records individual_user table
            if($account_type=='individual' && $first_name!='' && $last_name!='' && $middle_name!='' && $birthdate!=''){
              mysqli_query($connect, "INSERT INTO individual_user (user_id,first_name,last_name,middle_name,birthdate)
                          VALUES('$user_id','$first_name','$last_name','$middle_name','$birthdate')");
                              if(mysqli_affected_rows($connect) > 0){
                                echo "      ";
                              }else {
                                echo mysqli_error($connect);
                                echo "Not Added!";
                                }
            }
            //code to insert records organization_user table
            else if($account_type=='organization' && $org_name!='' && $rep_name!=''){
              mysqli_query($connect, "INSERT INTO organization_user (user_id,org_name,rep_name)
                          VALUES('$user_id','$org_name','$rep_name')");
                                if(mysqli_affected_rows($connect) > 0){
                                    echo "      ";
                                }else {
                                    echo mysqli_error($connect);
                                    echo "Not Added!";
                                }
                              }
                                echo "<meta http-equiv='refresh' content='0'>";
            }
        ?>
      </body>
</html>
