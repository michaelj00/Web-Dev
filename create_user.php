<?php session_start();
	ini_set('display_errors', 'On');
	include_once 'storedInfo.php'; 
	//you must include this file wherever you work with passwords
	require_once("PasswordHash.php");
	//the first argument, 8, is the algorithm used for password stretching
	//the second argument allows the program to use portable hashes
	$hasher = new PasswordHash(8, false);
	$password = $_POST["password"];
	$username = $_POST["username"];
	$email = $_POST["email"];
	//keeping passwords to less than 72 characters helps to avoid denial-of-service attacks
	if (strlen($password) > 72) 
	{
		die("Password must be 72 characters or less");
	}
	//creating the hash variable which stores the hash
	$hash = $hasher->HashPassword($password);
	//if hash is created we connect to the database
	if ($username == "")
	{
		echo "Please enter a valid username.";
	}else if ($password == "")
	{
		echo "Please enter a valid password.";
	}else if (strlen($hash) >= 20) 
	{
		$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "jonesmi-db", $myPassword, "jonesmi-db");
		//echo "Testing connection to the database.......";
		if ($mysqli->connect_errno) 
		{
			//echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
		} 
			
			//check to see if username exists		
		if (!($result = $mysqli->prepare("SELECT LibraryUsers.userName FROM LibraryUsers WHERE LibraryUsers.userName = ?")))
		{
			//echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		}
		if(!($result->bind_param("s",$username)))
		{
			//echo "Bind Failed: " . $stmt->errno . " " .$stmt->error;
		}
		
		if (!$result->execute()) 
		{
			//echo "Execute Failed: (" . $mysqli->errno . ")" . $mysqli->error;
		}
		
		$result->store_result();  /* store results for num_rows usage.*/
		$rows = $result->num_rows;
		
		if ($rows != 0) //username is taken. num_rows describes where element was found
		{
			echo "taken";
		} else	
		{			//insert into the table. 
			if (!($stmt = $mysqli->prepare("insert into LibraryUsers (userName, passWord, eMail) VALUES ( ?,?,?)")))
			{
				//echo "Insert failed, Please try again later.";
			}
			if(!($stmt->bind_param("sss", $username, $hash, $email)))
			{
				echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
			}	
			if(!$stmt->execute())
			{
				echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
			}else
			{			//this else sets the session variables for the new user. 
						//we must first obtain them.
				$resultGetPkey = $mysqli->prepare("SELECT * FROM LibraryUsers WHERE userName = ?");
					//if (!$resultGetPkey->execute())
				
				if(!($resultGetPkey->bind_param("s", $username)))
				{
					echo "Bind failed: "  . $resultGetPkey->errno . " " . $resultGetPkey->error;
				}	
							
				if (!$resultGetPkey->execute()) 
				{
					echo "Execute Failed: (" . $mysqli->errno . ")" . $mysqli->error;
				}
				$uName = NULL;
				$pWord = NULL;
				$pKey = NULL;
				$Mail = NULL;
				if (!$resultGetPkey->bind_result($pKey, $uName, $pWord, $Mail))
				{
					//echo "Binding output parameters failed: (" . $result->errno . ") " . $result->error;
				}
				$counter = 0;
				while ($resultGetPkey->fetch())
				{
					$counter ++;
					$_SESSION['uid'] = $uName;
					$_SESSION['username'] = $uName;
					$_SESSION['password'] = $pWord;
					$_SESSION['billy'] = $pKey;	
					echo 'true';
				}
			}
		}
	}
?>

