<?php 
	include("includes/connection.php");
	
	
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
		


<?php	
	
	if(isset($_GET['code'])){
		
	


		$get_code = $_GET['code']; 
		
		$get_user = "select * from user where passreset='$get_code'"; 
		
		$run_user = mysqli_query($con,$get_user); 
		
		$check_user = mysqli_num_rows($run_user); 
		
		$row_user=mysqli_fetch_array($run_user); 
		
		$user_id = $row_user['user_id'];
		$f_name = $row_user['first_name'];		
		
		if($check_user==1){
		
		echo"
			<div id='form2'>
				<form action='' method='post' enctype='multipart/form-data'>
				
					<table>
					
					<span style='font-family:tahoma'>	
					
					
					UPDATE YOUR PASSWORD:<br /><br />
					
					
					
					Your New Password: <input type='password' name='newpass' size='25' placeholder='New Password' /><br /><br />
					Re-Enter New Password: <input type='password' name='newpass2' size='25' placeholder='New Password' /><br /><br />
                    <input type='submit' name='update_password' value='Update Password!'><br /><br /></span></table>
                    		</form>
                    </div>";
                    
			
		
		}
		else {
		echo "<h2>Sorry, Email not verified, try again!</h2>";
		}
		
	}

?>
<?php

    // Update Password
	if(isset($_POST['update_password'])){

	    $new_pass = mysqli_real_escape_string($con, $_POST['newpass']);
	    $new_pass2 = mysqli_real_escape_string($con, $_POST['newpass2']);
	    
		$get_code = $_GET['code']; 		

		$get_user = "select * from user where passreset = '$get_code'"; 
		
		$run_user = mysqli_query($con,$get_user); 
		
		$check_user = mysqli_num_rows($run_user); 
		
		$row_user=mysqli_fetch_array($run_user); 
		
		$user_id = $row_user['user_id'];
		$f_name = $row_user['first_name'];
		
		if($check_user==1){
	        
	            //check whether 2 new passwords match
	            if ($new_pass == $new_pass2) {
	            
	              
	            $hash_pass = password_hash($new_pass, PASSWORD_BCRYPT, array('cost' => 10));   
	                
                $update = "update user set user_pass = '$hash_pass', passreset = '0' where user_id='$user_id'";
	                
	             
                
                
                $run = mysqli_query($con,$update) 
                or die("Error: ".mysqli_error($con));
        
                if($run){
        
                echo "<script>alert('Yor password has been updated!')</script>";
                echo "<script>window.open('index.php', '_self')</script>";
                
                }
        
                else {
                    echo "error";
                }
	            }
	            else {
	                echo "Your new passwords doesn't match";
	            }
	        }
	        
		else {
		echo "<h2>Sorry, Email not found!</h2>";
		}
	        
	}
?>

</body>
</html>