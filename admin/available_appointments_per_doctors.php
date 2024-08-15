<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Reports</title>

</head>
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

    form {
        display: flex;
        flex-direction: column;
    }

    label {
        margin: 10px 0 5px;
        font-weight: bold;
    }

    input[type="text"],
    input[type="number"],
    input[type="email"],
    textarea,
    select {
        padding: 10px;
        margin: 5px 0 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        width: 100%;
        box-sizing: border-box;
    }

    input[type="submit"],
    .edit-btn {
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

    input[type="submit"]:hover,
    .edit-btn:hover {
        background: #4cae4c;
    }

    .search-results {
        margin-top: 20px;
        background: #f9f9f9;
        padding: 10px;
        border-radius: 4px;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        max-height: 300px;
        overflow-y: auto;
    }

    .search-results h3 {
        margin-top: 0;
    }

    .result-card {
        background: #fff;
        padding: 10px;
        border-radius: 4px;
        margin-bottom: 10px;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        transition: background-color 0.3s, box-shadow 0.3s;
    }

    .result-card:hover {
        background-color: #f0f0f0;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    }

    .result-card p {
        margin: 5px 0;
        color: #333;
    }

    footer {
        text-align: center;
        padding: 10px 0;
        background: #f4f4f4;
        border-top: 1px solid #ccc;
    }
</style>

<body class="user_report_container">

    <?php include 'header.php'; ?>
    <!-- php section -->
    <?php

    //database connection parameters
    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'root';
    $DATABASE_PASS = '';
    $DATABASE_NAME = 'project_final';

    //connect to database using mysqli
    $con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
    //check sql connection 
    if ($con->connect_error) {
        die('Connection Failed' . $con->connect_error);
    }

    // Handle form submission to filter results by selected doctor
    $selected_doctor = isset($_POST['doctor']) ? $_POST['doctor'] : '';
    $appointment_count = 0;


    if ($selected_doctor) {
        $sql =
            "SELECT doctors.doctorName, COUNT(availability.aptNumber) AS numOfAppointments
        FROM availability
        INNER JOIN doctors
        ON availability.medicalLicence = doctors.medicalLicence
        WHERE doctors.doctorName = '$selected_doctor' AND status = 'available'
        GROUP BY doctors.doctorName";

        $result = $con->query($sql);
        $row = $result->fetch_assoc();

        if ($result->num_rows > 0)
            $appointment_count = $row['numOfAppointments'];
    } else {
        $appointment_count = 0;
    }
    ?>

    <div class="container">

        <form method="post" class="form_user_reports">

            <label>Select a Doctor</label>
            <select name="doctor">
                <?php
                $query = "select * from doctors";
                $statement = mysqli_query($con, $query);
                while ($doctorname = $statement->fetch_assoc()) {
                    $test = $doctorname["doctorName"];
                    echo "<option>$test</option>";
                }
                ?>
            </select><br>

            <input type="submit" value="Submit">
        </form>
        <?php
        if ($selected_doctor) {
            echo "<p>Number of available appointments for Dr. $selected_doctor: $appointment_count</p>";
        }
        ?>

    </div>

    <footer><?php include 'footer.php'; ?>
    </footer>

</body>

</html>