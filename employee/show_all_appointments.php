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

$query = "SELECT * FROM doctors";
$statement = mysqli_query($con, $query);
?>

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
    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }
    table, th, td {
        border: 1px solid #ddd;
    }
    th, td {
        padding: 12px;
        text-align: left;
    }
    th {
        background-color: #f2f2f2;
    }
    input[type="text"], input[type="number"], input[type="email"], textarea, select {
        padding: 10px;
        margin: 5px 0 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        width: 100%;
        box-sizing: border-box;
    }
    input[type="submit"], .back_btn {
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
    input[type="submit"]:hover, .back_btn:hover {
        background: #4cae4c;
    }
    footer {
        text-align: center;
        padding: 10px 0;
        background: #f4f4f4;
        border-top: 1px solid #ccc;
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

        // Activate the "Current Appointments" tab by default
        tabs[0].classList.add('active');
        tabContents[0].classList.add('active');
    });
</script>

<div class="container">
    <div class="tabs">
        <div class="tab active" data-target="appointments">Current Appointments</div>
    </div>

    <div class="tab-content active" id="appointments">
        <h2>Current Appointments</h2>

        <form action="show_all_appointments.php" method="post">
            <table>
                <tr>
                    <th>Doctor Name</th>
                    <th>Time</th>
                    <th>Patient First Name</th>
                    <th>Patient Last Name</th>
                    <th>Day</th>
                    <th>Select</th>
                </tr>

                <?php
                $query2 = "SELECT Time, Day, doctors.doctorName, registration.lname, registration.fname 
                           FROM Availability 
                           INNER JOIN doctors ON Availability.medicalLicence = doctors.medicalLicence 
                           INNER JOIN registration ON Availability.healthNo = registration.healthNo 
                           WHERE Status = 'Reserved'";
                $statement = mysqli_query($con, $query2);
                $array1 = array();
                $array2 = array();
                $count = 0;
                while ($row = $statement->fetch_assoc()) {
                    $doctor = $row['doctorName'];
                    $patientFname = $row['fname'];
                    $patientLname = $row['lname'];
                    $time = $row['Time'];
                    $array1[$count] = $doctor;
                    $array2[$count] = $time;

                    echo "<tr>";
                    echo "<td>" . $row['doctorName'] . "</td>";
                    echo "<td>" . $row['Time'] . "</td>";
                    echo "<td>" . $row['fname'] . "</td>";
                    echo "<td>" . $row['lname'] . "</td>";
                    echo "<td>" . $row['Day'] . "</td>";
                    echo "<td><input type='checkbox' name='check' value='$count'></td>";
                    echo "</tr>";
                    $count++;
                }
                ?>
            </table>
            <input name='book' type='submit' value='Delete Appointment'>
        </form>

        <?php
        if (isset($_POST['book'])) {
            $checked = $_POST['check'];
            $doctorNam = $array1[$checked];
            $timing = $array2[$checked];
            $query3 = "UPDATE Availability 
                       SET Status = 'Available' 
                       WHERE Time ='$timing' AND medicalLicence IN (
                           SELECT Availability.medicalLicence 
                           FROM Availability 
                           INNER JOIN doctors ON Availability.medicalLicence = doctors.medicalLicence 
                           WHERE doctors.doctorName = '$doctorNam'
                       )";
            $statement2 = mysqli_query($con, $query3);

            if ($statement2) {
                echo '<script type="text/javascript">alert("Appointment Deleted")</script>';
            }
        }
        ?>
    </div>
</div>

<footer><?php include 'footer.php'; ?></footer>
