<?php 
	include("includes/connection.php");

    // Update Password
	if(isset($_POST['update_password'])){

	    $new_password = mysqli_real_escape_string($con, $_POST['newpassword']);
	    $new_password2 = mysqli_real_escape_string($con, $_POST['newpassword2']);
	    
	
	        
	            //check whether 2 new passwords match
	            if ($new_password == $new_password2) {
	            
	                
	                
                $update = "update user set user_pass = '$new_password' AND passreset = '0' where user_id='$user_id'";
                
                $run = mysqli_query($con,$update) 
                or die("Error: ".mysqli_error($con));
        
                if($run){
        
                echo "<script>alert('Your Password Updated!')</script>";
                
                }
        
                else {
                    echo "error";
                }
	            }
	            else {
	                echo "Your new passwords doesn't match";
	            }
	        
	        
	        }

	    }
	}
	
?>