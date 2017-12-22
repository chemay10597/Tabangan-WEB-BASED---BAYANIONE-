<link rel="stylesheet" type="text/css" href="../css/homenav.css">
<script src="../jquery/jquery.min.js"></script>
<script type="text/javascript">
  //code to display textboxes based on the account_type
  $(document).ready(function(){
    $('#create_type').on('change', function() {
      if ( this.value == 'post')
      {
        $("#create_post").show();
        $("#create_group").hide();
      }
      else if ( this.value == 'group')
      {
        $("#create_group").show();
        $("#create_post").hide();
      }
    });
  });
</script>
<div>
<ul style="background-color: #669999">
  <li>
    <a href="index.php"><span><image src = "../images/logo.png" height= "30px" width="30px"></span><span><image src = "../images/logotext.png" id="logotext" height= "40px" width="150px"></span></a>
  </li>
  <li><a href="#news">News</a></li>
  <li><a href="#contact">Contact</a></li>
  <li><a href="#about">About</a></li>
</ul>
<div style="float:right;height:100%;width1100px;position:absolute;">
<div style="margin-left:0;padding:1px 16px;width:1100px;height:60px;background-color:#669999;position:fixed;z-index: 10;right: 0;top: 0;">
    <table style="float:right;border-collapse: collapse;width: 250px;">
      <tr>
          <td>
            <p style="font-size:20px;font-style:'Open Sans', sans-serif;">
              <select runat="server" id="create_type" name="create_type" value="" Height="22px" Width="187px"required>
                <option value="">create ...</option>
                <option value="post">Create Post</option>
                <option value="group">Create Group</option>
              </select>
            </p>
          </td>
          <td>
              <p style="font-size:20px;font-style:'Open Sans', sans-serif;">
                <a style="display: block;color: #f0f5f5;text-decoration: none;" href="logout.php">Logout</a>
              </p>
            </td>
      </tr>
  </table>
</div>

<div id="create_post" style="display:none; float:right;position:absolute;">
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

  <div id="create_group" style="display:none;">
fdgdf
  </div>
</div>
</div>
