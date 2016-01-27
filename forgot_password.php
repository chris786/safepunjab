<?php

$con = mysqli_connect("localhost", "tworntcx_safepun", "N4hpz*+g=hD0", "tworntcx_safepunjab") or die("Connection was not established");

?>

<!DOCTYPE html>
<html>
<head>
    <title>safePunjab</title>
    <link rel="stylesheet" href="styles/style.css" media="all"/>
</head>


<body>
	<!--container starts-->
	<div class="container">
		<!--Head wrap starts-->
		<div id="head_wrap">
			<!--Header starts-->
			<div id="header">
				<div class="logo">
				<a href="http://www.safepunjab.com/index.php"><img src="images/logo.png" style="float:left"/></a>
				</div>

			</div>
			<!--Header ends-->
			

			
		</div>
		<!--Head wrap ends-->
		
		<div id="form3">
		        
				<form method="post" action="">
					<span style="font-family:tahoma; text-decoration: none"><h3>PLEASE ENTER YOUR REGISTERED EMAIL: </h3><br /><br />
					Your Email<strong style="color:white; font-family:tahoma">Email:</strong>
					<input type="email" name="email" placeholder="Email" required="required"/><br/><br/>
                    	
					<button name="submit">Submit</button>
					<button name="cancel">Cancel</button></span>
				</form>
				
				
				
		
		</div>
		
<?php


        if(isset($_POST['submit'])) {
            global $con;
            
		

			$email = mysqli_real_escape_string($con,$_POST['email']);

			$get_user = "select * from user where user_email='$email'";
			$run_user = mysqli_query($con,$get_user);
			$check=mysqli_num_rows($run_user);

			if($check == 1){
			    global $con;
				
				while($row_user = mysqli_fetch_assoc($run_user)){
				    $db_email = $row_user['user_email'];
				    $f_name = $row_user['first_name'];
				
				if($email == $db_email) {
				    $code = rand(10000, 1000000);
				    
				    

        $to = $db_email;
        $subject = "Password Reset"; 
        
        $message = "
        <html> 
                Hello <strong>$f_name!</strong>
                This is an automated email. Please DO NOT reply to this email.
                Click the link below or paste it into your browser to reset your password <br /><br />
                
                <a href='http://www.safepunjab.com/password_recovery.php?code=$code'>Click to Reset your password</a><br/> 
                
 
        </html> 
        ";
        
        // Always set content-type when sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From: <forgotpassword@safepunjab.com>' . "\r\n";

        			    
				    
                    $update = "update user set passreset='$code' where user_email='$email'";
        
                    $run = mysqli_query($con,$update); 
                    
                    mail($to,$subject,$message,$headers);	
                    
                    echo "Check your email";
				}
				
			}
			}
			
			
			else {
				echo "Coudn't find that email";
			}
			

		}

if(isset($_POST['cancel'])) {
    echo "<script>window.open('index.php', '_self')</script>";
    }


?>
		
</body>
</html>