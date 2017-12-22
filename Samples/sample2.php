<!--<form class="modal-content animate" id='UserFormReg' name="UserFormReg" action='regform.php' method='post'>
    <fieldset >
    <legend>Register</legend>
    <input type='hidden' name='submitted' id='submitted' value='1'/>
    <label for='name' >Your Full Name*: </label>
    <input type='text' name='name' id='name' maxlength="50" />
    <label for='email' >Email Address*:</label>
    <input type='text' name='email' id='email' maxlength="50" />
    <label for='username' >UserName*:</label>
    <input type='text' name='username' id='username' maxlength="50" />
    <label for='password' >Password*:</label>
    <input type='password' name='password' id='password' maxlength="50" />
    <input type='submit' name='registerUser' value='Sign Up' />
    </fieldset>
</form>-->

/*if(isset($_POST['registerUser']))
{
  $name = $_POST['name'];
  $email = $_POST['email'];
  $username = $_POST['username'];
  $password = $_POST['password'];

  //query to insert data
  mysqli_query($connect, "INSERT INTO user (name,email,username,password)
              VALUES('$name','$email','$username','$password')");
              if(mysqli_affected_rows($connect) > 0){
              echo "Successfully Added!";
            }else {
              echo mysqli_error($connect);
              echo "Not Added!";
            }
}*/
