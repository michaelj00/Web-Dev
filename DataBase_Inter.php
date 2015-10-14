<?php session_start();
	
	/*
			Michael Jones
			DataBase_Inter.php  Most all database interaction is 
				found here.
			
			Note most of the code and prepare statements were taken
			directly from the lecture on real coding PHP.
			Some code found at php.net
	*/
	
	
	ini_set('display_errors', 'On');
//This function allows a user to add a Lego set to the database
function addLego()
{
	include 'storedInfo.php'; 	
	$num = $_POST['LegoNum'];
	$Key = $_SESSION['billy'];
	$disc = $_POST['disc'];

	$checked = "available";

	if (($num == NULL) || ($disc == NULL))
	{
		echo 'Your Lego number or description was blank.';
	} else 
	{
		$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "jonesmi-db", $myPassword, "jonesmi-db");
			//echo "Testing connection to the database.......";
			if ($mysqli->connect_errno) 
			{
				echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
			}  else 
			{
				//echo "connection worked!<br><br>";
			}   
		
			if (!($stmt = $mysqli->prepare("SELECT LibraryUsers.id, LibraryUsers.userName, LibraryUsers.eMail, LegoCollections2.owner, 
				LegoCollections2.legoNumber, LegoCollections2.disc, LegoCollections2.checkOut 
				FROM LibraryUsers INNER JOIN LegoCollections2 
				ON LibraryUsers.id = LegoCollections2.owner 
				WHERE LegoCollections2.legoNumber = ?"))) 
			{
				echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
			}
		if(!($stmt->bind_param("i",$num)))
		{
			echo "Bind Failed: " . $stmt->errno . " " .$stmt->error;
		}
		
		if (!$stmt->execute()) 
		{
			echo "Execute Failed: (" . $mysqli->errno . ")" . $mysqli->error;
		}
		
		$stmt->store_result();  /* store results for num_rows usage.*/
		$rows = $stmt->num_rows;				
					
		$out_Name = NULL;
		$out_owner = NULL;
		$out_disc = NULL;
		$out_Id = NULL;
		$out_eMail = NULL;
		$out_LegNum = NULL;
		$out_Check = NULL;

				
		if (!$stmt->bind_result($out_Id, $out_Name, $out_eMail, $out_owner, $out_LegNum,  $out_disc , $out_Check))
		{
			echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
		}
		if ($rows == 0)
		{
			if(!($result = $mysqli->prepare("insert into LegoCollections2 (legoNumber, owner, disc, checkOut) VALUES (?,?,?,?)"))) 
			{
				echo "Prepare failed: "  . $result->errno . " " . $result->error;
			}
			if(!($result->bind_param("isss", $num, $Key, $disc, $checked)))
			{
				echo "Bind failed: "  . $result->errno . " " . $result->error;
			}	
			if(!$result->execute())
			{
				echo "Execute failed: "  . $result->errno . " " . $result->error;
			} else 
			{
				echo 'Lego Set added.';
			}	
		} else echo 'We already have this set in our collection please add another.';
	
	}
}
//This function prints the Lego collection to the screen
function printLego()
{       
		
	include 'storedInfo.php';
	ini_set('display_errors', 'On');	
	
	$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "jonesmi-db", $myPassword, "jonesmi-db");
	if ($mysqli->connect_errno) 
	{
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}  else 
	{
		//echo "connection worked!<br><br>";
	} 
	
			/* Get all data from LegoCollections2 and LibraryUsers databases for display. */
	if (!($stmt = $mysqli->prepare("SELECT LegoCollections2.LegoNumber, LibraryUsers.userName, LegoCollections2.disc, LegoCollections2.checkOut 
		FROM LibraryUsers 
		INNER JOIN LegoCollections2 ON LibraryUsers.id = LegoCollections2.owner"))) 
	{
		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}
		if (!$stmt->execute()) 
	{
		echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}

	$out_Check = NULL;
	$out_Num = NULL;
	$out_pKey = NULL;
	$out_disc = NULL;

	if (!$stmt->bind_result($out_Num, $out_pKey, $out_disc, $out_Check)) 
	{
		echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
	}
	$display_string = "<table style = 'text-align:center;' border = '1';> <tr> <th> Lego Set Number </th> <th> owner </th> <th> disc </th> <th> checked out </th>";

		// Insert a new row in the table for each person returned
		// Table creation used with assistance from http://www.tutorialspoint.com/php/php_and_ajax.htm
	while($stmt -> fetch())
	{
		$display_string .= "<tr>";
		$display_string .= "<td>".$out_Num."</td>";
		$display_string .= "<td>".$out_pKey."</td>";
		$display_string .= "<td>".$out_disc."</td>";
		$display_string .= "<td>".$out_Check."</td>";
		$display_string .= "</tr>";
	}
	$display_string .= "</table>";
	echo $display_string;
	$mysqli->close();
}

//This function searches for a Lego set by Lego set number
function searchLego()
{
	include 'storedInfo.php';
	ini_set('display_errors', 'On');
	$LegSear = $_POST['searchLegoNum'];
	$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "jonesmi-db", $myPassword, "jonesmi-db");

	if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}	else 
	{
		//echo "connection worked!<br><br>";
	}  
	if (!($stmt = $mysqli->prepare("SELECT LibraryUsers.id, LibraryUsers.userName, LibraryUsers.eMail, LegoCollections2.owner, 
		LegoCollections2.legoNumber, LegoCollections2.disc, LegoCollections2.checkOut 
		FROM LibraryUsers 
		INNER JOIN LegoCollections2 ON LibraryUsers.id = LegoCollections2.owner 
		WHERE LegoCollections2.legoNumber = ?"))) 
	{
		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}
	
	if(!($stmt->bind_param("i",$LegSear)))
	{
		echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
	}
	
	if (!$stmt->execute()) 
	{
		echo "Execute Failed: (" . $mysqli->errno . ")" . $mysqli->error;
	}
					
				//bind results
	$out_Name = NULL;
	$out_owner = NULL;
	$out_disc = NULL;
	$out_Id = NULL;
	$out_eMail = NULL;
	$out_LegNum = NULL;
	$out_Check = NULL;
	
				
	if (!$stmt->bind_result($out_Id, $out_Name, $out_eMail, $out_owner, $out_LegNum,  $out_disc , $out_Check))
	{
		echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
	}

	$counter = 0;			//counter is going to be used to test if no Lego Sets were found
	$display_string = "<table style = 'text-align:center;' border = '1'>";
	$display_string .= "<tr>";
	$display_string .= "<th> Lego Set Number</th>";
	$display_string .= "<th>Owner</th>";
	$display_string .= "<th>Desc</th>";
	$display_string .= "<th>Email</th>";
	$display_string .= "<th>Checked Out</th>";
	$display_string .= "</tr>";

	// Insert a new row in the table for each person returned
	while($stmt -> fetch())
	{
		$display_string .= "<tr>";
		$display_string .= "<td>".$out_LegNum."</td>";
		$display_string .= "<td>".$out_Name."</td>";
		$display_string .= "<td>".$out_disc."</td>";
		$display_string .= "<td>".$out_eMail."</td>";
		$display_string .= "<td>".$out_Check."</td>";
		$display_string .= "</tr>";
		$counter ++;
	}
	if ($counter == 0)
	{
		echo "There were no Lego sets by that set number. <br> If you buy it please add it to the collection so others can enjoy as well.";
	}else 
	{
		$display_string .= "</table>";
		echo $display_string;
	}
	$mysqli->close();

}
//This function will display the users of the Lego share account
function printUsers()
{
	include 'storedInfo.php';
	ini_set('display_errors', 'On');
			
	$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "jonesmi-db", $myPassword, "jonesmi-db");
	if ($mysqli->connect_errno) 
	{
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}  else 
	{
		//echo "connection worked!<br><br>";
	} 
	if (!($stmt = $mysqli->prepare("SELECT userName, eMail 
									FROM LibraryUsers"))) 
	{
		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}
	if (!$stmt->execute()) 
	{
	echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}
	$pKey = NULL;
	$out_Name = NULL;
	$out_pKey = NULL;
	$out_eMail = NULL;

	if (!$stmt->bind_result($out_Name, $out_eMail)) 
	{
		echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
	}
	
	$display_string = "<table style = 'text-align:center;' border = '1'> <tr> <th> User </th> <th> email </th>";

		// Insert a new row in the table for each person returned
		while($stmt -> fetch())
		{
			$display_string .= "<tr>";
			$display_string .= "<td>".$out_Name."</td>";
			$display_string .= "<td>".$out_eMail."</td>";
			$display_string .= "</tr>";
		}
	$display_string .= "</table>";
	echo $display_string;
	$mysqli->close();

}
//This function allows the user to check out a Lego set.
function checkOut()
{
	include 'storedInfo.php';
	ini_set('display_errors', 'On');
	$username = $_SESSION['username'];
	$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "jonesmi-db", $myPassword, "jonesmi-db");
	if ($mysqli->connect_errno) 
	{
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}  else 
	{
		//echo "connection worked!<br><br>";s
	} 
	$check = $_REQUEST['checkOutLego'];
	$_SESSION['check'] = $check;
	if (!($stmt = $mysqli->prepare("SELECT legoNumber, owner,  disc, checkOut
		FROM LegoCollections2 
		WHERE legoNumber = ?"))) 
		{
			echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		}
	
	if(!($stmt->bind_param("s",$check)))
	{
		echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
	}
	
	if (!$stmt->execute()) 
	{
	echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}
		//stores my stmt for use with num_rows
	$stmt->store_result();
	$rows = $stmt->num_rows;
	$pKey = NULL;
	$out_checkOut = NULL;
	$out_Num = NULL;
	$out_Owner = NULL;
	$out_Disc = NULL;

	if (!$stmt->bind_result($out_Num, $out_Name, $out_Disc, $out_checkOut)) 
	{
		echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
	}

	if ($rows != 0)  // no lego sets were found. 
	{
		while ($stmt->fetch()) //pulls each row
		{
			if ($out_checkOut != "available")
			{
				echo "This set is not available for checking out. It is currently reserved by ". $out_checkOut;
			}else
			{
			
			/*mysqli_query($mysqli,"UPDATE LegoCollections2 SET checkout = '$username'
					WHERE legoNumber ='$check'");  */
				if(!($stmt1 = $mysqli->prepare("UPDATE LegoCollections2 SET checkout = '$username'
					WHERE legoNumber = ?")))
				{
					echo "Prepare failed: "  . $stmt1->errno . " " . $stmt1->error;
				}

				if(!($stmt1->bind_param("s",$check)))
				{
					echo "Bind failed: "  . $stmt1->errno . " " . $stmt1->error;
				}

				if(!$stmt1->execute())
				{
					echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
				}
					/* Print Lego set to show it is now checked out */
				printLegoSet();     
			}
		}
	}else echo "That set was not found please make sure set number is in the database.<br>
				You can click Print Lego Table to see which ones we have.<br>";
				
	$mysqli->close();
}	
//This function allows the user to return a Lego set after checking out
function returnLego()
{
	include 'storedInfo.php';
	ini_set('display_errors', 'On');
	$username = $_SESSION['username'];
	$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "jonesmi-db", $myPassword, "jonesmi-db");
	if ($mysqli->connect_errno) 
	{
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}  else 
	{
		//echo "connection worked!<br><br>";s
	} 
	$check = $_REQUEST['returnLegoSet'];
	$_SESSION['check'] = $check;
	if (!($stmt = $mysqli->prepare("SELECT legoNumber, owner,  disc, checkOut
		FROM LegoCollections2 
		WHERE legoNumber = ? "))) 
		{
			echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		}
	if(!($stmt->bind_param("s", $check)))
	{
		echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
	}
	if (!$stmt->execute()) 
	{
	echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}
		//stores my stmt for use with num_rows
	$stmt->store_result();
	$rows = $stmt->num_rows;
	$pKey = NULL;
	$out_checkOut = NULL;
	$out_Num = NULL;
	$out_Owner = NULL;
	$out_Disc = NULL;

	if (!$stmt->bind_result($out_Num, $out_Name, $out_Disc, $out_checkOut)) 
	{
		echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
	}

	if ($rows != 0)
	{
		while ($stmt->fetch()) //pulls each row
		{
				/* if checkOut contains available then able to reserve. */
			if ($out_checkOut == "available")
			{
				echo "This set is not checked out. There is no need to return it.";
			}else
			{
			if(!($stmt1 = $mysqli->prepare("UPDATE LegoCollections2 SET checkout = 'available'
					WHERE legoNumber = ?")))
				{
					echo "Prepare failed: "  . $stmt1->errno . " " . $stmt1->error;
				}

				if(!($stmt1->bind_param("s",$check)))
				{
					echo "Bind failed: "  . $stmt1->errno . " " . $stmt1->error;
				}

				if(!$stmt1->execute())
				{
					echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
				}
					/* Print Lego set to show it is now checked out */
				printLegoSet();  
			}
		}
	}else echo "That set was not found please make sure set number is in the database.<br>
				You can click Print Lego Table to see which ones we have.<br>";
	$mysqli->close();
}	
// This function will print the specific Lego Set that was modified.
function printLegoSet()
{
	include 'storedInfo.php';
		ini_set('display_errors', 'On');	
		$check = $_SESSION['check'];
		$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "jonesmi-db", $myPassword, "jonesmi-db");
		if ($mysqli->connect_errno) 
		{
			echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
		}  else 
		{
			//echo "connection worked!<br><br>";
		} 		
		if (!($stmt = $mysqli->prepare("SELECT LegoCollections2.LegoNumber, LibraryUsers.userName, LegoCollections2.disc, LegoCollections2.checkOut 
			FROM LibraryUsers 
			INNER JOIN LegoCollections2 
			ON LibraryUsers.id = LegoCollections2.owner 
			WHERE legoNumber = ?"))) 
		{
			echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		}
		if(!($stmt->bind_param("s", $check)))
		{
			echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
		}
		if (!$stmt->execute()) 
		{
			echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
		}

		$pKey = NULL;
		$out_Check = NULL;
		$out_Num = NULL;
		$out_pKey = NULL;
		$out_disc = NULL;

		if (!$stmt->bind_result($out_Num, $out_pKey, $out_disc, $out_Check)) 
		{
			echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
		}
		echo "<table style = 'text-align:center;' border = '1';> <tr> <th> Lego Set Number </th> <th> owner </th> <th> disc </th> <th> checked out </th>";
		while ($stmt->fetch()) //pulls each row 
		{   
			echo "<tr>";
			echo "<td>".$out_Num."</td>";
			echo "<td>".$out_pKey."</td>";
			echo "<td>".$out_disc."</td>";
			echo "<td>".$out_Check."</td>";

			echo "</tr>";
		} 
		echo "</table>";
	$mysqli->close();
}
/*This function allows the user to remove a set from the collection. 
	Note only the owner of the set may perform this operation. */
function deleteLego()
{

	include 'storedInfo.php';
	ini_set('display_errors', 'On');
	$deleteLego = $_REQUEST['deleteLegoSet'];
	$user = $_SESSION['uid'];
	$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "jonesmi-db", $myPassword, "jonesmi-db");
	//echo "Testing connection to the database.......";
	if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}	else 
	{
		//echo "connection worked!<br><br>";
	}  
	if (!($stmt = $mysqli->prepare("
		SELECT LibraryUsers.id, LibraryUsers.userName, LibraryUsers.eMail, LegoCollections2.owner, 
		LegoCollections2.legoNumber, LegoCollections2.disc, LegoCollections2.checkOut 
		FROM LibraryUsers INNER JOIN LegoCollections2 
		ON LibraryUsers.id = LegoCollections2.owner 
		WHERE LegoCollections2.legoNumber = ?")))  //'$deleteLego'
		{
			echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		}
	
	if(!($stmt->bind_param("i",$deleteLego)))
	{
		echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
	}
	
	$out_Name = NULL;
	$out_owner = NULL;
	$out_disc = NULL;
	$out_Id = NULL;
	$out_eMail = NULL;
	$out_LegNum = NULL;
	$out_Check = NULL;
	
	if (!$stmt->execute()) 
	{
		echo "Execute Failed: (" . $mysqli->errno . ")" . $mysqli->error;
	}
	$stmt->store_result();
	$rows = $stmt->num_rows;
	if (!$stmt->bind_result($out_Id, $out_Name, $out_eMail, $out_owner, $out_LegNum,  $out_disc , $out_Check))
	{
		echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
	}
	$stmt->store_result();
	$rows = $stmt->num_rows;

	if ($rows != 0)   //results were found. 
	{
		while ($stmt->fetch()) //pulls each row 
		{   
				/* check to see if the user owns the item. 
						Only owner allowed to remove an item from the table*/
			if ($out_Name == $user)
			{
				echo "you own this item and you can delete it.<br>";	
					
				if(!($stmt1 = $mysqli->prepare("DELETE FROM LegoCollections2 
					WHERE legoNumber = ?")))
				{
					echo "Prepare failed: "  . $stmt1->errno . " " . $stmt1->error;
				}

				if(!($stmt1->bind_param("i",$deleteLego)))
				{
					echo "Bind failed: "  . $stmt1->errno . " " . $stmt1->error;
				}

				if(!$stmt1->execute())
				{
					echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
				}
				echo"We deleted your item. Please add another soon.";
			}
			else echo "You can only delete an item you own.";
		}
	}else echo "That set was not found. Please try again.";
	$mysqli->close();
}

/* This function allows the user to add a missing piece to the missing
	piece table. This function will also set the UserMissing tables 
	foreign key references as well.*/

function adding_part()
{
	include 'storedInfo.php';
	ini_set('display_errors', 'On');
	$owner = $_SESSION['billy'];
	$element_num = $_POST['ElementNum'];
	$part_desc = $_POST['desc'];
	//$quantity = $_POST['quantity'];

	$mysqli = new mysqli("oniddb.cws.oregonstate.edu","jonesmi-db",$myPassword,"jonesmi-db");
	if($mysqli->connect_errno){
		//echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
	
	if(!($stmt1 = $mysqli->prepare("INSERT INTO MissingPiece(element_num, part_desc) VALUES (?,?)")))
	{
		echo "Prepare failed: "  . $stmt1->errno . " " . $stmt1->error;
	}
	if(!($stmt1->bind_param('is', $element_num, $part_desc)))
	{ 
		echo "Bind failed: "  . $stmt1->errno . " " . $stmt1->error;
	}
	if(!$stmt1->execute())
	{
		//echo "Execute failed: "  . $stmt1->errno . " " . $stmt1->error;
	} else 
	{
		$result = $stmt1->insert_id;
		//echo "Added " . $stmt1->affected_rows . " rows to MissingPiece.";
	}

	if(!($stmt = $mysqli->prepare("INSERT INTO UserMissing(uid, pid) VALUES (?,?)")))
	{ 
		echo "Prepare failed: insert uid pid "  . $stmt->errno . " " . $stmt->error;
	}
	if(!($stmt->bind_param('ii',$owner,$result)))
	{
		echo "Bind Failed: "  . $stmt->errno . " " . $stmt->error;
	}
	if(!$stmt->execute())
	{
		echo "Execute failed: pid "  . $stmt->errno . " " . $stmt->error;
	} else {
		echo "Successfully added " . $stmt->affected_rows . " to the list.";
	}
	$mysqli->close();
	
}


/* This function displays the current MissingPiece table. */

function view_part_list()
{
	include 'storedInfo.php';
	ini_set('display_errors', 'On');
			
	$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "jonesmi-db", $myPassword, "jonesmi-db");
	if ($mysqli->connect_errno) 
	{
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}  else 
	{
		//echo "connection worked!<br><br>";
	} 
	if (!($stmt = $mysqli->prepare("SELECT MissingPiece.element_num, MissingPiece.part_desc, LibraryUsers.userName 
		FROM LibraryUsers
		INNER JOIN UserMissing ON LibraryUsers.id = UserMissing.uid
		INNER JOIN MissingPiece ON MissingPiece.id = UserMissing.pid"))) 
	{
		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}
	if (!$stmt->execute()) 
	{
		echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}

	$out_quantity = NULL;
	$out_element_num = NULL;
	$out_part_desc = NULL;
	$out_userName = NULL;

	if (!$stmt->bind_result($out_element_num, $out_part_desc, $out_userName)) 
	{
		echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
	}
	
	$display_string = "<table style = 'text-align:center;' border = '1'> <tr> <th> Element Number </th><th> Part Description </th> <th> Requestor </th>";

		// Insert a new row in the table for each person returned
		while($stmt -> fetch())
		{
			$display_string .= "<tr>";
			$display_string .= "<td>".$out_element_num."</td>";
			$display_string .= "<td>".$out_part_desc."</td>";
			$display_string .= "<td>".$out_userName."</td>";
			$display_string .= "</tr>";
		}
	$display_string .= "</table>";
	echo $display_string;
	$mysqli->close();
}


/* This function allows the user to delete a part from the MissingPiece table*/

function deletePart()
{

	include 'storedInfo.php';
	ini_set('display_errors', 'On');
	$deleteLegoP = $_REQUEST['delete_LegoPart'];
	$user = $_SESSION['billy'];
	$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "jonesmi-db", $myPassword, "jonesmi-db");
	//echo "Testing connection to the database.......";
	if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}	else 
	{
		//echo "connection worked!<br><br>";
	}  
			/*There could be multiple entries of the same element number by user.
				This query finds the MissingPiece.id for a piece that is owned
				by the user and matches the element_num selected*/
	if (!($stmt = $mysqli->prepare("
		SELECT MissingPiece.id
		FROM LibraryUsers 
		INNER JOIN UserMissing ON LibraryUsers.id = UserMissing.uid
		INNER JOIN MissingPiece ON MissingPiece.id = UserMissing.pid
		WHERE MissingPiece.element_num = ? AND LibraryUsers.id = ?"))) 
		{
			echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		}
	if(!($stmt->bind_param("ii",$deleteLegoP, $user)))
	{
		echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
	}
	$out_Name = NULL;
	$out_owner = NULL;
	$out_disc = NULL;
	$out_Id = NULL;
	$out_eMail = NULL;
	$out_EleNum = NULL;
	$out_Check = NULL;
	$out_Piece_id = NULL;
	
	if (!$stmt->execute()) 
	{
		echo "Execute Failed: (" . $mysqli->errno . ")" . $mysqli->error;
	}
	$stmt->store_result();
	$rows = $stmt->num_rows;
	if (!$stmt->bind_result($out_Piece_id))
	{
		echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
	}
	$stmt->store_result();
	$rows = $stmt->num_rows;

	$lowest_piece_id = 10000000000;	/*This variable is used to pull the lowest 
											MissingPiece.id	for deleting. Number is
											arbitrary we just want it to be higher than
											possible indicies. */
	
	if ($rows != 0)   //results were found. 
	{
		while ($stmt->fetch()) //pulls each row 
		{   
			if ($lowest_piece_id > $out_Piece_id)  //Is new lower piece.id less than prior
			{
				$lowest_piece_id = $out_Piece_id;
			}

		}
				/* Delete missing piece.id that was found above. This prevents 
					multiple entry deletes.
				*/
		if(!($stmt1 = $mysqli->prepare("DELETE FROM MissingPiece 
					WHERE MissingPiece.id = ?")))
		{
			echo "Prepare failed: "  . $stmt1->errno . " " . $stmt1->error;
		}

		if(!($stmt1->bind_param("i",$lowest_piece_id)))
		{
			echo "Bind failed: "  . $stmt1->errno . " " . $stmt1->error;
		}

		if(!$stmt1->execute())
		{
			echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
		}

		$rows = $stmt1->affected_rows;
		if ($rows != 0)
		{
			echo"We deleted your item.";
		}else 
		{
			echo "Part not found or you are not the owner";
		}	
	}else echo "Part not found or you are not the owner.";
	$mysqli->close();	
}

/* This function displays your parts on the missingPiece table. */

function your_parts()
{
	include 'storedInfo.php';
	ini_set('display_errors', 'On');
	$user_name = $_SESSION['username'];
	
	$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "jonesmi-db", $myPassword, "jonesmi-db");
	if ($mysqli->connect_errno) 
	{
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}  else 
	{
		//echo "connection worked!<br><br>";
	} 
	if (!($stmt = $mysqli->prepare("SELECT MissingPiece.element_num, MissingPiece.part_desc
	FROM LibraryUsers
	INNER JOIN UserMissing ON LibraryUsers.id = UserMissing.uid
	INNER JOIN MissingPiece ON MissingPiece.id = UserMissing.pid
	WHERE LibraryUsers.userName = ?"))) 
	{
		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}
	if(!($stmt->bind_param("s",$user_name))){
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}
	if (!$stmt->execute()) 
	{
		echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}

	$out_quantity = NULL;
	$out_element_num = NULL;
	$out_part_desc = NULL;
	$out_userName = NULL;

	if (!$stmt->bind_result($out_element_num, $out_part_desc)) 
	{
		echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
	}
	
	$display_string = "<table style = 'text-align:center;' border = '1'> <tr> <th> Element Number </th><th> Part Description </th>";

		// Insert a new row in the table for each person returned
		while($stmt -> fetch())
		{
			$display_string .= "<tr>";
			$display_string .= "<td>".$out_element_num."</td>";
			$display_string .= "<td>".$out_part_desc."</td>";
			$display_string .= "</tr>";
		}
	$display_string .= "</table>";
	echo $display_string;
	$mysqli->close();
}

/* This function displays all missing pieces with the same element number 
	This is regardless of who is requesting the pieces. Demonstrates the 
	many to many relationship */
function matching_parts()
{
	include 'storedInfo.php';
	ini_set('display_errors', 'On');
	$part_match = $_POST['same_LegoPart'];
	
	$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "jonesmi-db", $myPassword, "jonesmi-db");
	if ($mysqli->connect_errno) 
	{
		//echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}  else 
	{
		//echo "connection worked!<br><br>";
	} 
	if (!($stmt = $mysqli->prepare("SELECT MissingPiece.element_num, MissingPiece.part_desc, LibraryUsers.userName
	FROM LibraryUsers
	INNER JOIN UserMissing ON LibraryUsers.id = UserMissing.uid
	INNER JOIN MissingPiece ON MissingPiece.id = UserMissing.pid
	WHERE MissingPiece.element_num = ?"))) 
	{
		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}
	if(!($stmt->bind_param("i",$part_match)))
	{
		echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
	}
	if (!$stmt->execute()) 
	{
		echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}

	$out_quantity = NULL;
	$out_element_num = NULL;
	$out_part_desc = NULL;
	$out_userName = NULL;

	if (!$stmt->bind_result($out_element_num, $out_part_desc, $out_userName)) 
	{
		echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
	}
	
	$display_string = "<table style = 'text-align:center;' border = '1'> <tr> <th> Element Number </th><th> Part Description </th><th> Requestor</th></tr>";

		// Insert a new row in the table for each person returned
		while($stmt -> fetch())
		{
			$display_string .= "<tr>";
			$display_string .= "<td>".$out_element_num."</td>";
			$display_string .= "<td>".$out_part_desc."</td>";
			$display_string .= "<td>".$out_userName."</td>";
			$display_string .= "</tr>";
		}
	$display_string .= "</table>";
	echo $display_string;
	$stmt->close();

}

/* This function allows the user to see photo on the photo table. 
	the set number is used and has no relationship to the legocollections table.*/
function see_photos()
{
	include 'storedInfo.php';
	ini_set('display_errors', 'On');
	$photo_set_num = $_POST['photo_set_num'];
	
	$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "jonesmi-db", $myPassword, "jonesmi-db");
	if ($mysqli->connect_errno) 
	{
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}  else 
	{
		//echo "connection worked!<br><br>";
	} 
	if (!($stmt = $mysqli->prepare("SELECT UserPhotos.filename
		FROM UserPhotos
		WHERE UserPhotos.set_num = ?"))) 
	{
		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}
	
	if(!($stmt->bind_param("i",$photo_set_num)))
	{
		echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
	}
	if (!$stmt->execute()) 
	{
	echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}

	$out_filename = NULL;

	if (!$stmt->bind_result($out_filename)) 
	{
		echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
	}
	$new_file = (string)$out_filename;
	$counter = 0;
	while($stmt->fetch())
	{	
		$display_string = "<img src = $out_filename >";
		echo $display_string;
		$counter ++;
	}
			/*counter is used to count the photos found.
				If counter is still 0 then no photos were found. */
	if ($counter == 0)
	{
		echo "There were no Lego sets by that set number. <br>";
	}
	$mysqli->close();
}
		
/* This function shows the entire photo table */	
function see_photo_listing_func()
{
	include 'storedInfo.php';
	ini_set('display_errors', 'On');
	
	$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "jonesmi-db", $myPassword, "jonesmi-db");
	if ($mysqli->connect_errno) 
	{
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}  else 
	{
		//echo "connection worked!<br><br>";
	} 
	if (!($stmt = $mysqli->prepare("SELECT UserPhotos.set_num, UserPhotos.filename, LibraryUsers.userName
		FROM UserPhotos
		INNER JOIN LibraryUsers ON LibraryUsers.id = UserPhotos.photo_owner	"))) 
	{
		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}
	if (!$stmt->execute()) 
	{
	echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}

	$out_filename = NULL;
	$out_photo_owner = NULL;
	$out_set_numb = NULL;

	if (!$stmt->bind_result($out_set_numb, $out_filename, $out_photo_owner)) 
	{
		echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
	}

	$display_string = "<table style = 'text-align:center;' border = '1';> <tr>  <th> Owner </th> <th> Set Number </th> ";

		// Insert a new row in the table for each person returned
		// Table creation used with assistance from http://www.tutorialspoint.com/php/php_and_ajax.htm
		while($stmt -> fetch())
		{
			$display_string .= "<tr>";
			//$display_string .= "<td>".$out_filename."</td>";
			$display_string .= "<td>".$out_photo_owner."</td>";
			$display_string .= "<td>".$out_set_numb."</td>";
			$display_string .= "</tr>";
		//	$counter ++;
		}
	$display_string .= "</table>";
	echo $display_string;
	$mysqli->close();
}


		if (isset($_POST['disc']))	
		{
			addLego();	
			exit();
		}
		if (isset($_POST['printLegoTable']))
		{
			printLego();
			exit();
		}
		if (isset ($_POST['searchLegoNum']))
		{
			searchLego();
			exit();
		}
		if (isset ($_REQUEST['printUserTable']))
		{
			printUsers();
			exit();
		}
		if (isset ($_REQUEST['checkOutLego']))
		{
			checkOut();
			exit();
		}
		if (isset ($_REQUEST['returnLegoSet']))
		{
			returnLego();
			exit();
		}
		if (isset ($_REQUEST['deleteLegoSet']))
		{
			deleteLego();
			exit();
		}
		if (isset ($_REQUEST['upload-button']))
		{
			upload();
			exit();
		}		 
		if (isset($_POST['ElementNum']))
		{
			adding_part();
			exit();
		}		
		if(isset($_POST['print_part_list']))
		{
			view_part_list();		
			exit();
		}
		if(isset($_POST['delete_LegoPart']))
		{
			deletePart();
			exit();
		}
		if(isset($_POST['your_lego_part']))
		{
			your_parts();
			exit();
		}
		if(isset($_POST['same_LegoPart']))
		{
			matching_parts();
			exit();
		}
		if (isset($_POST['photo_set_num']))
		{
			see_photos();
			exit();
		}
		if(isset($_POST['see_photo_listing']))
		{
			see_photo_listing_func();
			exit();
		}
		
?>