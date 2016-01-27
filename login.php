
<?php
if (!isset($_SESSION["user_email"])) {

}
else 
{
("location: home.php");
}

	include("includes/connection.php");
		if(isset($_POST['login'])) {

			$u_email = mysqli_real_escape_string($con,$_POST['u_email']);
			$u_pass = mysqli_real_escape_string($con,$_POST['u_pass']);

			$get_user = "select * from user where user_email='$u_email' AND status='verified'";
			$run_user = mysqli_query($con,$get_user);
			$row_user=mysqli_fetch_array($run_user);

			if(password_verify($u_pass, $row_user['user_pass'])){
				$_SESSION['user_email']=$u_email;
				echo "<script>window.open('home.php', '_self')</script>";
			}
			
			
			else {
				echo "<script>alert('Password or email is not correct!')</script>";
			}
			

		}
?>