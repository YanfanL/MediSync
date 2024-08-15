<?php
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.php');
	exit;
}
$con = new mysqli('localhost', 'root', '', 'project_final');
if ($con->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
} else {
    echo "db connected";
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include 'header.php'; ?>

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
    .tabs {
        display: flex;
        cursor: pointer;
        margin-bottom: 20px;
    }
    .tab {
        flex: 1;
        padding: 10px;
        text-align: center;
        background: #eee;
        border-radius: 8px 8px 0 0;
        margin-right: 5px;
        font-weight: bold;
    }
    .tab.active {
        background: #5cb85c;
        color: white;
    }
    .tab-content {
        display: none;
    }
    .tab-content.active {
        display: block;
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
    select, input[type="text"], input[type="file"] {
        padding: 10px;
        margin: 5px 0 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        width: 100%;
        box-sizing: border-box;
    }
    .sign_up_btn {
        padding: 10px;
        background: #5cb85c;
        border: 0;
        border-radius: 4px;
        color: white;
        font-weight: bold;
        cursor: pointer;
        width: 100%;
        margin-top: 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
    }
    .sign_up_btn:hover {
        background: #4cae4c;
    }
    footer {
        text-align: center;
        padding: 10px 0;
        background: #f4f4f4;
        border-top: 1px solid #ccc;
    }
    .links {
        margin: 20px 0;
    }
    .links a {
        color: #5cb85c;
        font-weight: bold;
        text-decoration: none;
        margin-right: 20px;
    }
    .links a:hover {
        text-decoration: underline;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabs = document.querySelectorAll('.tab');
        const tabContents = document.querySelectorAll('.tab-content');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                tabs.forEach(t => t.classList.remove('active'));
                tab.classList.add('active');

                const target = tab.getAttribute('data-target');
                tabContents.forEach(tc => {
                    if (tc.getAttribute('id') === target) {
                        tc.classList.add('active');
                    } else {
                        tc.classList.remove('active');
                    }
                });
            });
        });

        // Activate the "Reset Availability" tab by default
        tabs[0].classList.add('active');
        tabContents[0].classList.add('active');
    });
</script>

<div class="container">
    <div class="tabs">
        <div class="tab active" data-target="reset">Reset Doctor Availability</div>
    </div>

    <div class="tab-content active" id="reset">
        <form action="reset_doctor_availability.php" method="post">
            <label>Select a Doctor</label>
            <select name="doctorName">
                <?php
                $query = "SELECT * FROM doctors";
                $statement = mysqli_query($con, $query);
                while ($doctorname = $statement->fetch_assoc()) {
                    $test = $doctorname["doctorName"];
                    echo "<option>$test</option>";
                }
                ?>
            </select><br><br>
            
            <button name="book" type="submit" class="sign_up_btn">Reset Availability</button><br><br>

            <?php 
            if (isset($_POST['book'])) {    
                $docName = $_POST['doctorName'];
                $query3 = "UPDATE Availability 
                           SET Status = 'Available' 
                           WHERE (Status = 'Reserved' OR Status = 'Unavailable') AND medicalLicence IN (
                               SELECT Availability.medicalLicence 
                               FROM Availability 
                               INNER JOIN doctors ON Availability.medicalLicence = doctors.medicalLicence 
                               WHERE doctors.doctorName = '$docName'
                           )";
                $statement3 = mysqli_query($con, $query3);
                if ($statement3) {
                    echo "Availability reset for '$docName'<br><br>";
                }
            }
            ?>
        </form>
        <div class="links">
            <a href='makeUnavailabletime.php'>Modify Availability</a>
            <a href='create_availability.php'>Create Availability</a>
        </div>
    </div>
</div>

<footer><?php include 'footer.php'; ?></footer>
</html>
