<table align-"center" width="750" bgcolor="skyblue">

	<tr bgcolor= "orange" border="1px">
		<th>S.N</th>
		<th>First Name</th>
		<th>Last Name</th>
		<th>Image</th>
		<th>Delete</th>
		<th>Edit</th>
	</tr>
	
	<?php
	include("includes/connection.php");
	$sel_users = "select * from user ORDER by 1 DESC";
	$run_users = mysqli_query($con, $sel_users);
	
	$i=0;
	while($row_users = mysqli_fetch_array($run_users)) {
		
		$user_id = $row_users['user_id'];
		$first_name = $row_users['first_name'];
		$last_name = $row_users['last_name'];
		$user_image = $row_users['user_image'];
		$user_reg = $row_users['register_date'];
		$i++;
	
	
	?>
	
	<tr align="center">
	
	<td><?php echo $i; ?></td>
	<td><?php echo $first_name; ?></td>
	<td><?php echo $last_name; ?></td>
	<td><img src="../user/user_images/<?php echo $user_image;?>" width='50' height='50'/></td>
	<td><a href="delete_user.php?delete=<?php echo $user_id; ?>">Delete</a></td>
	<td><a href="index.php?view_users&edit=<?php echo $user_id; ?>">Edit</a></td>
	</tr>
	<?php } ?>
</table>

<?php
	
	if(isset($_GET['edit'])) {
	$edit_id = $_GET['edit'];
	$sel_users = "select * from user where user_id='$edit_id'";
	$run_users = mysqli_query($con, $sel_users);

	$row_users = mysqli_fetch_array($run_users);
		
		$user_id = $row_users['user_id'];
		$first_name = $row_users['first_name'];
		$last_name = $row_users['last_name'];
		$user_image = $row_users['user_image'];
		$user_reg_date = $row_users['register_date'];
		$user_email = $row_users['user_email'];
		$user_pass = $row_users['user_pass'];
		
	
	
	
	
?>
				<form action="" method="post" enctype="multipart/form-data">
				
					<table>
					
					
					<p>CHANGE YOUR PASSWORD:</p><br />
					Your Old Password: <input type="password" name="oldpassword" size="25" placeholder="Old Password" /><br /><br />
					Your New Password: <input type="password" name="newpassword" size="25" placeholder="New Password" /><br /><br />
					Re-Enter New Password: <input type="password" name="newpassword2" size="25" placeholder="New Password" /><br /><br />
                    <input type="submit" name="update_pass" value="Update Password!">
					<hr /><p>UPDATE YOUR PROFILE INFO:</p><br />
					First Name: <input type="text" name="fname" size="25" value="<?php echo $first_name?>" /><br /><br />
					Last Name: <input type="text" name="lname" size="25" value="<?php echo $last_name?>" /><br /><br />
					Profile Image: <input type="file" name="u_image"/><br /><br />	
					<input type="submit" name="update" value="Update Info!">																											
					</table>
				</form>
				
			<?php } ?>
<?php 

    // Update Password
	if(isset($_POST['update_pass'])){
	
	    $old_password = $_POST['oldpassword'];
	    $new_password = $_POST['newpassword'];
	    $new_password2 = $_POST['newpassword2'];
	    
	    $password_check = "select * from user where user_id = '$user_id'";
	    $password_query = mysqli_query($con, $password_check);
	    while ($row = mysqli_fetch_assoc($password_query)) {
	        $db_password = $row['user_pass'];
	        
	        // check wheather old password equals $db_password
	        if ($old_password == $db_password) {
	        
	            //check whether 2 new passwords match
	            if ($new_password == $new_password2) {
	            
	                
	                
                $update = "update user set user_pass = '$new_password', user_pass2 = '$new_password2' where user_id='$user_id'";
                
                $run = mysqli_query($con,$update) 
                or die("Error: ".mysqli_error($con));
        
                if($run){
        
                echo "<script>alert('Your Profile Updated!')</script>";
                echo "<script>window.open('index.php?view_users','_self')</script>";
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
	            echo "The old password is incorrect";
	        }
	    }
	}
	
    // Update User Info
	if(isset($_POST['update'])){
        $f_name = $_POST['fname'];
        $l_name = $_POST['lname'];
        
		$u_image = $_FILES['u_image']['name'];
		$image_tmp = $_FILES['u_image']['tmp_name'];
		
		
		move_uploaded_file($image_tmp,"../user/user_images/$u_image");
		
		$update = "update user set first_name='$f_name', last_name='$l_name', user_image='$u_image' where user_id='$user_id'";
		
		$run = mysqli_query($con,$update)
		or die("Error: ".mysqli_error($con));; 
		
		if($run){
		
		echo "<script>alert('Your Profile Updated!')</script>";
		echo "<script>window.open('index.php?view_users','_self')</script>";
		
		}
	
	}


?>


