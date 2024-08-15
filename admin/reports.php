<?php include('header.php'); 

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project_final";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->close();
?>

<div class="container">
<h2>Quick reports</h2> 
<h4>Number of available appointments per doctor - <a href='available_appointments_per_doctors.php'>available appointments per doctors</a></h4>
<h4>Number of booked appointments per doctor - <a href='booked_appointments_per_doctors.php'>booked appointments per doctors</a></h4>
<h4>Number of available appointments per day - <a href='available_appointments_perday.php'>available appointments per day</a></h4>
<h4>Number of booked appointments per day - <a href='booked_appointments_perday.php'>booked appointments per day</a></h4>


</div>

<footer><?php include 'footer.php'; ?>
</footer>

</body>

</html>