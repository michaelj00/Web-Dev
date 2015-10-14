<!DOCTYPE HTML>
<html>
<head>
	<meta charset="UTF-8">
	<title>LegoShare New user</title>
	
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="styles.css" />
	<script src="jquery-1.11.0.min.js"></script>
	<script src="js/bootstrap.js" ></script>

</head>
<body>
<script type="text/javascript">
$(document).ready(function(){

	$('#join').click(function(){

		username = $("#username").val();
		password = $("#password").val();
		email = $("#email").val();
		if ((!validateUser(username)))// &&(validatePass(password)) && (validateEmail(email)))
		{
			$("#usernameBad").html("  You did not enter an valid username.");
			$("#passwordBad").html("");
			$("#emailBad").html("");
		}else if ((!validatePass(password)))
		{
			$("#usernameBad").html("");
			$("#passwordBad").html("  You did not enter an valid password.");
			$("#emailBad").html("");
		}else if ((!validateEmail(email)))
		{
			$("#usernameBad").html("");
			$("#passwordBad").html("");
			$("#emailBad").html("  You did not enter an valid email.");
		}
		else
		{
			$.ajax({
				url: "create_user.php",
				type: "POST",			
				data: { username: username, password: password, email: email},
				success: function(data)
				{		
					
					if ($.trim(data) == 'true')
					{
						window.location = "DataBase_Page.php";
					}
					else if ($.trim(data) =='taken')
					{
						$("#usernameBad").html("  That username is already taken.");
						$("#passwordBad").html("");
						$("#emailBad").html("");
					}else
					{
						$("#usernameBad").data(data);
		
					}
				}
			})   //end of ajax call
		} 

	});		// end of deleteOut click
});	// end of document ready
function validateEmail(email)
{
	var atpos = email.indexOf("@");
	var dotpos = email.lastIndexOf(".");
	if (atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >= email.length)
	{
	//		alert("Not a valid e-mail address");
		return false;
	}else return true;
}
function validatePass(password)
{
	if (password.length < 8)
	{
		//alert("Your password must be at least 6 characters long");
		return false;
	}else return true;
}
function validateUser(username)
{
	if (username.length < 4)
	{
		//alert("Your password must be at least 6 characters long");
		return false;
	}else return true;
}
</script>

	<div class = "navbar navbar-inverse navbar-static-top">
		<div class = "container">
			<a href = "#" class = "navbar-brand">Welcome to our Lego Collection Share site</a>
			<button class = "navbar-toggle" data-toggle = "collapse" data-target = ".navHeaderCollapse">
				<span class = "icon-bar"></span>
				<span class = "icon-bar"></span>
				<span class = "icon-bar"></span>
			</button>
		</div>
	</div>
<div class = "container">
	<h1>Thank you for joining out Lego Collection share site. <br><br></h1>

	<div> Please register a new account. <br>
		You will need a username and password and an email address so you can keep up with us.<br><br>
		
		Your username must be at least 4 characters.<br>
		Your password should be at least 8 characters. <br>
		You must use a valid email address. <br><Br>
	</div>

	<form id ="createUserForm"  method = "POST">
		Username: <input type="text" name="username" id = "username"><span id = "usernameBad"></span><br>
		Password: <input type="password" name="password" id = "password"><span id = "passwordBad"></span><br>
		Email: <input type="text" name="email" id = "email"><span id = "emailBad"></span><br>
		<button type="button" id = "join">Join now</button>
	</form>
</div>	
	
			
</body>	
</html>