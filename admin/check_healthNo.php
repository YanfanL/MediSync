<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project_final";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['healthNo'])) {
    $healthNo = $_GET['healthNo'];
    $sql = "SELECT * FROM registration WHERE healthNo='$healthNo'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo 'exists';
    } else {
        echo 'not exists';
    }
}

$conn->close();
?>
