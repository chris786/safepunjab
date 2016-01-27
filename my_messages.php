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
					
					$user = $_SESSION['user_email'];
					$get_user = "select * from user where user_email='$user'"; 
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
						<center>
						<img src='user/user_images/$user_image' width='220' height='240'/>
						</center>
						<div id='user_mention'>

						<div id='menu_left'>
						<a href='home.php'>Newsfeed</a><br />
						<a href='my_messages.php?inbox&u_id=$user_id'>Messages ($count_msg)</a><br />
						<a href='myposts.php?u_id=$user_id'>My Profile ($posts)</a><br />
						<a href='edit_profile.php?u_id=$user_id'>Settings</a><br />
						</div>
						

						</div>
					";					

					?>
					</div>
				</div>
				
				
				
				<!--Content timeline starts-->
                <div id="content_timeline">
                
                <p>
                <a href="my_messages.php?inbox">My Inbox</a> ||
                <a href="my_messages.php?sent">Sent Messages</a>
                </p>
                
                <?php if(isset($_GET['sent'])) {
                include("sent.php"); } ?>
                
                <?php if(isset($_GET['inbox'])) { ?>
                <div id="content_timeline">
				<p>My Messages:</p><hr />
				

				
			<?php 
		
		$sel_msg = "select * from messages where receiver='$user_id' ORDER by 1 DESC"; 
		$run_msg = mysqli_query($con,$sel_msg);		
		
		$count_msg = mysqli_num_rows($run_msg);
		
		while($row_msg=mysqli_fetch_array($run_msg))
		{
		
		$message_id = $row_msg['message_id']; 
		$message_receiver= $row_msg['receiver'];
		$message_sender= $row_msg['sender'];
		$message_body = $row_msg['message_body'];
	
		$message_date = $row_msg['message_date'];
		
		$get_sender = "select * from user where user_id='$message_sender'"; 
		$run_sender = mysqli_query($con,$get_sender); 
		$row=mysqli_fetch_array($run_sender); 
		
		$sender_name = $row['first_name'];
		
		
		
		
		
		
		?>
		

			

			
		<div id="messages">
		
		<p><img src="user/user_images/$user_image" width='50' height='50'></p>
		<h3><a href="user_profile.php?u_id=<?php echo $message_sender;?>"><?php echo $sender_name;?></a></h3> 
		<p id="messages_date"><?php echo $message_date;?></p>
		<p id="messages_body"><?php echo $message_body;?></p>
		<a href="my_messages.php?inbox&message_id=<?php echo $message_id;?>" style="float:right;"><button>Reply</button></a>

	
		
		</div><br/>
	
			
		<?php } ?>
		
		<?php
		    if(isset($_GET['message_id'])) {
		    
		    $get_id = $_GET['message_id'];
		    
		    $sel_message = "select * from messages where message_id='$get_id'";
			$run_message = mysqli_query($con,$sel_message); 
			
			$row_message=mysqli_fetch_array($run_message); 
			
			$message_body = $row_message['message_body']; 
			$reply_body = $row_message['reply'];
			
			//updating the unread message to read
			$update_unread="update messages set status='read' where message_id='$get_id'"; 
			$run_unread = mysqli_query($con,$update_unread);
			

			
			echo "<center><br/><hr>
			
			<p><b>$sender_name:</b> $message_body</p>
			<p><b>My Reply:</b> $reply_body</p>
			
			<form action='' method='post'>
				<textarea cols='30' rows='5' name='reply'></textarea><br/>
				<input type='submit' name='message_reply' value='Reply to this'/> 
			</form>
			</center>
			";
			}
			
			if(isset($_POST['message_reply'])){
			
				
			
			$user_reply = nl2br(addslashes($_POST['reply']));
			$user_reply = wordwrap($user_reply,68,"<br />",TRUE);
				
			if($user_reply==''){
			
			echo "<p>*Please enter the reply</p>";
			
			exit();
			
			}
			else {
			
			    if($reply_body != 'no_reply') {
			        echo "<p>*This message was already replied</p>";
			        exit();
			    }
			    
			    else {
			    
				$update_msg = "update messages set reply='$user_reply' where message_id='$get_id' AND reply='no_reply'";
				
				$run_update = mysqli_query($con,$update_msg);
				
				echo "<h2 align='center'> Message is replied!</h2>";
				
				}
			
		}
		}
		}
		
		?>
		
		
		
		
				</div>
				<!--Content timeline ends-->
				
                </div>
				
			</div>
	</div>
	<!--Container ends-->

					
	

    
    </body>
</html>
<?php } ?>
