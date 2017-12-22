<?php
  //code to diplays post, comment, and insert comment for individual user
  $connect=mysqli_connect("localhost","root","","bayanione_db");
  // Check connection
  if (mysqli_connect_errno())
  {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

  //code to display posts
  $result = mysqli_query($connect,"SELECT * FROM post LEFT JOIN users ON post.user_id=users.user_id LEFT JOIN individual_user ON users.user_id=individual_user.user_id WHERE users.username = '".$_SESSION['username']."' AND users.account_type='individual'");

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
          echo "</table>";

          //code to create comment
              echo "<form class='modal-content animate' id='create_comment' name='create_comment' action='home.php' method='post'>";
                echo "<fieldset>";
                    echo "<input type=hidden name='post_id' id='post_id' value =" . $row['post_id']. ">";
                    echo "<input type=hidden name='user_id' id='user_id' value =" .$row['user_id'] . ">";
                  echo "<textarea name='comment_content' id='comment_content' rows='1' cols='50' style='text-align:left;' placeholder='Write A Comment........'>" . "</textarea>";
                  echo "<input type='submit' id='commment_status' name='comment_status' value='Comment'/>";
                echo "</fieldset>";
              echo "</form>";

      //code to display comments
      $result_comment = mysqli_query($connect,"SELECT comment_content, comment_date, first_name, middle_name, last_name FROM comment LEFT JOIN users ON comment.user_id=users.user_id LEFT JOIN individual_user ON users.user_id=individual_user.user_id WHERE post_id=". $row['post_id']."");
      while($row3 = mysqli_fetch_assoc($result_comment))
      {
        echo "<div>";
        echo "<table>";
          echo "<tbody>";
            echo "<tr>";
              echo "<td>" . $row3['first_name'] . '  ' . $row3['middle_name'] . ' ' . $row3['last_name'] . "</td>";
            echo "</tr>";
            echo "<tr>";
              echo "<td>" . $row3['comment_date'] . "</td>";
            echo "</tr>";
            echo "<tr>";
              echo "<td>" . $row3['comment_content'] . "</td>";
            echo "</tr>";
          echo "</tbody>";
        echo "</table>";
        echo "</div>";
      echo "</div>";
    }
    echo "<div style='background-color: #ffffff;'>";
      echo "</br>";
    echo "</div>";
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
    $result2 = mysqli_query($connect,"SELECT comment_content, comment_date FROM comment WHERE post_id=". $row['post_id']."");
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
