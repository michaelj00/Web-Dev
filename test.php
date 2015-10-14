<?php
ini_set('display_errors', 'On');
/*
function add_UserMissing()
{
	include 'storedInfo.php'; 	
	$num1 = $_POST['ElementNum'];
	$Key = $_SESSION['billy'];
	//$desc = $_POST['desc'];
	//$quantity = $_POST['quantity'];

	$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "jonesmi-db", $myPassword, "jonesmi-db");
		echo "Testing connection to the database.......";
		if ($mysqli->connect_errno) 
		{
			echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
		}  else 
		{
			echo "connection worked!<br><br>";
		}   
		
		if (!($stmt = $mysqli->prepare("SELECT MissingPiece.id, MissingPiece.element_num, MissingPiece.quantity, MissingPiece.part_desc, UserMissing.pid, UserMissing.uid
		From MissingPiece
		INNER JOIN UserMissing ON MissingPiece.id = UserMissing.pid
		Where MissingPiece.element_num = '$num1'"))) 
		{
			echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		}
	
	if (!$stmt->execute()) 
	{
		echo "Execute Failed: (" . $mysqli->errno . ")" . $mysqli->error;
	}
	//$stmt->store_result();
	//$rows = $stmt->num_rows;				
				//bind results

	$out_MP_id = NULL;
	$out_EleNum = NULL;
	$out_Quant = NULL;
	$out_MP_desc = NULL;
	$out_pid = NULL;
	$out_uid = NULL;

				
	if (!$stmt->bind_result($out_MP_id, $out_EleNum, $out_Quant, $out_MP_desc, $out_pid, $out_uid))
	{
		echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
	//}
	//if ($rows == 0)
	//{
		$result = $mysqli->query("insert into UserMissing (uid, pid) VALUES ( '$Key','$out_MP_id')");
		if (!$result)
		{
			echo "query failed";
		}//else  echo 'true';// "<span style='color:green;'>Available</span>";//"Thanks " . $_SESSION['username'] . " for adding your set to the database.";
	}// else echo 'false';//"We already have this Lego set in our collection. Please add another. <br>";
	$stmt->close();
	$mysqli->close();	

}

		if (isset($_POST['ElementNum']))
		{	
			add_UserMissing();
		}*/

?>