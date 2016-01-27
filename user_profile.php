<?php 
session_start();
include("includes/connection.php");
include("functions/functions.php");

if(!isset($_SESSION['user_email'])){
	
	header("location: index.php"); 
}
else {
?>
<!DOCTYPE html>
<html>
    <head><title>Welcome User</title>
    <link rel="stylesheet" href="styles/home_style.css" media="all"/>
    </head>
    <body>
    <!--container starts-->
	<!--container starts-->
	<div class="container">
		<!--Head wrap starts-->
		<div id="head_wrap">
			<!--Header starts-->
			<div id="header">
				<div class="logo">
				<a href="http://www.safepunjab.com/home.php"><img src="images/logo.png" style="float:left"/></a>
				</div>
				<div class="search_box">
					<form action="search.php" method="GET" id="search">
						<input type="text" name="q" size="60" placeholder="Search ..." />
					</form>
				</div>
					<?php 
					$u_email = $_SESSION['user_email'];
					$get_user = "select * from user where user_email='$u_email'"; 
					$run_user = mysqli_query($con,$get_user)
					or die("Error: ".mysqli_error($con));
					$row=mysqli_fetch_array($run_user);
					
					$user_id = $row['user_id']; 
					$first_name = $row['first_name'];
					$last_name = $row['last_name'];
					$user_image = $row['user_image'];
					$register_date = $row['register_date'];
					$last_login = $row['last_login'];
					
					$my_posts = "select * from posts where user_id='$user_id'";
					$run_posts = mysqli_query($con, $my_posts);
					$posts = mysqli_num_rows($run_posts);
					
                    $sel_msg = "select * from messages where receiver='$user_id' AND status='unread' ORDER by 1 DESC"; 
                    $run_msg = mysqli_query($con,$sel_msg);		
        
                    $count_msg = mysqli_num_rows($run_msg);
					
					echo "

						
                        <div id='menu'>
                            <a href='home.php'>Home</a>
                            <a href='myposts.php?u_id=$user_id'>My Profile</a>
                            <a href='edit_profile.php?u_id=$user_id'>Settings</a>
                            <a href='logout.php'>Log Out</a>
                        </div>
						
					";					

					?>
			</div>
			<!--Header ends-->
		</div>
		<!--Head wrap ends-->
			<div class="content">
				<!--user timeline starts-->
				<div id="user_timeline">
					<div id="user_details">
					<?php 
					
                    if(isset($_GET['u_id'])){
                    $u_id = $_GET['u_id'];
                    }

					$u_email = $_SESSION['user_email'];
					$get_user = "select * from user where user_id='$u_id'"; 
					$run_user = mysqli_query($con,$get_user)
					or die("Error: ".mysqli_error($con));
					$row=mysqli_fetch_array($run_user);
					
					$user_id = $row['user_id']; 
					$first_name = $row['first_name'];
					$last_name = $row['last_name'];
					$user_country = $row['user_country'];
					$birthday = $row['birthday'];
					$user_gender = $row['user_gender'];
					$user_image = $row['user_image'];
					$register_date = $row['register_date'];
					$last_login = $row['last_login'];
					echo "
						<center>
						<img src='user/user_images/$user_image' width='220' height='240'/>
						</center>
						<div id='user_mention'>
						<p><strong>Name:</strong> $first_name $last_name</p>
	                    <p><strong>Country:</strong> $user_country</p>
	                    <p><strong>Birthday:</strong> $birthday</p>
	                    <p><strong>Gender:</strong> $user_gender</p>
						<p><strong>Last Login:</strong> $last_login</p>
						<p><strong>Member Since:</strong> $register_date</p>
						<div id='button'><a href='messages.php?u_id=$user_id'>Send him/ her message</a></div>

						</div>
					";					

					?>
					</div>
				</div>
				
				
				
				<!--Content timeline starts-->
                <div id="content_timeline">

					
						<?php user_profile(); ?>
				</div>
				<!--Content timeline ends-->
			</div>
	</div>
	<!--Container ends-->

					
	

    
    </body>
</html>
<?php } ?>
