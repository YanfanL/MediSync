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
    table {
        width: 100%;
        border-collapse: collapse;
    }
    table, th, td {
        border: 1px solid #ddd;
    }
    th, td {
        padding: 8px;
        text-align: left;
    }
    th {
        background-color: #f2f2f2;
    }
    .edit-btn {
        padding: 5px 10px;
        font-size: 0.8em;
        background: #5cb85c;
        color: white;
        border-radius: 4px;
        text-decoration: none;
    }
    .edit-btn:hover {
        background: #4cae4c;
    }
    footer {
        text-align: center;
        padding: 10px 0;
        background: #f4f4f4;
        border-top: 1px solid #ccc;
    }
    .error-message {
        color: red;
        margin-top: 5px;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabs = document.querySelectorAll('.tab');
        const tabContents = document.querySelectorAll('.tab-content');
        const healthNoInput = document.getElementById('healthNo');
        const errorMessage = document.getElementById('error-message');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                tabs.forEach(t => t.classList.remove('active'));
                tab.classList.add('active');
                
                const target = tab.getAttribute('data-target');
                tabContents.forEach(tc => {
                    if(tc.getAttribute('id') === target) {
                        tc.classList.add('active');
                    } else {
                        tc.classList.remove('active');
                    }
                });
            });
        });

        healthNoInput.addEventListener('input', function() {
            const healthNo = healthNoInput.value;
            if (healthNo) {
                fetch(`check_healthno.php?healthNo=${healthNo}`)
                    .then(response => response.text())
                    .then(data => {
                        if (data === 'exists') {
                            errorMessage.textContent = 'This health number already exists.';
                        } else {
                            errorMessage.textContent = '';
                        }
                    });
            } else {
                errorMessage.textContent = '';
            }
        });

        // Activate the "Search for Patient" tab by default
        tabs[1].classList.add('active');
        tabContents[1].classList.add('active');
    });
</script>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project_final";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $healthNo = $_POST['healthNo'];
    $email = $_POST['email'];
    $phoneNo = $_POST['phoneNo'];
    $address = $_POST['address'];
    $gender = $_POST['gender'];

    // Check if the health number already exists
    $check_sql = "SELECT * FROM registration WHERE healthNo='$healthNo'";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows > 0) {
        echo "<div class='container'><p style='color: red;'>A patient with this health number already exists.</p></div>";
    } else {
        $sql = "INSERT INTO registration (fname, lname, healthNo, email, phoneNo, address, gender) VALUES ('$fname', '$lname', '$healthNo', '$email', '$phoneNo', '$address', '$gender')";

        if ($conn->query($sql) === TRUE) {
            echo "<div class='container'><p style='color: green;'>New patient registered successfully</p></div>";
            
            // Create folder with the format name+family+healthnumber
            $folder_name = $fname . '-' . $lname . '-' . $healthNo;
            $folder_path = '../patient_files/' . $folder_name;
            
            if (!file_exists($folder_path)) {
                mkdir($folder_path, 0777, true);
                echo "<div class='container'><p style='color: green;'>Folder created: $folder_name</p></div>";
            } else {
                echo "<div class='container'><p style='color: red;'>Folder already exists: $folder_name</p></div>";
            }
          } else {
            echo "<div class='container'><p style='color: red;'>Error: " . $sql . "<br>" . $conn->error . "</p></div>";
        }
    }
}

$search_result = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search'])) {
    $search_fname = $_POST['search_fname'];
    $search_lname = $_POST['search_lname'];
    $search_phoneNo = $_POST['search_phoneNo'];
    $search_healthNo = $_POST['search_healthNo'];

    $conditions = [];
    if (!empty($search_fname)) {
        $conditions[] = "fname LIKE '%$search_fname%'";
    }
    if (!empty($search_lname)) {
        $conditions[] = "lname LIKE '%$search_lname%'";
    }
    if (!empty($search_phoneNo)) {
        $conditions[] = "phoneNo LIKE '%$search_phoneNo%'";
    }
    if (!empty($search_healthNo)) {
        $conditions[] = "healthNo LIKE '%$search_healthNo%'";
    }

    if (count($conditions) > 0) {
        $sql = "SELECT * FROM registration WHERE " . implode(' OR ', $conditions);
        $search_result = $conn->query($sql);
    }
}

$conn->close();
?>

<div class="container">
    <div class="tabs">
        <div class="tab" data-target="register">Register New Patient</div>
        <div class="tab" data-target="search">Search for Patient</div>
    </div>

    <div class="tab-content" id="register">
        <h2>Register New Patient</h2>
        <form action="register_patient.php" method="post">
            <label for="fname">First Name:</label>
            <input type="text" id="fname" name="fname" required>
            
            <label for="lname">Last Name:</label>
            <input type="text" id="lname" name="lname" required>
            
            <label for="healthNo">Health Number:</label>
            <input type="number" id="healthNo" name="healthNo" required>
            <div id="error-message" class="error-message"></div>
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            
            <label for="phoneNo">Phone Number:</label>
            <input type="text" id="phoneNo" name="phoneNo" required>
            
            <label for="address">Address:</label>
            <textarea id="address" name="address" required></textarea>
            
            <label for="gender">Gender:</label>
            <select id="gender" name="gender" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
            
            <input type="submit" name="register" value="Register">
        </form>
    </div>
    
    <div class="tab-content" id="search">
        <h2>Search for Patient</h2>
        <form action="register_patient.php" method="post">
            <label for="search_fname">First Name:</label>
            <input type="text" id="search_fname" name="search_fname">
            
            <label for="search_lname">Last Name:</label>
            <input type="text" id="search_lname" name="search_lname">
            
            <label for="search_phoneNo">Phone Number:</label>
            <input type="text" id="search_phoneNo" name="search_phoneNo">
            
            <label for="search_healthNo">Health Number:</label>
            <input type="text" id="search_healthNo" name="search_healthNo">
            
            <input type="submit" name="search" value="Search">
        </form>
        
        <div class="search-results">
            <?php
            if ($search_result !== null) {
                if ($search_result->num_rows > 0) {
                    echo "<h3>Search Results:</h3>";
                    echo "<table>";
                    echo "<tr><th>Name</th><th>Email</th><th>Phone</th><th>Address</th><th>Gender</th><th>Health Number</th><th>Edit</th></tr>";
                    while($row = $search_result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["fname"]. " " . $row["lname"]. "</td>";
                        echo "<td>" . $row["email"]. "</td>";
                        echo "<td>" . $row["phoneNo"]. "</td>";
                        echo "<td>" . $row["address"]. "</td>";
                        echo "<td>" . $row["gender"]. "</td>";
                        echo "<td>" . $row["healthNo"]. "</td>";
                        echo "<td><a class='edit-btn' href='edit_patient.php?healthNo=" . $row["healthNo"] . "'>Edit</a></td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<p>No results found.</p>";
                }
            }
            ?>
        </div>
    </div>
</div>

<footer>
    <?php include('footer.php'); ?>
</footer>
