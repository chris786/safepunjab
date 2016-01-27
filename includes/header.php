<?php 
include ("includes/connection.php"); 

if (!isset($_SESSION["user_email"])) {

}
else 
{
("location: home.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>SafePunjab - Log In or Sign Up</title>
    <meta name="description" content="Meta description goes here.">
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
				<form method="post" action="" id="form1">
					<strong style="color:white; font-family:tahoma">Email:</strong>
					<input type="email" name="u_email" placeholder="Email" required="required"/>
					<strong style="color:white; font-family:tahoma">Password:</strong>
					<input type="password" name="u_pass" placeholder="********" required="required"/>
					
					<button name="login">Login</button><br/>
					<a href="forgot_password.php">Forgot your password?</a>
				</form>
			</div>
			<!--Header ends-->
		</div>
		<!--Head wrap ends-->