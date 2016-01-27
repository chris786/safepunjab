<?php

$con = mysqli_connect("localhost", "tworntcx_safepun", "N4hpz*+g=hD0", "tworntcx_safepunjab") or die("Connection was not established");



		function insertPost(){
		    
			if(isset($_POST['sub'])){
			global $con;
			global $user_id;
			
            $name = $_FILES['video']['name'];
            $type = explode('.', $name);
            $type = end($type);
            $size = $_FILES['video']['size'];
            $random_name = rand();
            $tmp = $_FILES['video']['tmp_name'];
		
            $image_name = $_FILES['image']['name'];
            $image_type = $_FILES['image']['type'];
            $image_size = $_FILES['image']['size'];
            $image_tmp_name = $_FILES['image']['tmp_name'];

			$body = nl2br(addslashes($_POST['body']));
			$body = wordwrap($body,68,"<br />",TRUE);
			
			if($body==''){
			
			echo "<p>*Please enter the post</p>";
			
			exit();
			
			}
			else {
			
			move_uploaded_file($image_tmp_name,"images_upload/$image_name");
			move_uploaded_file($tmp,"videos_upload/$random_name");
			
			$insert = "insert into posts (user_id,post_body,image_name,video_name,video_url,post_date) values ('$user_id','$body', '$image_name', '$name', '$random_name', NOW())";
			
			$run = mysqli_query($con,$insert); 
				
				if($run){
				echo "<h3>Shared to timeline, Looks great!</h3>";
				
				$update = "update user set posts='yes' where user_id='$user_id'";
				$run_update = mysqli_query($con,$update);
				}
				else {
				echo "Fail";
				}
			}
			
		}
		
		
		
	}
	
	//function for displaying posts
	function get_posts(){
	
	global $con;
		
	$per_page=100;
	
	if (isset($_GET['page'])) {
	$page = $_GET['page'];
	}
	else {
	$page=1;
	}
	$start_from = ($page-1) * $per_page;
	
	$get_posts = "select * from posts ORDER by 1 DESC LIMIT $start_from, $per_page";
	
	$run_posts = mysqli_query($con,$get_posts);
	
	while($row_posts=mysqli_fetch_array($run_posts)){
	
		$post_id = $row_posts['post_id'];
		$user_id = $row_posts['user_id'];
		$post_body = $row_posts['post_body'];
		$image_name = $row_posts['image_name'];
	    $video_name = $row_posts['video_name'];
	    $video_url = $row_posts['video_url'];
		$post_date = $row_posts['post_date'];
		
		//getting the user who has posted the thread
		$user = "select * from user where user_id='$user_id' AND posts='yes'"; 
		
		$run_user = mysqli_query($con,$user); 
		$row_user=mysqli_fetch_array($run_user);
		$first_name = $row_user['first_name'];
		$last_name = $row_user['last_name'];
		$user_image = $row_user['user_image'];
		
		if($video_name=='' && $image_name==''){
		
		//now displaying all at once 
		echo "<div id='posts'>
		
		<p><img src='user/user_images/$user_image' width='50' height='50'></p>
		<h3><a href='user_profile.php?u_id=$user_id'>$first_name $last_name</a></h3> 
		<p id='post_date'>$post_date</p><br />
		
		
		<p id='post_body'>$post_body</p>
		
        	
        
		
		<a href='single.php?post_id=$post_id' style='float:right;'><button>View/ Coment/ Share</button></a>
		
		</div><br/>
		";
		}
		
		elseif($image_name =='') {
		
		//now displaying all at once 
		echo "<div id='posts'>
		
		<p><img src='user/user_images/$user_image' width='50' height='50'></p>
		<h3><a href='user_profile.php?u_id=$user_id'>$first_name $last_name</a></h3> 
		<p id='post_date'>$post_date</p><br />
		
		<p id='post_body'>$post_body</p>
		
		<a href='view.php?video=$video_url'><p>$video_name;</p></a>
		
		<a href='single.php?post_id=$post_id' style='float:right;'><button>View/ Coment/ Share</button></a>
		
		</div><br/>
		";		
		
		}
		
		else {
		
		//now displaying all at once 
		echo "<div id='posts'>
		
		<p><img src='user/user_images/$user_image' width='50' height='50'></p>
		<h3><a href='user_profile.php?u_id=$user_id'>$first_name $last_name</a></h3> 
		<p id='post_date'>$post_date</p><br />
		<p><img src='images_upload/$image_name' width='510' height='460'></p>
		
		<p id='post_body'>$post_body</p>
		
		<a href='single.php?post_id=$post_id' style='float:right;'><button>View/ Coment/ Share</button></a>
		
		</div><br/>
		";		
		
		}
		
	}

	}
	
	//function for displaying search results
	function get_results(){
	
	global $con;
		
	$per_page=100;
	
	if (isset($_GET['page'])) {
	$page = $_GET['page'];
	}
	else {
	$page=1;
	}
	$start_from = ($page-1) * $per_page;
	
	if(isset($_GET['search_post'])){
	$date = urlencode($_GET['search_post']);
	}
	
	$get_posts = "select * from posts where post_date like '%$date%' ORDER by 1 DESC LIMIT $start_from, $per_page";
	
	$run_posts = mysqli_query($con,$get_posts);
	
	while($row_posts=mysqli_fetch_array($run_posts)){
	
		$post_id = $row_posts['post_id'];
		$user_id = $row_posts['user_id'];
		$post_body = $row_posts['post_body'];
		$image_name = $row_posts['image_name'];
	    $video_name = $row_posts['video_name'];
	    $video_url = $row_posts['video_url'];
		$post_date = $row_posts['post_date'];
		
		//getting the user who has posted the thread
		$user = "select * from user where user_id='$user_id' AND posts='yes'"; 
		
		$run_user = mysqli_query($con,$user); 
		$row_user=mysqli_fetch_array($run_user);
		$first_name = $row_user['first_name'];
		$last_name = $row_user['last_name'];
		$user_image = $row_user['user_image'];
		
		if($image_name==''){
		
		//now displaying all at once 
		echo "<div id='posts'>
		
		<p><img src='user/user_images/$user_image' width='50' height='50'></p>
		<h3><a href='user_profile.php?u_id=$user_id'>$first_name $last_name</a></h3> 
		<p id='post_date'>$post_date</p><br />
		
		
		<p id='post_body'>$post_body</p>
		
        <a href='view.php?video=$video_url'><p>$video_name;</p></a>
        
		
		<a href='single.php?post_id=$post_id' style='float:right;'><button>View/ Coment/ Share</button></a>
		
		</div><br/>
		";
		}
		else {
		
		//now displaying all at once 
		echo "<div id='posts'>
		
		<p><img src='user/user_images/$user_image' width='50' height='50'></p>
		<h3><a href='user_profile.php?u_id=$user_id'>$first_name $last_name</a></h3> 
		<p id='post_date'>$post_date</p><br />
		<p><img src='images_upload/$image_name' width='510' height='460'></p>
		
		<p id='post_body'>$post_body</p>
		
		<a href='single.php?post_id=$post_id' style='float:right;'><button>View/ Coment/ Share</button></a>
		
		</div><br/>
		";		
		
		}
		
	}

	}
	
	//function for displaying single post
	
	function single_post(){
	
	if(isset($_GET['post_id'])){
	
	global $con; 
	
	$get_id = $_GET['post_id'];
	
	$get_posts = "select * from posts where post_id='$get_id'";
	
	$run_posts = mysqli_query($con,$get_posts);
	
	$row_posts=mysqli_fetch_array($run_posts);

	
		$post_id = $row_posts['post_id'];
		$user_id = $row_posts['user_id'];
		$post_body = $row_posts['post_body'];
		$image_name = $row_posts['image_name'];
	    $video_name = $row_posts['video_name'];
	    $video_url = $row_posts['video_url'];
		$post_date = $row_posts['post_date'];
		
		//getting the user who has posted the thread
		$user = "select * from user where user_id='$user_id' AND posts='yes'"; 
		
		$run_user = mysqli_query($con,$user); 
		$row_user=mysqli_fetch_array($run_user);
		$first_name = $row_user['first_name'];
		$last_name = $row_user['last_name'];
		$user_image = $row_user['user_image'];
		
		if($image_name==''){
		
		//now displaying all at once 
		echo "<div id='posts'>
		
		<p><img src='user/user_images/$user_image' width='50' height='50'></p>
		<h3><a href='user_profile.php?u_id=$user_id'>$first_name $last_name</a></h3> 
		<p id='post_date'>$post_date</p><br />
		
		
		<p id='post_body'>$post_body</p>
		
        <a href='view.php?video=$video_url'><p>$video_name;</p></a>
        
		
		
		</div><br/>
		";
		}
		else {
		
		//now displaying all at once 
		echo "<div id='posts'>
		
		<p><img src='user/user_images/$user_image' width='50' height='50'></p>
		<h3><a href='user_profile.php?u_id=$user_id'>$first_name $last_name</a></h3> 
		<p id='post_date'>$post_date</p><br />
		
		<p><img src='images_upload/$image_name' width='510' height='460'></p>
		<p id='post_body'>$post_body</p>
		
		
		</div><br/>
		";		
		
		}
		
		include("comments.php");
		
		echo "
		<form action='' method='post' id='reply'>
		<textarea cols='83' rows='2' name='comment_body' placeholder='write your reply'></textarea><br/>
		<input type='submit' name='comment' value='Reply to This'/>
		</form>
		
		";
		
			if(isset($_POST['comment'])){
			global $con;
			global $user_id;
		
			
			$comment_body = nl2br(addslashes($_POST['comment_body']));
			$comment_body = wordwrap($comment_body,68,"<br />",TRUE);
		
			
			if($comment_body==''){
			
			echo "<p>*Please enter the comment</p>";
			
			exit();
			
			}
			else {
			
			$insert = "insert into comments (post_id,user_id,comment_body,comment_date) values ('$post_id','$user_id','$comment_body',NOW())";
			
			$run = mysqli_query($con,$insert); 
				
				if($run){
				echo "<h3>Shared to timeline, Looks great!</h3>";
			
				}
				else {
				echo "Fail";
				}
			}
			}
		

		
	}

	}
	
	//function for displaying posts
	function myposts(){
	
	global $con;
	
	if(isset($_GET['u_id'])){
	$u_id = $_GET['u_id'];
	}
	$get_posts = "select * from posts where user_id='$u_id' ORDER by 1 DESC";
	
	$run_posts = mysqli_query($con,$get_posts);

	while($row_posts=mysqli_fetch_array($run_posts)){
	
		$post_id = $row_posts['post_id'];
		$user_id = $row_posts['user_id'];
		$post_body = $row_posts['post_body'];
		$image_name = $row_posts['image_name'];
	    $video_name = $row_posts['video_name'];
	    $video_url = $row_posts['video_url'];
		$post_date = $row_posts['post_date'];
		
		//getting the user who has posted the thread
		$user = "select * from user where user_id='$user_id' AND posts='yes'"; 
		
		$run_user = mysqli_query($con,$user); 
		$row_user=mysqli_fetch_array($run_user);
		$first_name = $row_user['first_name'];
		$last_name = $row_user['last_name'];
		$user_image = $row_user['user_image'];
		
		if($image_name==''){
		
		//now displaying all at once 
		echo "<div id='posts'>
		
		<p><img src='user/user_images/$user_image' width='50' height='50'></p>
		<h3><a href='user_profile.php?u_id=$user_id'>$first_name $last_name</a></h3> 
		<p id='post_date'>$post_date</p><br />
		
		
		<p id='post_body'>$post_body</p>
		
        <a href='view.php?video=$video_url'><p>$video_name;</p></a>
        
		
		<a href='edit_post.php?post_id=$post_id' style='float:right;'><button>Edit</button></a>
		<a href='functions/delete_post.php?post_id=$post_id' style='float:right;'><button>Delete</button></a>		
		</div><br/>
		";
		}
		else {
		
		//now displaying all at once 
		echo "<div id='posts'>
		
		<p><img src='user/user_images/$user_image' width='50' height='50'></p>
		<h3><a href='user_profile.php?u_id=$user_id'>$first_name $last_name</a></h3> 
		<p id='post_date'>$post_date</p><br />
		
		<p><img src='images_upload/$image_name' width='510' height='460'></p>
		<p id='post_body'>$post_body</p>
		
		<a href='edit_post.php?post_id=$post_id' style='float:right;'><button>Edit</button></a>
		<a href='functions/delete_post.php?post_id=$post_id' style='float:right;'><button>Delete</button></a>		
		</div><br/>
		";		
		
		}
	

		
		include("delete_post.php");
		
	}

	}


	
	//function for displaying users posts
	function user_profile(){
	
	global $con;
	
	if(isset($_GET['u_id'])){
	$u_id = $_GET['u_id'];
	}
	$get_posts = "select * from posts where user_id='$u_id' ORDER by 1 DESC";
	
	$run_posts = mysqli_query($con,$get_posts);
	
	while($row_posts=mysqli_fetch_array($run_posts)){
	
		$post_id = $row_posts['post_id'];
		$user_id = $row_posts['user_id'];
		$post_body = $row_posts['post_body'];
		$image_name = $row_posts['image_name'];
	    $video_name = $row_posts['video_name'];
	    $video_url = $row_posts['video_url'];
		$post_date = $row_posts['post_date'];
		
		//getting the user who has posted the thread
		$user = "select * from user where user_id='$user_id' AND posts='yes'"; 
		
		$run_user = mysqli_query($con,$user); 
		$row_user=mysqli_fetch_array($run_user);
		$first_name = $row_user['first_name'];
		$last_name = $row_user['last_name'];
		$user_image = $row_user['user_image'];
		
		if($image_name==''){
		
		//now displaying all at once 
		echo "<div id='posts'>
		
		<p><img src='user/user_images/$user_image' width='50' height='50'></p>
		<h3><a href='user_profile.php?u_id=$user_id'>$first_name $last_name</a></h3> 
		<p id='post_date'>$post_date</p><br />
		
		
		<p id='post_body'>$post_body</p>
		
        <a href='view.php?video=$video_url'><p>$video_name;</p></a>
        
		
		<a href='single.php?post_id=$post_id' style='float:right;'><button>View/ Coment/ Share</button></a>
		
		</div><br/>
		";
		}
		else {
		
		//now displaying all at once 
		echo "<div id='posts'>
		
		<p><img src='user/user_images/$user_image' width='50' height='50'></p>
		<h3><a href='user_profile.php?u_id=$user_id'>$first_name $last_name</a></h3> 
		<p id='post_date'>$post_date</p><br />
		
		<p><img src='images_upload/$image_name' width='510' height='460'></p>
		<p id='post_body'>$post_body</p>
		
		<a href='single.php?post_id=$post_id' style='float:right;'><button>View/ Coment/ Share</button></a>
		
		</div><br/>
		";		
		
		}
		
		
	}

	}



?>