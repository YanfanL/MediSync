<?php
session_start();
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'project_final';
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if ( mysqli_connect_errno() ) {
	header("Location: index.php?login=sqlfail");
	exit();
}
if ( !isset($_POST['username'], $_POST['password']) ) {
	header("Location: index.php?login=missingvalues");
	exit();
}
if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ? and superuser = 1')) {
	$stmt->bind_param('s', $_POST['username']);
	$stmt->execute();
	$stmt->store_result();
	
	if ($stmt->num_rows > 0) {
		$stmt->bind_result($id, $password);
		$stmt->fetch();
		if (password_verify($_POST['password'], $password)) {
			session_regenerate_id();
			$_SESSION['loggedin'] = TRUE;
			$_SESSION['name'] = $_POST['username'];
			$_SESSION['id'] = $id;
			header('Location: home.php');
		} else {
			header("Location: index.php?login=incorrect&username=".$_POST['username']);
		}
	} else {
		header("Location: index.php?login=incorrect&username=".$_POST['username']);
	}
	
	$stmt->close();
}
?>