<h3>User Info</h3>
  <?php
    //code to get the account_type of the login user
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
    //code to get login user info
    $connect=mysqli_connect("localhost","root","","bayanione_db");
    // Check connection
    if (mysqli_connect_errno())
    {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    //code to get the login user info based on account_type (individual user)
    if($account_type='individual')
    {
      $result = mysqli_query($connect,"SELECT first_name, last_name, middle_name, birthdate, user_photo, residential_address, email_address FROM users INNER JOIN individual_user ON users.user_id=individual_user.user_id WHERE users.username = '".$_SESSION['username']."'");

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
          echo "</table>";
        echo "</div>";
      }
    }
    mysqli_close($connect);
  ?>
