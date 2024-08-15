<?php include('header.php'); ?>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }
    .container {
        width: 80%;
        margin: auto;
        background: white;
        padding: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        margin-top: 30px;
        border-radius: 8px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    h2 {
        text-align: center;
        color: #333;
        margin-bottom: 20px;
    }
    form {
        display: flex;
        flex-direction: column;
    }
    label {
        margin: 10px 0 5px;
        font-weight: bold;
    }
    input[type="text"], input[type="number"], input[type="email"], textarea, select {
        padding: 10px;
        margin: 5px 0 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        width: 100%;
        box-sizing: border-box;
    }
    input[type="submit"] {
        padding: 10px;
        background: #5cb85c;
        border: 0;
        border-radius: 4px;
        color: white;
        font-weight: bold;
        cursor: pointer;
        width: 100%;
        margin-top: 20px;
    }
    input[type="submit"]:hover {
        background: #4cae4c;
    }
    footer {
        text-align: center;
        padding: 10px 0;
        background: #f4f4f4;
        border-top: 1px solid #ccc;
    }
</style>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project_final";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$patient = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $healthNo = $_POST['healthNo'];
    $email = $_POST['email'];
    $phoneNo = $_POST['phoneNo'];
    $address = $_POST['address'];
    $gender = $_POST['gender'];

    $sql = "UPDATE registration SET fname='$fname', lname='$lname', email='$email', phoneNo='$phoneNo', address='$address', gender='$gender' WHERE healthNo='$healthNo'";

    if ($conn->query($sql) === TRUE) {
        echo "<div class='container'><p style='color: green;'>Patient updated successfully</p></div>";
        echo "<script>setTimeout(function(){ window.location.href = 'register_patient.php'; }, 2000);</script>";
    } else {
        echo "<div class='container'><p style='color: red;'>Error: " . $sql . "<br>" . $conn->error . "</p></div>";
    }
} else {
    $healthNo = $_GET['healthNo'];
    $sql = "SELECT * FROM registration WHERE healthNo='$healthNo'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $patient = $result->fetch_assoc();
    }
}

$conn->close();
?>

<div class="container">
    <h2>Edit Patient</h2>
    <?php if ($patient): ?>
        <form action="edit_patient.php" method="post">
            <input type="hidden" name="healthNo" value="<?php echo $patient['healthNo']; ?>">
            <label for="fname">First Name:</label>
            <input type="text" id="fname" name="fname" value="<?php echo $patient['fname']; ?>" required>
            
            <label for="lname">Last Name:</label>
            <input type="text" id="lname" name="lname" value="<?php echo $patient['lname']; ?>" required>
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $patient['email']; ?>" required>
            
            <label for="phoneNo">Phone Number:</label>
            <input type="text" id="phoneNo" name="phoneNo" value="<?php echo $patient['phoneNo']; ?>" required>
            
            <label for="address">Address:</label>
            <textarea id="address" name="address" required><?php echo $patient['address']; ?></textarea>
            
            <label for="gender">Gender:</label>
            <select id="gender" name="gender" required>
                <option value="Male" <?php echo $patient['gender'] == 'Male' ? 'selected' : ''; ?>>Male</option>
                <option value="Female" <?php echo $patient['gender'] == 'Female' ? 'selected' : ''; ?>>Female</option>
            </select>
            
            <input type="submit" name="update" value="Update">
        </form>
    <?php else: ?>
        <p>No patient found with the given Health Number.</p>
    <?php endif; ?>
</div>

<footer>
    <?php include('footer.php'); ?>
</footer>
