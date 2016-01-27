                <div id="content_timeline">
                

				<p>My Messages:</p><hr />
				

				
			<?php 
		
		$sel_msg = "select * from messages where sender='$user_id' ORDER by 1 DESC"; 
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
		<a href="my_messages.php?sent&message_id=<?php echo $message_id;?>" style="float:right;"><button>View Reply</button></a>

	
		
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
			

			
			echo "<center><br/><hr>
			
			<p><b>$sender_name:</b> $message_body</p>
			<p><b>Their Reply:</b> $reply_body</p>
			

			</center>
			";
			}
			

		
		?>
		
		
		
		
				</div>
				<!--Content timeline ends-->
				