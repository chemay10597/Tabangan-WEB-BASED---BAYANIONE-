<?php
include('databaseconn.php');
?>
<body>
<br>
<br>
<div class="container">
	<form class="form-horizontal" method="POST">
	<div class="control-group">
		<div class="controls">
			<textarea rows="3" name="post_content" class="span6" placeholder="Whats on Your Mind"></textarea>
		</div>
	</div>
	<div class="control-group">
		<div class="controls">
			<button name="post" type="submit" class="btn btn-info"><i class="icon-share"></i>&nbsp;Post</button>
		</div>
	</div>
	<div class="control-group">
	<div class="controls">
	<table class="table table-bordered">
	<thead>
	</thead>
	<tbody>
		<?php
		  $result = mysqli_query($connect,"SELECT * FROM posts");
			while($row=mysqli_fetch_array($result)){
			$id=$row['post_id'];
		?>
		<tr>
			<td><?php echo $row['content']; ?></td>
			<td width="50">
		<?php
			$result2 = mysqli_query($connect,"SELECT * FROM comments WHERE post_id='$id'");
			$count=mysqli_num_rows($result2);
		?>
				<a href="#<?php echo $id; ?>" data-toggle="modal"><i class="icon-comments-alt"></i>&nbsp;<span class="badge badge-info"><?php echo $count; ?></span></a></td>
			<td width="40"><a class="btn btn-danger" href="delete_post.php<?php echo '?id='.$id; ?>"><i class="icon-trash"></i></a></td>
		</tr>

		<!-- Modal -->
	<div id="<?php echo $id; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-header"> </div>
	<div class="modal-body">

	<!----comment -->
	<form  method="POST">
		<input type="hidden" name="id" value="<?php echo $id; ?>">
		<textarea rows="3" name="comment_content" class="span6" placeholder="Your Comment Here"></textarea>
		<br>
		<br>
		<button name="comment" type="submit" class="btn btn-info"><i class="icon-share"></i>&nbsp;Comment</button>
	</form>
	<br>
	<br>
	<?php
		$result3 = mysqli_query($connect,"SELECT * FROM comments WHERE post_id='$post_id'");
		while($comment_row=mysqli_fetch_array($result3)){ ?>
		<div class="alert alert-success"><?php echo $comment_row['content']; ?></div>
	<?php } ?>
	<!--- end comment -->

</div>
<div class="modal-footer">
	<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
</div>
</div>
<?php  } ?>
</tbody>
</table>
</div>
</div>
</form>
</div>
<?php
		if(isset($_POST['post'])){
		$post_content=$_POST['post_content'];

		mysqli_query($connect, "INSERT INTO posts (content)
								VALUES('$post_content'");
								if(mysqli_affected_rows($connect) > 0){
								echo "      ";
							}else {
								echo mysqli_error($connect);
								echo "Not Added!";
							}
		header('location:sample.php');
		}
		?>
<?php
		if(isset($_POST['comment'])){
		$comment_content=$_POST['comment_content'];
		$post_id=$_POST['post_id'];

		mysqli_query($connect, "INSERT INTO comments (content,post_id)
								VALUES('$comment_content','$post_id'");
								if(mysqli_affected_rows($connect) > 0){
								echo "      ";
							}else {
								echo mysqli_error($connect);
								echo "Not Added!";
							}
		header('location:sample.php');
		}
		?>
</body>
</html>
