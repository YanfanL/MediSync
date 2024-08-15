<?php include 'header.php'; ?>
<?php 

session_start();
$con=new mysqli ('localhost', 'root', '','project_final');
if ($con -> connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
    exit();
  }
  else {
  
  }

?>
<div class="container">

<?php 

$duration = 30;
$cleanup = 0;
$start = "10:00";
$end = "18:00";


function timeslots($duration, $cleanup, $start, $end){
    $start = new DateTime($start);
    $end = new DateTime($end);
    $interval = new DateInterval("PT".$duration."M");
    $cleanupInterval = new DateInterval("PT".$cleanup."M");
    $slots = array();
    
    for($intStart = $start; $intStart<$end; $intStart->add($interval)->add($cleanupInterval)){
        $endPeriod = clone $intStart;
        $endPeriod->add($interval);
        if($endPeriod>$end){
            break;
        }
        
        $slots[] = $intStart->format("H:i:s");
        
    }
    
    return $slots;
}


?>
<div class="row">
<form action=" " method="post" >
<label for="doctorID">Type Doctor License Number</label>
<input type='text'  name='doctorID' required><br>
<br>
<label for="days">Choose a day:</label>
<select name="days" id="days">
  <option value="Monday">Monday</option>
  <option value="Tuesday">Tuesday</option>
  <option value="Wednesday">Wednesday</option>
  <option value="Thursday">Thursday</option>
  <option value="Friday">Friday</option>
  <option value="Saturday">Saturday</option>
  <option value="Sunday">Sunday</option>

</select>
    <?php $timeslots = timeslots($duration, $cleanup, $start, $end); 
    
        foreach($timeslots as $ts){
  

    echo "<input type='submit'  name='test' value='$ts'>"; ?>
    
    <?php } ?></form>
</div>

<?php 

   if(isset($_POST['test'])){
    $checked =$_POST['test'];
    $doctor =$_POST['doctorID'];
    $days =$_POST['days'];
    
    //insert into Availability (Status,Time,Day,medicalLicence) values('Available','11:00:00','sunday','45368422');
      $query3 = "insert into Availability (Status,Time,Day,medicalLicence,healthNo) values('Available','$checked','$days','$doctor','')";
       $statement2 = mysqli_query($con,$query3);

       if($statement2){
        echo '<script type="text/javascript">alert("Availability Created")</script>';
     }
 
    }

    
?>
</div>
<footer>

<?php include 'footer.php'; ?>
</footer>