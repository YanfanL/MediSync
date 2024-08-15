<!DOCTYPE html>
<?php include 'header.php'; 
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.php');
	exit;
}
 ?>
<div>
 
<body>
<div class="container">

<h1> Welcome to the homepage of Northwest Clinic </h1>

<h2> Only taking appointments for upcoming week due to high volume </h2>

<h3>
	Clinic Timings
</h3>

<table id = 'book'>
	<tr>
		<th>
			Days
		</th>
		<th>
			Timings
		</th>
	</tr>
	<tr>
		<td>
		Monday
		</td>
		<td>
			10:00 AM - 6:00 PM
		</td>
	</tr>

	<tr>
		<td>
		Tuesday
		</td>
		<td>
			10:00 AM - 6:00 PM
		</td>
	</tr>

<tr>
		<td>
		Wednesday
		</td>
		<td>
			10:00 AM - 6:00 PM
		</td>
	</tr>

	<tr>
		<td>Thursday</td>		
		<td>10:00 AM - 6:00 PM</td>
	</tr>

<tr>
		<td>
		Friday
		</td>
		<td>
			10:00 AM - 6:00 PM
		</td>
	</tr>

<tr>
		<td>
		Saturday
		</td>
		<td>
			10:00 AM - 6:00 PM
		</td>
	</tr>

<tr>
		<td>
		Sunday
		</td>
		<td>
			10:00 AM - 6:00 PM
		</td>
	</tr>

</table>
	
	<br>

</body>
    <center>
    </center>
</div>
</body>

<footer><?php include 'footer.php'; ?>
</footer>
 
</html>