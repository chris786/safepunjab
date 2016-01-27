<?php	


	$get_id = $_GET['post_id'];
			
	$get_comments = "select * from comments where post_id='$get_id' ORDER by 1 DESC";
	
	$run_comments = mysqli_query($con,$get_comments);
		
	while($row_comments=mysqli_fetch_array($run_comments)){
	
		$comment_id = $row_comments['comment_id'];
		$post_id = $row_comments['post_id'];
		$user_id = $row_comments['user_id'];
		$comment_body = $row_comments['comment_body'];
		$comment_date = $row_comments['comment_date'];
		
		//getting the user who has posted the thread
		$user = "select * from user where user_id='$user_id'"; 
		
		$run_user = mysqli_query($con,$user); 
		$row_user=mysqli_fetch_array($run_user);
		$first_name = $row_user['first_name'];
		$last_name = $row_user['last_name'];
		$user_image = $row_user['user_image'];
		
		
		echo "
		<div id='comments'>
		<p><img src='user/user_images/$user_image' width='40' height='40'></p>
		<p id='comment_date'>$comment_date</p>
		<h3><a href='user_profile.php?u_id=$user_id'>$first_name $last_name</a></h3>
		
		<p id='comment_body'>$comment_body</p>
		
		
		</div>
		";
	
	}
	
?>