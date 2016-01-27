<?php
	include("includes/connection.php");
		if(isset($_POST['reg'])) {

        //registration form
        $f_name = mysqli_real_escape_string($con, $_POST['fname']);
        $l_name = mysqli_real_escape_string($con, $_POST['lname']);
        $u_email = mysqli_real_escape_string($con, $_POST['email']);
        $u_email2 = mysqli_real_escape_string($con, $_POST['email2']);
        $u_pass = mysqli_real_escape_string($con, $_POST['password']);
        $u_pass2 = mysqli_real_escape_string($con, $_POST['password2']);
        
        $status = "unverified";
        $posts = "NULL";

        $verification_code = mt_rand();

        
            
 		$get_email = "SELECT * FROM user WHERE user_email='$u_email'";
		$run_email = mysqli_query($con, $get_email);
		$check = mysqli_num_rows($run_email);  
		
		if($u_email == $u_email2){         
        
        if($check==0){   
        
        if ($f_name&&$l_name&&$u_email&&$u_email2&&$u_pass&&$u_pass2) {
        
        if(strlen($u_pass)>8){   
        
        if($u_pass == $u_pass2){  
        
        $hashed_pass = password_hash($u_pass, PASSWORD_BCRYPT, array('cost' => 10));  
        
        $insert = "insert into user
        (first_name, last_name, user_email, user_pass, user_image, register_date, last_login, status, ver_code, posts)
        values ('$f_name', '$l_name', '$u_email', '$hashed_pass', 'default.jpg', NOW(), NOW(), '$status', '$verification_code', '$posts')";
        
        $run_insert = mysqli_query($con, $insert)
        or die("Error: ".mysqli_error($con));;
        
        if($run_insert) {
        $_SESSION['user_email']= $u_email;
        
        echo "<h3 style='font-size: 12px; font-family: tahoma; color: black;'>*Hi $f_name, registration is almost complete</h3>
        <p style='color: black;'>We have sent an email to <strong>$u_email</strong>,<br /> please check your<br/> inbox or spam folder for verification!.</p>
        ";
        
        }
        
        
        else {
            echo "<script>alert('Not!')</script>";
            
        }
        
        }  
        
        else {
        echo "Your passwords didn't match!";
        
        } 
        }
        else {
        echo "Password should be minimum 8 characters!";
     
        }
        }
        else {
        echo "Please fill in all of the fields";
 
        }
        }                 
        else {
        echo "Email is already registered, plz try another";
     
        }
        }
            
        else {
        echo "Your emails didn't match!";

        }
        
        
        $to = $u_email;
        $subject = "Verify your email address."; 
        
        $message = "
        <html> 
                Hello <strong>$f_name</strong>, you have just created an account on www.safepunjab.com<br /> Please verify your email address by clicking below link:<br /><br />
                <a href='http://www.safepunjab.com/verify.php?code=$verification_code'>Click to Verify Your Email</a><br/> 
                <strong>Thank you for creating an account!</strong>
        </html> 
        ";
        
        // Always set content-type when sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From: <registration@safepunjab.com>' . "\r\n";

        mail($to,$subject,$message,$headers);

        
        }

	
        
        
        



?>