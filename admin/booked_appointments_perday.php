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
    input[type="text"], input[type="number"], input[type="email"], textarea, select {
        padding: 10px;
        margin: 5px 0 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        width: 100%;
        box-sizing: border-box;
    }
    input[type="submit"], .edit-btn {
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
    input[type="submit"]:hover, .edit-btn:hover {
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

    // Handle form submission to filter results by selected day
    $selected_day = isset($_POST['day']) ? $_POST['day'] : '';
    $sql = "SELECT COUNT(*) AS count FROM `availability` WHERE `Day` = '$selected_day' AND `Status` = 'Reserved'";

    if ($selected_day) {
        $result = $con->query($sql);
        $row = $result->fetch_assoc();
        $appointment_count = $row['count'];
    } else {
        $appointment_count = 0;
    }

    ?>
			<div class="container">

    <!-- Dropdown form -->
    <form method="post" class="form_user_reports">
        <label for="day">Select Day:</label>
        <select name="day" id="day">
            <option value="">Select a day</option>
            <option value="Monday" <?php echo ($selected_day == 'Monday') ? 'selected' : ''; ?>>Monday</option>
            <option value="Tuesday" <?php echo ($selected_day == 'Tuesday') ? 'selected' : ''; ?>>Tuesday</option>
            <option value="Wednesday" <?php echo ($selected_day == 'Wednesday') ? 'selected' : ''; ?>>Wednesday</option>
            <option value="Thursday" <?php echo ($selected_day == 'Thursday') ? 'selected' : ''; ?>>Thursday</option>
            <option value="Friday" <?php echo ($selected_day == 'Friday') ? 'selected' : ''; ?>>Friday</option>
            <option value="Saturday" <?php echo ($selected_day == 'Saturday') ? 'selected' : ''; ?>>Saturday</option>
            <option value="Sunday" <?php echo ($selected_day == 'Sunday') ? 'selected' : ''; ?>>Sunday</option>
        </select>
        <input type="submit" value="Submit">
    </form>

    <!-- Display the number of appointments -->
    <?php
    if ($selected_day) {
        echo "<p>Number of booked appointments on $selected_day: $appointment_count</p>";
    }
    ?>

</div>

<footer><?php include 'footer.php'; ?>
</footer>

</body>

</html>