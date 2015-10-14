<?php session_start();
	require_once('bookmark_fns.php');
   	ini_set('display_errors', 'On');
	include 'storedInfo.php'; 
	require_once("PasswordHash.php");

	//if (isset($_REQUEST['username']))
	//		{
				$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "jonesmi-db", $myPassword, "jonesmi-db");
						//echo "Testing connection to the database.......";
				if ($mysqli->connect_errno) {
					//echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
				}	else 
				{
					//echo "connection worked!<br><br>";
				}    
			
				
				$userName = $_POST['name'];
				$passWord = $_POST['pwd'];
				
				$hasher = new PasswordHash(8, false);
				$hash = $hasher->HashPassword($passWord);
				$stored_hash = "*";

						//prepare statement to search if username exists

				$result = $mysqli->prepare("SELECT LibraryUsers.id, LibraryUsers.userName, LibraryUsers.passWord FROM LibraryUsers WHERE userName = ?");    //'$userName'");
			
				if(!($result->bind_param("s",$userName)))
				{
					echo "Bind Failed: " . $stmt->errno . " " .$stmt->error;
				}
								
					//execute statement
				if (!$result->execute())
				{
					//echo "Execute Failed: (" . $mysqli->errno . ")" . $mysqli->error;
				}
					
				//bind results
				$uName = NULL;
				$pWord = NULL;
				$pKey = NULL;
				$Mail = NULL;
				
				if (!$result->bind_result($pKey, $uName, $pWord))
				{
					//echo "Binding output parameters failed: (" . $result->errno . ") " . $result->error;
				}

				$counter = 0;			//counter is going to be used to test if no usernames were found
				while ($result->fetch()) 
				{  
					$counter ++;
					$stored_hash = "*";
						//save database hash
					$stored_hash = $pWord;	
						//compare database hash to password entered.
						//$check will be 1 if true
					$check = $hasher->CheckPassword($passWord,$stored_hash); 
					if ($check)
					{
						$_SESSION['uid'] = $userName;
						$_SESSION['username'] = $userName;
						$_SESSION['password'] = $passWord;
						$_SESSION['billy'] = $pKey;

						echo 'true';

					}else
					{
						echo 'false'; //password did not match
					}
				}	
					/*  if counter == to anything other than 1. Search found no username to match
						This will also account for a database error where two instances of the same
						username is found*/						
				if ($counter !== 1)
				{
					echo 'false';
				}
			
		//	}
	
?>