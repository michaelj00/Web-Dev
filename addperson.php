<?php

//Turn on error reporting
/*include 'storedInfo.php';
ini_set('display_errors', 'On');
$owner = $_POST['owner'];
$element_num = $_POST['element_num'];
$part_desc = $_POST['part_desc'];
$quantity = $_POST['quantity'];
//Connects to the database

//echo $owner, $element_num, $part_desc, $quantity;
$mysqli = new mysqli("oniddb.cws.oregonstate.edu","jonesmi-db",$myPassword,"jonesmi-db");
if($mysqli->connect_errno){
	echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}

if(!($stmt1 = $mysqli->prepare("INSERT INTO MissingPiece(quantity, element_num, part_desc) VALUES ('$quantity', '$element_num', '$part_desc')"))){
	echo "Prepare failed: ";//  . $stmt1->errno . " " . $stmt1->error;
}
if(!($stmt1->bind_param("iis", $quantity, $element_num, $part_desc))){ //"ssii",
	echo "Bind failed: "  . $stmt1->errno . " " . $stmt1->error;
}
if(!$stmt1->execute()){
	echo "Execute failed: "  . $stmt1->errno . " " . $stmt1->error;
} else {
	$result = $stmt1->insert_id;
	echo "Added " . $stmt1->affected_rows . " rows to MissingPiece.";
}

$stmt1->close();/*
if(!($stmt2 = $mysqli->prepare("SELECT MissingPiece.id FROM MissingPiece WHERE MissingPiece.element_num = '$element_num'")))
{
	echo "Prepare failed: element_num ";
}
if(!$stmt2->execute()){
	echo "execute failed";
	}
$pid = NULL;
if(!$stmt2->bind_result($pid)){
	echo "Bind failed: pid" . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
$stmt2->close();
echo $result;
	
if(!($stmt = $mysqli->prepare("INSERT INTO UserMissing(uid, pid) VALUES ('$owner','$result')"))){
	echo "Prepare failed: insert uid pid";//  . $stmt->errno . " " . $stmt->error;
}
if(!($stmt->bind_param($owner,$result))){
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->execute()){
	echo "Execute failed: pid "  . $stmt->errno . " " . $stmt->error;
} else {
	echo "Added " . $stmt->affected_rows . " rows to UserMissing.";
}*/

?>