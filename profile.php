<?php include( "home.php" ); ?>
<?php
if (isset($_GET['u'])) {
	$u_email = mysqli_real_escape_string($con, ($_GET['u']));
	if (ctype_alnum($u_email)) {
		//check user exists
		$check = mysqli_query("SELECT first_name FROM user WHERE user_email='$u_email'");
		if (mysqli_num_rows($check)===1) {
		$get = mysqli_fetch_assoc($check);
		
		$f_name = $get['first_name'];	
		}
		else
		{
			echo "no";
			exit();
		}
	}
}
?>
<h2>Profile page for: <?php echo "$first_name"; ?></h2>
