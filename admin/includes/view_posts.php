<table align="center" width="750" bgcolor="skyblue">
	
		<tr bgcolor="orange" border="1">
			<th>S.N</th>
			<th>Post</th>
			<th>First Name</th>
			<th>Last Name</th>
			<th>Date</th>
			<th>Delete</th>
			<th>Edit</th>
		</tr>
		<?php 
		include("includes/connection.php");
		$sel_posts = "select * from posts ORDER by 1 DESC";
		$run_posts = mysqli_query($con,$sel_posts);
		
		$i=0; 
		while($row_posts = mysqli_fetch_array($run_posts)){
			
			$post_id = $row_posts['post_id']; 
			$user_id = $row_posts['user_id'];
			$post_body = $row_posts['post_body'];
			$post_date = $row_posts['post_date'];
			$i++;
			
			$sel_user = "select * from user where user_id='$user_id'"; 
			$run_user= mysqli_query($con,$sel_user); 
			
			while($row_users= mysqli_fetch_array($run_user)){
			
			$first_name = $row_users['first_name'];
			$last_name = $row_users['last_name'];
			
		?>
		<tr align="center">
			<td><?php echo $i; ?></td>
			<td><?php echo $post_body; ?></td>
			<td><?php echo $first_name; ?></td>
			<td><?php echo $last_name; ?></td>
			<td><?php echo $post_date; ?></td>
			<td><a href="index.php?view_posts&delete=<?php echo $post_id;?>">Delete</a></td>
			<td><a href="index.php?view_posts&edit=<?php echo $post_id;?>">Edit</a></td>
		</tr>
		<?php } }?>

</table>

<?php 
		if(isset($_GET['edit'])){
		
		$edit_id = $_GET['edit']; 
		
		$sel_posts = "select * from posts where post_id='$edit_id'";
		$run_posts = mysqli_query($con,$sel_posts);
		$row_posts = mysqli_fetch_array($run_posts);
			
		$post_new_id = $row_posts['post_id']; 
		$post_body = $row_posts['post_body']; 
		
?>

					<form action="" method="post" id = "f">
				
					<textarea cols="100" rows="4" name="body"><?php echo $post_body; ?></textarea><br />
					<input type="submit" name="update" value="Update Post"/>
					</form><br />
					
		<?php } ?>

					<?php
					
					if(isset($_POST['update'])) {
						$body = $_POST['body'];
						
						$update_post = "update posts set post_body='$body' where post_id='$post_new_id'";
						$run_update = mysqli_query($con, $update_post)
					or die("Error: ".mysqli_error($con));
						
						if($run_update) {
							echo "<script>alert('Post has been updated!')</script>";
							echo "<script>window.open('index.php?view_posts','_self')</script>";
						}
						else {
							echo "none";
						}
					}
					
	if(isset($_GET['delete'])){
	
	$delete_id = $_GET['delete']; 
	
	$delete = "delete from posts where post_id='$delete_id'"; 
	$run_del = mysqli_query($con,$delete); 
	
		if($run_del){
		
		echo "<script>alert('Post has been Deleted!')</script>";
		echo "<script>window.open('index.php?view_posts','_self')</script>";
		}
	
	}
					
					?>