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
				<img src="images/logo.png" style="float:left"/>
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
					
					$user = $_SESSION['user_email'];
					$get_user = "select * from user where user_email='$user'"; 
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
						

						</div>
					";					

					?>
					</div>
				</div>
				
				
				
				<!--Content timeline starts-->
                <div id="content_timeline">
                
                <?php
                    if(isset($_GET['u_id'])){
            
                    $u_id = $_GET['u_id'];
            
                    $sel = "select * from user where user_id='$u_id'"; 
                    $run = mysqli_query($con,$sel); 
                    $row=mysqli_fetch_array($run); 
            
                    $first_name = $row['first_name'];
                    
                    }
        
                ?>	
                
		<h2>Send a message to <span style='color:red;'><?php echo $first_name; ?></span></h2><br />
			
			<form action="messages.php?u_id=<?php echo $u_id;?>" method="post" id="f">
				<textarea name="body" cols="50" rows="5" placeholder="Write your message here..."/></textarea><br/>
				<input type="submit" name="message" value="Send Message"/>
			</form><br/>
			

			
						
						
				</div>
				<!--Content timeline ends-->
				
            <?php 
            if(isset($_POST['message'])){

                
            
			$body = nl2br(addslashes($_POST['body']));
			$body = wordwrap($body,68,"<br />",TRUE);
                
			if($body==''){
			
			echo "<p>*Please enter the message</p>";
			
			exit();
			
			}
			else {
    
                $insert = "insert into messages (sender,receiver,message_body,reply,status,message_date)
                values ('$user_id','$u_id','$body','no_reply','unread',NOW())"; 
    
                $run_insert = mysqli_query($con,$insert); 
    
                if($run_insert){
                echo "<center><h2>Message was sent to ". $first_name . " successfully</h2></center>";
                }
                else {
    
                echo "<center><h2>Message was not sent...!</h2></center>";
                }
    
            }
            }

            ?>
				
			</div>
	</div>
	<!--Container ends-->

					
	

    
    </body>
</html>
<?php } ?>
