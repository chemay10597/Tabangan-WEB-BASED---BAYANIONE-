<?php
  include_once("homenav.php");
?>
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
<div id="user_info" style="display:none;">
  <?php
      include_once("userinfo.php");
  ?>
</div>




      <?php
        //code to get login user info
        $connect=mysqli_connect("localhost","root","","bayanione_db");
        // Check connection
        if (mysqli_connect_errno())
        {
          echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        //code to get the login user info based on account_type (organization user)
        if($account_type='organization')
        {
        $result = mysqli_query($connect,"SELECT org_name, rep_name, user_photo, residential_address, email_address FROM users INNER JOIN organization_user ON users.user_id=organization_user.user_id WHERE users.username = '".$_SESSION['username']."'");

        while($row = mysqli_fetch_assoc($result))
        {
          echo "<div>";
            echo "<table>";
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
            echo "</table>";
          echo "</div>";
          }
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
          //code to get the user_id that is used in inserting record in post table
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
          //script code to display photo during selection
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
        //code to insert record in post table
        if(isset($_POST['post_status']))
        {
          //variables
          $user_id = $_POST['user_id'];
          $post_type = $_POST['post_type'];
          $post_description = $_POST['post_description'];
          $post_photo = $_POST['post_photo'];

          if(isset($_FILES['post_photo'])) {
            $post_photo=addslashes(file_get_contents($_FILES['post_photo']['temp_name'])); //will store the image to fp
          }
          //query to insert data
          mysqli_query($connect, "INSERT INTO post (user_id,post_type,post_description,post_photo,create_date)
                      VALUES('$user_id','$post_type','$post_description','$post_photo', NOW())");
                      if(mysqli_affected_rows($connect) > 0){
                      echo "      ";
                    }else {
                      echo mysqli_error($connect);
                      echo "Not Added!";
                    }
          echo "<meta http-equiv='refresh' content='0'>";
        }
    ?>
    </div>
    <div>

      <?php
        //code to diplays post, comment, and insert comment for individual user
        $connect=mysqli_connect("localhost","root","","bayanione_db");
        // Check connection
        if (mysqli_connect_errno())
        {
          echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        //code to display posts
        $result_post = mysqli_query($connect,"SELECT * FROM post LEFT JOIN users ON post.user_id=users.user_id LEFT JOIN individual_user ON users.user_id=individual_user.user_id WHERE users.username = '".$_SESSION['username']."' AND users.account_type='individual'");
        if($result_post)
        {
          foreach($result_post as $post)
              //while($row = mysqli_fetch_assoc($result))
              {
                    echo "<div style='background-color: #C6C6C6;'>";
                      echo "<table>";
                        echo "<tbody>";
                          echo "<tr>";
                            echo "<td>";
                              echo "<input type=hidden name='post_id' id='post_id' value =" . $post['post_id']. ">";
                            echo "</td>";
                          echo "</tr>";
                          echo "<tr>";
                            echo "<td>" . $post['post_type'] . ' | ' . $post['first_name'] . '  ' . $post['middle_name'] . ' ' . $post['last_name'] . "</td>";
                          echo "</tr>";
                          echo "<tr>";
                            echo "<td>" . $post['create_date'] . "</td>";
                          echo "</tr>";
                          echo "<tr>";
                            echo "<td>" . $post['post_description'] . "</td>";
                          echo "</tr>";
                          echo "<tr>";
                            echo "<td>";
                              echo "<img src='Uploads/",$post['post_photo'],"' width='175' height='200' />";
                            echo "</td>";
                          echo "</tr>";
                        echo "</tbody>";
                      echo "</table>";

                      //code to display comments
                      $result_comment = mysqli_query($connect,"SELECT comment_content, comment_date, first_name, middle_name, last_name FROM post_comment LEFT JOIN users ON post_comment.user_id=users.user_id LEFT JOIN individual_user ON users.user_id=individual_user.user_id WHERE post_id=". $row['post_id']."");
                      if($result_comment)
                      {
                        foreach($result_comment as $comment)
                      //while($row3 = mysqli_fetch_assoc($result_comment))
                        {
                        echo "<div>";
                          echo "<table>";
                            echo "<tbody>";
                              echo "<tr>";
                                echo "<td>" . $comment['first_name'] . '  ' . $comment['middle_name'] . ' ' . $comment['last_name'] . "</td>";
                              echo "</tr>";
                              echo "<tr>";
                                echo "<td>" . $comment['comment_date'] . "</td>";
                              echo "</tr>";
                              echo "<tr>";
                                echo "<td>" . $comment['comment_content'] . "</td>";
                              echo "</tr>";
                            echo "</tbody>";
                          echo "</table>";
                          echo "</div>";
                        }
                    }

                      //code to create comment
                          echo "<form class='modal-content animate' id='create_comment' name='create_comment' action='home.php' method='post'>";
                            echo "<fieldset>";
                                echo "<input type=hidden name='post_id' id='post_id' value =" . $row['post_id']. ">";
                                echo "<input type=hidden name='user_id' id='user_id' value =" .$row['user_id'] . ">";
                              echo "<textarea name='comment_content' id='comment_content' rows='1' cols='50' style='text-align:left;' placeholder='Write A Comment........'>" . "</textarea>";
                              echo "<input type='submit' id='commment_status' name='comment_status' value='Comment'/>";
                            echo "</fieldset>";
                          echo "</form>";

                echo "<div style='background-color: #ffffff;'>";
                  echo "</br>";
                echo "</div>";
          }
    }
        mysqli_close($connect);
      ?>

    <?php
      //code to diplays post, comment, and insert comment for organization user
      $connect=mysqli_connect("localhost","root","","bayanione_db");
      // Check connection
      if (mysqli_connect_errno())
      {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
      }

      $result1 = mysqli_query($connect,"SELECT user_id FROM users WHERE username = '".$_SESSION['username']."'");
      while($row1 = mysqli_fetch_assoc($result1))
      {
      //code to display posts
      $result = mysqli_query($connect,"SELECT post_id, post_type, org_name, create_date, post_description, post_photo FROM post LEFT JOIN users ON post.user_id=users.user_id LEFT JOIN organization_user ON users.user_id=organization_user.user_id WHERE users.username = '".$_SESSION['username']."' AND users.account_type='organization'");

      while($row = mysqli_fetch_assoc($result))
      {
        echo "<div style='background-color: #C6C6C6;'>";
          echo "<table>";
            echo "<tbody>";
            echo "<tr>";
              echo "<td>";
                echo "<input type=hidden name='post_id' id='post_id' value =" . $row['post_id']. ">";
              echo "</td>";
            echo "</tr>";
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
          echo "</table>";
          //code to create comment
          echo "<form class='modal-content animate' id='create_comment' name='create_comment' action='home.php' method='post'>";
            echo "<fieldset>";
              echo "<input type=hidden name='post_id' id='post_id' value =" . $row['post_id']. ">";
                echo "<input type=hidden name='user_id' id='user_id' value =" . $row1['user_id']. ">";
              echo "<textarea name='comment_content' id='comment_content' rows='1' cols='50' style='text-align:left;' placeholder='Write A Comment........'>" . "</textarea>";
              echo "<input type='submit' id='commment_status' name='comment_status' value='Comment'/>";
            echo "</fieldset>";
          echo "</form>";
          //code to display comments
          $result2 = mysqli_query($connect,"SELECT comment_content, comment_date FROM post_comment WHERE post_id=". $row['post_id']."");
          while($row2 = mysqli_fetch_assoc($result2))
          {
          echo "<div>";
          echo "<table>";
            echo "<tbody>";
              echo "<tr>";
                echo "<td>" . $row['org_name'] . "</td>";
              echo "</tr>";
              echo "<tr>";
                echo "<td>" . $row2['comment_date'] . "</td>";
              echo "</tr>";
              echo "<tr>";
                echo "<td>" . $row2['comment_content'] . "</td>";
              echo "</tr>";
            echo "</tbody>";
          echo "</table>";
          echo "</div>";
        echo "</div>";
        echo "<div style='background-color: #ffffff;'>";
          echo "</br>";
        echo "</div>";
      }
      }
      }
      mysqli_close($connect);
    ?>

    <?php include 'databaseconn.php' ?>
    <?php
    //code to insert records in comment table
      if(isset($_POST['comment_status']))
      {
        $user_id = $_POST['user_id'];
        $post_id = $_POST['post_id'];
        $comment_content = $_POST['comment_content'];

        mysqli_query($connect, "INSERT INTO post_comment (user_id,post_id,comment_content,comment_date)
                    VALUES('$user_id','$post_id','$comment_content', NOW())");
                    if(mysqli_affected_rows($connect) > 0){
                    echo "      ";
                  }else {
                    echo mysqli_error($connect);
                    echo "Not Added!";
                  }
        echo "<meta http-equiv='refresh' content='0'>";
      }
  ?>
  </div>
  <script src="/jquery/jquery.min.js"></script>
  <script src="/jquery/popper.min.js"></script>
  <script src="/jquery/bootstrap.min.js"></script>
  <!-- Core plugin JavaScript-->
  <script src="/jquery/jquery.easing.min.js"></script>
  <!-- Custom scripts for all pages-->
  <script src="/jquery/sb-admin.min.js"></script>
