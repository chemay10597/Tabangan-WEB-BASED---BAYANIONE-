<?php
include_once("header.php");

if(!isset($_SESSION['username']) || $_SESSION['username'] == ""){
    header("location:index.php");
}

$postdata = getWallPost();
?>

<div class="wrapper">
    <div class="middle_box">
        <div class="feed_form">
          <form class="modal-content animate" id="frmpost" name="frmpost" action="" method="post">
          <h2>Post:</h2>
          </br>
          <fieldset>
            <?php
              $result = mysql_query("SELECT user_id FROM users WHERE username = '".$_SESSION['username']."'");
              while($row = mysql_fetch_assoc($result))
              {
                echo "<input type=hidden name='user_id' id='user_id' value =" . $row['user_id']. ">";
              }
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
            <input class="btn" id="btnpost" type="submit" name="submit" value="Post"/>
        </form>
        </div>
        <div class="clear"></div>
        <div class="feed_div" id="feed_div">
            <?php
            if($postdata){
                foreach($postdata as $post){
                    $comments = getPostComments($post['post_id']);
            ?>
                <div class="feed_box" id="postbox_<?php echo $post['post_id']; ?>">
                    <div class="feed_left">
                        <p><img class="userimg" src="<?php echo SITE_URL; ?>Images/usericon.gif"/></p>
                        <p><?php echo $post['username']; ?></p>
                    </div>
                    <div class="feed_right">
                        <p><?php echo $post['post_description']; ?></p>
                        <p class="likebox">
                            Total Like : <?php echo $post['total_like']; ?>&nbsp;|&nbsp;
                            <?php if(isset($post['like_id']) && $post['like_id'] != ""){ ?>
                                <a class="link_btn dis_like_btn" postid="<?php echo $post['post_id']; ?>" href="javascript:;">Dislike</a>&nbsp;|&nbsp;
                            <?php }else{ ?>
                                <a class="link_btn like_btn" postid="<?php echo $post['post_id']; ?>" href="javascript:;">Like</a>&nbsp;|&nbsp;
                            <?php } ?>
                            <a class="link_btn" href="javascript:;">Comment</a>
                        </p>
                        <div class="clear"></div>
                        <?php if($comments){ ?>
                            <div class="comment_div">
                                <?php foreach($comments as $comment){ ?>
                                <div class="clear"></div>
                                <div class="comment_ele">
                                    <p><a class="link_btn" href="javascript:;"><?php echo $comment['first_name']; ?></a></p>
                                    <p><?php echo $comment['comment_content']; ?></p>
                                </div>
                                <?php } ?>
                            </div>
                        <?php } ?>
                        <div class="clear"></div>
                        <p>
                            <form id="commentform_<?php echo $post['post_id']; ?>" method="post">
                                <input type="hidden" name="action" value="comment"/>
                                <?php

                                  $result2 = mysql_query("SELECT user_id FROM users WHERE username = '".$_SESSION['username']."'");
                                  while($row2= mysql_fetch_assoc($result2))
                                  {
                                    echo "<input type=hidden name='user_id' id='user_id' value =" . $row2['user_id']. ">";
                                  }
                                ?>
                                <input type="hidden" name="post_id" value="<?php echo $post['post_id']; ?>"/>
                                <input class="input comment_input" type="text" name="comment_content" id="comment_<?php echo $post['post_id']; ?>" placeholder="your comment"/>
                                <input class="submitbtn btn" postid="<?php echo $post['post_id']; ?>" type="submit" name="sendbtn" value=">"/>
                            </form>
                        </p>
                    </div>
                    <div class="clear"></div>
                </div>
            <?php
                }
            }
            ?>

        </div>
    </div>
    <div class="clear"></div>
</div>

<div class="clear"></div>
<?php
include_once("footer.php");
?>

<script type='text/javascript'>
$(document).ready(function(){

    $(".submitbtn").live("click",function(){
        var post_id = $(this).attr('post_id');
        var comment_content = $("#comment_content_"+post_id).val();
        if(comment_content == ''){
            alert("comment can't be empty!");
            return false;
        }else{
            $.ajax({
                type: "POST",
                data: $('#commentform_'+post_id).serialize(),
                url: '<?php echo SITE_URL; ?>/functions.php',
                dataType: 'json',
                success: function(response) {
                    if(response.ResponseCode == 200){
                        $('#postbox_'+post_id).load('<?php echo SITE_URL; ?>/wall.php #postbox_'+post_id+' >*');
                    }else{
                        alert(response.Message);
                    }
                }
            });
        }
    });
    $(".like_btn").live("click",function(){
        var post_id = $(this).attr('postid');
        $.ajax({
                type: "POST",
                data: {'post_id':post_id,'action':'like'},
                url: '<?php echo SITE_URL; ?>/functions.php',
                dataType: 'json',
                success: function(response) {
                    if(response.ResponseCode == 200){
                        $('#postbox_'+post_id).load('<?php echo SITE_URL; ?>/wall.php #postbox_'+post_id+' >*');
                    }else{
                        alert(response.Message);
                    }
                }
        });
    });

    $(".dis_like_btn").live("click",function(){
        var post_id = $(this).attr('postid');
        $.ajax({
                type: "POST",
                data: {'post_id':post_id,'action':'dislike'},
                url: '<?php echo SITE_URL; ?>/functions.php',
                dataType: 'json',
                success: function(response) {
                    if(response.ResponseCode == 200){
                        $('#postbox_'+post_id).load('<?php echo SITE_URL; ?>/wall.php #postbox_'+post_id+' >*');
                    }else{
                        alert(response.Message);
                    }
                }
        });
    });


    $("#btnpost").click(function(){
      var user_id = $(this).attr('user_id');
        var post_type = $("#post_type").val();
        var post_description = $("#post_description").val();
        var post_photo = $("#post_photo").val();
        if(post_type == "" && post_description == "" && post_photo == ""){
            alert("Post Feed Data can't be empty!");
            return false;
        }else{
            $.ajax({
                 type: "POST",
                 data: {'post_type':post,'post_description':post,'post_photo':post,'action':'post'},
                 url: '<?php echo SITE_URL; ?>/functions.php',
                 dataType: 'json',
                 success: function(response) {
                     if(response.ResponseCode == 200){
                         $("#post_feed").val("");
                         $('#feed_div').load('<?php echo SITE_URL; ?>/wall.php #feed_div');
                     }else{
                        alert(response.Message);
                     }
                 }
            });
        }
    });

});
</script>
