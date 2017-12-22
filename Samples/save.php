<?php
    session_start();
    if(!isset($_SESSION["username"])){
        header("location:signin.php");
    } else {
?>

<html>
  <head>
    <title>Home</title>
    <script src="Library/jquery.min.js"></script>
    <script src="Library/bootstrap.min.js"></script>
  </head>
  <body>
      <center>
        <h1>BAYANIONE</h1>
        <p>TOGETHER WE CAN MAKE A BETTER PLACE!</p>
      </center>
      <h3>Welcome, <?=$_SESSION['username'];?>! </h3>
      <h5><a href="logout.php">Logout</a></h5>
      <div>
        <h3>User Info</h3>
          <?php
            $connect=mysqli_connect("localhost","root","","bayanione_db");
            // Check connection
            if (mysqli_connect_errno())
            {
              echo "Failed to connect to MySQL: " . mysqli_connect_error();
            }

            $result = mysqli_query($connect,"SELECT account_type FROM users WHERE username = '".$_SESSION['username']."'");
              while($row = mysqli_fetch_assoc($result))
              {
                echo "<input type=hidden name='account_type' id='account_type' value =" . $row['account_type']. ">";
              }
            mysqli_close($connect);
          ?>
          <?php
            $connect=mysqli_connect("localhost","root","","bayanione_db");
            // Check connection
            if (mysqli_connect_errno())
            {
              echo "Failed to connect to MySQL: " . mysqli_connect_error();
            }

            if($account_type='individual')
            {
              $result = mysqli_query($connect,"SELECT first_name, last_name, middle_name, birthdate, user_photo, residential_address, email_address FROM users INNER JOIN individual_user ON users.user_id=individual_user.user_id WHERE users.username = '".$_SESSION['username']."'");

                  echo "<table>";
                while($row = mysqli_fetch_assoc($result))
                {
                    echo "<tbody>";
                      echo "<tr>";
                        echo "<td>";
                        echo "<img src='Uploads/",$row['user_photo'],"' width='175' height='200' />";
                        echo "</td>";
                      echo "</tr>";
                      echo "<tr>";
                        echo "<td>" . 'User Full Name:' . "</td>";
                        echo "<td>" . $row['first_name'] . '   ' . $row['middle_name'] . '   ' .$row['last_name'] . "</td>";
                      echo "</tr>";
                      echo "<tr>";
                        echo "<td>" . 'Birthday:' . "</td>";
                        echo "<td>" . $row['birthdate'] . "</td>";
                      echo "</tr>";
                      echo "<tr>";
                        echo "<td>" . 'Residential Address:' . "</td>";
                        echo "<td>" . $row['residential_address'] . "</td>";
                      echo "</tr>";
                      echo "<tr>";
                        echo "<td>" . 'Email:' . "</td>";
                        echo "<td>" . $row['email_address'] . "</td>";
                      echo "</tr>";
                    echo "</tbody>";
                }
                  echo "</table>";
            }
            mysqli_close($connect);
          ?>

          <?php
            $connect=mysqli_connect("localhost","root","","bayanione_db");
            // Check connection
            if (mysqli_connect_errno())
            {
              echo "Failed to connect to MySQL: " . mysqli_connect_error();
            }

            if($account_type='organization')
            {
              $result = mysqli_query($connect,"SELECT org_name, rep_name, user_photo, residential_address, email_address FROM users INNER JOIN organization_user ON users.user_id=organization_user.user_id WHERE users.username = '".$_SESSION['username']."'");

                  echo "<table>";
                while($row = mysqli_fetch_assoc($result))
                {
                    echo "<tbody>";
                      echo "<tr>";
                        echo "<td>";
                        echo "<img src='Uploads/",$row['user_photo'],"' width='175' height='200' />";
                        echo "</td>";
                      echo "</tr>";
                      echo "<tr>";
                        echo "<td>" . 'User Full Name:' . "</td>";
                        echo "<td>" . $row['org_name'] . "</td>";
                      echo "</tr>";
                      echo "<tr>";
                        echo "<td>" . 'Representative Name:' . "</td>";
                        echo "<td>" . $row['rep_name'] . "</td>";
                      echo "</tr>";
                      echo "<tr>";
                        echo "<td>" . 'Residential Address:' . "</td>";
                        echo "<td>" . $row['residential_address'] . "</td>";
                      echo "</tr>";
                      echo "<tr>";
                        echo "<td>" . 'Email:' . "</td>";
                        echo "<td>" . $row['email_address'] . "</td>";
                      echo "</tr>";
                    echo "</tbody>";
                }
                  echo "</table>";
            }
            mysqli_close($connect);
          ?>
        </div>

        <div>
          <form class="modal-content animate" id="create_post" name="create_post" action="home.php" method="post">
            <h2>Post:</h2>
            </br>
            <fieldset>
              <?php
                $connect=mysqli_connect("localhost","root","","bayanione_db");
                // Check connection
                if (mysqli_connect_errno())
                {
                  echo "Failed to connect to MySQL: " . mysqli_connect_error();
                }

                $result = mysqli_query($connect,"SELECT user_id FROM users WHERE username = '".$_SESSION['username']."'");
                  while($row = mysqli_fetch_assoc($result))
                  {
                    echo "<input type=hidden name='user_id' id='user_id' value =" . $row['user_id']. ">";
                  }
                mysqli_close($connect);
              ?>
            </br>
            <select class="input" id="post_type" name="post_type" value="" Height="22px" Width="187px">
                <option value="">where to post?</option>
                <option value="public">Public</option>
                <option value="timeline">Timeline</option>
            </select>
            </br>
            <textarea name="post_description" rows="7" cols="64" style="text-align:left;" placeholder=".........Write Someting........"></textarea>
            </br>
            <img id="post_image" name="post_image" runat="server" height="150" width="150"/>
            </br>
            <input type="file" id="post_photo" name="post_photo" accept="image/*" onchange="readURL(this);"/>
            <!-- script to display image on select -->
            <script>
              function readURL(input) {
                      if (input.files && input.files[0]) {
                          var reader = new FileReader();
                          reader.onload = function (e) {
                              $('#post_image')
                                  .attr('src', e.target.result)
                                  .width(150)
                                  .height(150);
                          };
                          reader.readAsDataURL(input.files[0]);
                      }
              }
            </script>
            </fieldset>
              <input type="submit" id="post_status" name="post_status" value="Post"/>
          </form>

          <?php include 'databaseconn.php' ?>
          <?php
            if(isset($_POST['post_status']))
            {
              $user_id = $_POST['user_id'];
              $post_type = $_POST['post_type'];
              $post_description = $_POST['post_description'];
              $post_photo = $_POST['post_photo'];
              //$create_date = $_POST['create_date'];

              if(isset($_FILES['post_photo'])) {
                $post_photo=addslashes(file_get_contents($_FILES['post_photo']['temp_name'])); //will store the image to fp
              }
              //query to insert data
              //if($post_type!='public'){
              mysqli_query($connect, "INSERT INTO post (user_id,post_type,post_description,post_photo,create_date)
                          VALUES('$user_id','$post_type','$post_description','$post_photo', NOW())");
                          if(mysqli_affected_rows($connect) > 0){
                          echo "      ";
                        }else {
                          echo mysqli_error($connect);
                          echo "Not Added!";
                        }
              //}
              echo "<meta http-equiv='refresh' content='0'>";
            }
        ?>
        </div>
        <div>
          <?php
            $connect=mysqli_connect("localhost","root","","bayanione_db");
            // Check connection
            if (mysqli_connect_errno())
            {
              echo "Failed to connect to MySQL: " . mysqli_connect_error();
            }

            $result = mysqli_query($connect,"SELECT username FROM users WHERE username = '".$_SESSION['username']."'");
              while($row = mysqli_fetch_assoc($result))
              {
                echo "<input type=hidden name='username' id='username' value =" . $row['username']. ">";
              }
            mysqli_close($connect);
          ?>

          <?php
            $connect=mysqli_connect("localhost","root","","bayanione_db");
            // Check connection
            if (mysqli_connect_errno())
            {
              echo "Failed to connect to MySQL: " . mysqli_connect_error();
            }
            //$username = $_SESSION['username'];
            if($account_type=='individual' && $username ='username')
            {

              $result = mysqli_query($connect,"SELECT post_type, first_name, middle_name, last_name, create_date, post_description, post_photo FROM post LEFT JOIN users ON post.user_id=users.user_id LEFT JOIN individual_user ON users.user_id=individual_user.user_id WHERE users.username = '".$_SESSION['username']."'");

                  echo "<table>";
                while($row = mysqli_fetch_assoc($result))
                {
                  echo "<tbody>";
                    echo "<tr>";
                      echo "<td>" . $row['post_type'] . ' | ' . $row['first_name'] . '  ' . $row['middle_name'] . ' ' . $row['last_name'] . "</td>";
                    echo "</tr>";
                    echo "<tr>";
                      echo "<td>" . $row['create_date'] . "</td>";
                    echo "</tr>";
                    echo "<tr>";
                      echo "<td>" . $row['post_description'] . "</td>";
                    echo "</tr>";
                    echo "<tr>";
                      echo "<td>";
                      echo "<img src='Uploads/",$row['post_photo'],"' width='175' height='200' />";
                      echo "</td>";
                    echo "</tr>";
                  echo "</tbody>";
                }
                  echo "</table>";
            }
            mysqli_close($connect);
          ?>

          <?php
            $connect=mysqli_connect("localhost","root","","bayanione_db");
            // Check connection
            if (mysqli_connect_errno())
            {
              echo "Failed to connect to MySQL: " . mysqli_connect_error();
            }
            //$username = $_SESSION['username'];
            if($account_type=='organization' && $username='username')
            {

              $result = mysqli_query($connect,"SELECT post_type, org_name, create_date, post_description, post_photo FROM post LEFT JOIN users ON post.user_id=users.user_id LEFT JOIN organization_user ON users.user_id=organization_user.user_id WHERE users.username = '".$_SESSION['username']."'");

                  echo "<table>";
                while($row = mysqli_fetch_assoc($result))
                {
                  echo "<tbody>";
                    echo "<tr>";
                      echo "<td>" . $row['post_type'] . '  |  ' . $row['org_name'] .  "</td>";
                    echo "</tr>";
                    echo "<tr>";
                      echo "<td>" . $row['create_date'] . "</td>";
                    echo "</tr>";
                    echo "<tr>";
                      echo "<td>" . $row['post_description'] . "</td>";
                    echo "</tr>";
                    echo "<tr>";
                      echo "<td>";
                      echo "<img src='Uploads/",$row['post_photo'],"' width='175' height='200' />";
                      echo "</td>";
                    echo "</tr>";
                  echo "</tbody>";
                }
                  echo "</table>";
            }
            mysqli_close($connect);
          ?>

        </div>
  </body>
</html>
<?php
}
?>
