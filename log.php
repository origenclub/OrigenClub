<?php 
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"])){
	switch ($_POST['action']) {
		case 'insertRfIdLog':
       	insertRfIdLog();
      	
      	break;
                   
		case 'showLogs':
		showLogs();
                  
		default:

		break;

	}
}

function insertRfIdLog() {
    include 'connect.php';
      $cardid = $_POST['cardid'];

	$stmt = $conn->prepare("INSERT INTO `tbllogs`(`cardid`) VALUES (:card)");
   
    $stmt->bindParam(":card", $cardid);
 	$stmt->execute();
    echo "success";
  
}

function showLogs()
{
	include 'connect.php';

	$logs = $conn->query("SELECT * FROM `tbllogs`");
	while($r = $logs->fetch()){
		echo "<tr>";
		echo "<td>".$r['logid']."</td>";
		echo"<td>".$r['local']."</td>";
		echo "<td>".$r['cardid']."</td>";
		$dateadded = date("F j, Y, g:i a", $r["logdate"]);
		echo "<td>".$dateadded."</td>";
		//echo "<td>".$r["logdate"]."</td>";
		echo "</tr>";
      
	}
    
}
