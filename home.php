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

<h2> Welcome to the homepage of Northwest Clinic </h2>

<h3> Please find details below and use the system to help out incoming patients<h3>

    <h> <a href="register_patient.php">Register new patient </a></h>
<h2> Only taking appointments for upcoming week due to high volume </h2>

<h2>
	Clinic Timings
</h2>

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
			10:00 AM - 5:00 PM
		</td>
	</tr>

<tr>
		<td>
		Sunday
		</td>
		<td>
			11:00 AM - 4:00 PM
		</td>
	</tr>

</table>
	
	<br>

<H3> Working days for doctors </H3>

<ul>
	<li>
		Dr. 0 works Monday - Wednesday
	</li>
	<li>
		Dr. 1 works Tuesday - Saturday		
	</li>
	<li>
		Dr. 2 works Monday - Friday		
	</li>

	<li>
		Dr. 3 works Wednesday - Sunday		
	</li>

	<li>
		Dr. 4 works Thursday - Monday
	</li>

</ul>

 <a href='doctor_add_form.php'>Submit new doctor application</a>

<br>
<br>
</body>
    <center>
    </center>
</div>
</body>

<?php include 'footer.php'; ?>

 
</html>