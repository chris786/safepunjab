		<div id="content">
			<div>
				<div class="image">
				<img src="images/image.png" style="float:left; margin-right:40px;"/>
				</div>
				
			</div>
			<div id="form2">
				<form action="" method="post">
				<h2>Sign Up Here!</h2>
					<table>
					<input type="text" name="fname" size="25" placeholder="First Name" /><br /><br />
					<input type="text" name="lname" size="25" placeholder="Last Name" /><br /><br />
					
					<input type="email" name="email" size="25" placeholder="Email Address" /><br /><br />
					<input type="email" name="email2" size="25" placeholder="Confirm Email" /><br /><br />
					<input type="password" name="password" size="25" placeholder="Password" /><br /><br />
					<input type="password" name="password2" size="25" placeholder="Confirm Password" /><br /><br />
					

                    <p>By clicking Sign Up, you agree to our <a href="privacy_policy.html">Privacy Policy</a> and<br /> <a href="terms_conditions.html">Terms & Conditions</a>.</p>		
						
					<input type="submit" name="reg" value="Sign Up!">																											
					</table>
				</form>
				<?php
				include("sign_up.php");
				?>
			</div>
		</div>
		<!--Content area ends-->