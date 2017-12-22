<?php
require_once("config.php");


if(isset($_POST['action']) && $_POST['action'] != ''){
    switch ($_POST['action']) {
        case 'post':
            submitWallPost($_POST);
            break;

        case 'like':
            submitPostLike($_POST);
            break;

        case 'dislike':
            submitPostDisLike($_POST);
            break;

        case 'comment':
            submitPostComment($_POST);
            break;

        default:
            return false;
            break;
    }
}

function submitPostLike($Data){
    $user_id = $_SESSION['user_id'];
    $post_id = $Data['post_id'];
    $date_created = date("Y-m-d H:i:s");

    $result = mysql_query("INSERT into post_likes(post_id,user_id,like_date) values('$post_id','$user_id','$date_created')");

    if($result){
        mysql_query("UPDATE post set total_like = total_like + 1 where post_id = '$post_id'");
        $Return = array();
        $Return['ResponseCode'] = 200;
        $Return['Message'] = "like successfully.";
    }else{
        $Return = array();
        $Return['ResponseCode'] = 511;
        $Return['Message'] = "Error : Please try again!";
    }

    echo json_encode($Return);
}
/*
function submitPostDisLike($Data){
    $user_id = $_SESSION['user_id'];
    $post_id = $Data['post_id'];

    $result = mysql_query("DELETE from fb_post_likes where user_id = '$user_id' and post_id = '$post_id'");

    if($result){
        mysql_query("UPDATE fb_post set total_like = total_like - 1 where post_id = '$post_id'");
        $Return = array();
        $Return['ResponseCode'] = 200;
        $Return['Message'] = "dislike successfully.";
    }else{
        $Return = array();
        $Return['ResponseCode'] = 511;
        $Return['Message'] = "Error : Please try again!";
    }

    echo json_encode($Return);
}
*/
function submitPostComment($Data){
    $username = $_SESSION['username'];
    $user_id = $Data['user_id'];
    $post_id = $Data['post_id'];
    $comment = $Data['comment_content'];
    $date_created = date("Y-m-d H:i:s");

    $result = mysql_query("INSERT into post_comment(post_id,user_id,comment_content,comment_date) values('$post_id','$user_id','$comment',0,$date_created')");

    if($result){
        $Return = array();
        $Return['ResponseCode'] = 200;
        $Return['Message'] = "comment submitted successfully.";
    }else{
        $Return = array();
        $Return['ResponseCode'] = 511;
        $Return['Message'] = "Error : Please try again!";
    }

    echo json_encode($Return);
}

function submitWallPost($Data){
    $user_id = $_SESSION['user_id'];
    $post_type = $Data['post_type'];
    $post_description = $Data['post_description'];
    $post_photo = $Data['post_photo'];
    $date_created = date("Y-m-d H:i:s");

    if(isset($_FILES['post_photo'])) {
                    $post_photo=addslashes(file_get_contents($_FILES['post_photo']['temp_name'])); //will store the image to fp
                  }

    $result = mysql_query("INSERT into post(user_id,post_type,post_description,post_photo,create_date)
    values('$user_id','$post_type','$post_description','$post_photo',0,'$date_created')");

    if($result){
        $Return = array();
        $Return['ResponseCode'] = 200;
        $Return['Message'] = "post updated successfully.";
    }else{
        $Return = array();
        $Return['ResponseCode'] = 511;
        $Return['Message'] = "Error : Please try again!";
    }

    echo json_encode($Return);
}

function getUserDetails($username){
    $user_query = mysql_query("select * from users where username = '".$username."'");
    $userInfo = mysql_fetch_assoc($user_query);

    return $userInfo;
}

function getWallPost(){
    $username = $_SESSION['username'];
    //$wall_query = mysql_query("SELECT * from post left join users on users.user_id = post.user_id left join post_likes on post_likes.post_id = post_likes.post_id and post_likes.user_id = '$username' group by post.post_id order by post_id desc");
    $wall_query = mysql_query("SELECT * FROM post LEFT JOIN users ON post.user_id=users.user_id LEFT JOIN individual_user ON users.user_id=individual_user.user_id WHERE users.username = '$username' AND users.account_type='individual' GROUP BY post.post_id ORDER BY post_id DESC");
    $postInfo = array();
    while($row = mysql_fetch_assoc($wall_query)){
        $postInfo[] = $row;
    }
    return $postInfo;
}

function getPostComments($post_id){
    //$comment_query = mysql_query("SELECT c.*,u.name as username from post_comment c left join users u on u.user_id = c.user_id where c.post_id = '$post_id' order by c.comment_id desc");
    $comment_query = mysql_query("SELECT comment_content, comment_date, first_name, middle_name, last_name FROM post_comment LEFT JOIN users ON post_comment.user_id=users.user_id LEFT JOIN individual_user ON users.user_id=individual_user.user_id WHERE post_comment.post_id='$post_id' ORDER BY post_comment.comment_id DESC");
    $commentInfo = array();
    while($row = mysql_fetch_assoc($comment_query)){
        $commentInfo[] = $row;
    }
    return $commentInfo;
}
?>
