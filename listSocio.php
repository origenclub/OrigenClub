<?php 
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"])){
	switch ($_POST['action']) {
		case 'insertRfIdLog':
       insertRfIdLog();
      	
      	break;
                   
		case 'showLogs':
		showLogs();
		
		break;
		
		default:

		break;

	}
}


function insertRfIdLog() {
    include 'connect.php'; 

    $cardid = $_POST['cardid'];
  
   	$stmt = $conn->prepare("UPDATE `socio` SET `cardid`= :card ORDER by id DESC LIMIT 1");
   
    $stmt->bindParam(":card", $cardid);
   
 	$stmt->execute();
    echo "success";
   
 

}

function showLogs()
{
	include 'connect.php';

	$logs = $conn->query("SELECT * FROM `socio` ORDER by id DESC LIMIT 1");
	while($r = $logs->fetch()){
		echo "<tr>";
		echo "<td>".$r['dni']."</td>";
		echo "<td>".$r['nombres']."</td>";
		echo "<td>".$r['apellidos']."</td>";
		echo "<td>".$r['socio']."</td>";
		echo "<td>".$r['fecha']."</td>";
	
		echo "</tr>";
      
	}
 
}
?>

