<!DOCTYPE html>
<html>
	<head>
		<title>Doctor Appointment Booking System</title>
		<link rel="stylesheet" href="../style.css">
	</head>
	<body>
		<?php
		$username = '';
		$message = '';
		$type = '';

		if ($_GET['username'] ?? null) $username = $_GET['username'];

		if(isset($_GET['login']))
		{
			$type = 'login';
			if($_GET['login'] == 'sqlfail')
			{
				$message = '<h6 class="error">*Failed to connect to MySQL</h6>';
			}
			else if ($_GET['login'] == 'missingvalues')
			{
				$message = '<h6 class="error">*Please input all required values</h6>';
			}
			else if ($_GET['login'] == 'incorrect')
			{
				$message = '<h6 class="error">*Incorrect username and/or password</h6>';
			}
		}
		else if(isset($_GET['register']))
		{
			$type = 'register';
			if($_GET['register'] == 'connectionfailed')
			{
				$message = '<h6 class="error">*Failed to connect to MySQL</h6>';
			}
			else if ($_GET['register'] == 'incomplete')
			{
				$message = '<h6 class="error">*Please complete the registration form</h6>';
			}
			else if ($_GET['register'] == 'empty')
			{
				$message = '<h6 class="error">*Please complete the registration form</h6>';
			}
			else if ($_GET['register'] == 'invalidusername')
			{
				$message = '<h6 class="error">*Invalid Username</h6>';
			}
			else if ($_GET['register'] == 'retypepass')
			{
				$message = '<h6 class="error">*Passwords do not match</h6>';
			}
			else if ($_GET['register'] == 'passwordlength')
			{
				$message = '<h6 class="error">*Password must be between 5 and 20 characters long</h6>';
			}
			else if ($_GET['register'] == 'userexist')
			{
				$message = '<h6 class="error">*Username exists, please choose another</h6>';
			}
			else if ($_GET['register'] == 'failed')
			{
				$message = '<h6 class="error">*Signup Failed</h6>';
			}
			else if ($_GET['register'] == 'success')
			{
				$message = '<h6 class="success">*Signup Successful. Please login</h6>';
			}
		}
		?>
		<div class="hero">
			<div class="form-box">
				<div class="button-box">
					<div id="button"></div>
					<button type="button" class="toggle-button" onclick="login()">Login</button>
					<button type="button" class="toggle-button" onclick="register()">Register</button>
				</div>
				<form id="login" class="input-group" action="login.php" method="post">
					<input type="text" class="input-field" placeholder="Username" name="username" required value=<?php echo $username; ?>>
					<input type="password" class="input-field" placeholder="Password" name="password" required>
					<?php if ($type == 'login') echo $message; ?>
					<button type="submit" class="submit-button">Login</button>
				</form>
				<form id="register" class="input-group" action="register.php" method="post">
					<input type="text" class="input-field" placeholder="Username" name="username" required value=<?php echo $username; ?>>
					<input type="email" class="input-field" placeholder="Email" name="email" required>
					<input type="password" class="input-field" placeholder="Password" name="password" required>
					<input type="password" class="input-field" placeholder="Repeat Password" name="retypepassword" required>
					<?php if ($type == 'register') echo $message; ?>
					<input type="submit" class="submit-button" value="Register">
				</form>
			</div>
		</div>
		<script>
			var x = document.getElementById("login");
			var y = document.getElementById("register");
			var z = document.getElementById("button");

			function register() {
				x.style.left = "-400px"
				y.style.left = "50px"
				z.style.left = "110px"
			}
			
			function login() {
				x.style.left = "50px"
				y.style.left = "450px"
				z.style.left = "0"
			}
		</script>
		<?php 
		if ($type == 'register') echo '<script type="text/javascript"> register(); </script>';
		else if ($type == 'login') echo '<script type="text/javascript"> login(); </script>';
		?>
	</body>
</html>