<?php session_start();?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
		
        <title>Welcome to LegoShare</title>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="styles.css" />
		<script src="jquery-1.11.0.min.js"></script>
		<script src="js/bootstrap.js" ></script>
		<script type="text/javascript">
		
	//some code for ajax call found here. 
	//http://tutsforweb.blogspot.com/2012/05/ajax-login-form-with-jquery-and-php.html#
$(document).ready(function(){
 $("#login").click(function(){

  username=$("#username").val();
  password=$("#password").val();
  $.ajax({
   type: "POST",
   url: "session.php",
   data: "name="+username+"&pwd="+password,
   success: function(html){
    if(html === 'true')
    {
		window.location = "DataBase_Page.php";
    }
    else
    {
     $("#add_err").html("Wrong username or password");
    }
   },
   beforeSend:function()
   {
    $("#add_err").html("")
   }
  });
  return false;
 });
});
</script>
</head>

<body>
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
	<h1> Welcome to LegoShare</h1>
	<div id = "main"> Your Lego sharing resource. <br>
		We are here to manage your group's shared Lego Collections. <br>
		Come together with family and friends and upload your Lego collection to gain access
		to other's Lego collections.<br><br>
		Please log in to access our Lego Collection.<br>
</div>		
	<?php 
		//you must include this file wherever you work with passwords
		require("PasswordHash.php");
		//require_once("session.php");
		ini_set('display_errors', 'On');
		include 'storedInfo.php';
	?>
		
	<div id = "login_form">
	<form action = "session.php">
		<div>Username: <input type="text" name="username" id = "username"></div>
		<div>Password: <input type="password" name = "password" id = "password"></div>
		<div><input id = "login" type="submit" value="Login"></div>
	</form> </div>
	<div id="shadow" class="popup"></div>
	<div><br><a href = "New_User.php">Create a new account</a><br></div>
	
	<div class="err" id="add_err"></div>
</div>
</body>
</html>