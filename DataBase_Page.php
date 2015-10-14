<?php session_start();
	
	require('bookmark_fns.php');
	if (!isset($_SESSION['uid']))
	{redirectFail();

	}else
	{
?>
<!DOCTYPE HTML>
<html>
<head>
	<meta charset="UTF-8">
	<title>LegoShare Database</title>
	
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="styles.css" />
	<script src="jquery-1.11.0.min.js"></script>
	<script src="js/bootstrap.js" ></script>
	
</head>


<body>
<script type="text/javascript"> 
//<meta name "viewport" content = "width=device-width, intial-scale=1.0">
$(document).ready(function(){
	$('#add').click(function(){

		LegoNum=$("#LegoNum").val();
		disc=$("#disc").val();
		if (disc == "")
		{
			$("#printTable").html("   You did not enter a description.");
		}else if (validateNum(LegoNum))
		{
			$.ajax({
				url: "DataBase_Inter.php",
				type: "POST",			
				data: { LegoNum: LegoNum, disc :disc},
				success: function(html)
				{
					/*if(html =='true')
					{
						$("#printTable").html("Lego set added");
						$("#not_int").html("");
					}
					else if(html =='false') 
					{
						$("#printTable").html("This Lego set is already in our collection.");
						$("#not_int").html("");
					}else
					{*/
						$("#printTable").html(html);//"Server failed. Please try your request again later.");
						$("#not_int").html("");
					//}
				}
			})   //end of ajax call
		}else $("#printTable").html("   You did not enter an valid set number.");
		
	});		//end of click function
	
	$('#search').click(function(){

		LegoNum=$("#LegoSearch").val();
		if (validateNum(LegoNum))
		{
			$.ajax({
				url: "DataBase_Inter.php",
				type: "POST",			
				data: { searchLegoNum: LegoNum},
				success: function(html)
				{
				//if(html =='false') 
				//{
					$("#printTable").html(html);
					$("#not_int").html("");
					$("#not_int1").html("");
					$("#not_int2").html("");
					$("#not_int3").html("");
					$("#not_int4").html("");
				//}else
				/*{
					$("#printTable").html(html);
					$("#not_int").html("");
					$("#not_int1").html("");
					$("#not_int2").html("");
					$("#not_int3").html("");
					$("#not_int4").html("");
				}*/
			}
		})   //end of ajax call
		}else
		{
			$("#printTable").html("You did not enter an valid Lego set number.");
			$("#not_int").html("");
			$("#not_int2").html("");
			$("#not_int3").html("");
			$("#not_int4").html("");	
		}
	});		//end of search click function
		
	$('#printLegoTable').click(function(){

		printLegoTable = 1;
		$.ajax({
				url: "DataBase_Inter.php",
				type: "POST",			
				data: { printLegoTable: printLegoTable},
				success: function(html)
				{
					$("#printTable").html(html);
					$("#not_int").html("");
					$("#not_int1").html("");
					$("#not_int2").html("");
					$("#not_int3").html("");
					$("#not_int4").html("");
				}
		})   //end of ajax call
	});		//end of printLegoTable call
	
	$('#printUserTable').click(function(){

		printUserTable = 1;
		$.ajax({
				url: "DataBase_Inter.php",
				type: "POST",			
				data: { printUserTable: printUserTable},
				success: function(html)
				{
					$("#printTable").html(html);
					$("#not_int").html("");
					$("#not_int1").html("");
					$("#not_int2").html("");
					$("#not_int3").html("");
					$("#not_int4").html("");
				}
		})   //end of ajax call 
	});		// end of printUserTable
	
	$('#checkOutLego').click(function(){

		LegoNum = $("#checkOut").val();
		if (validateNum(LegoNum))
		{
		$.ajax({
				url: "DataBase_Inter.php",
				type: "POST",			
				data: { checkOutLego: LegoNum},
				success: function(html)
				{
					$("#printTable").html(html);
					$("#not_int").html("");
					$("#not_int1").html("");
					$("#not_int2").html("");
					$("#not_int3").html("");
					$("#not_int4").html("");
				}
		})   //end of ajax call
		}else 
		{
			$("#printTable").html("  You did not enter an valid Lego set number.");
			$("#not_int").html("");
			$("#not_int1").html("");
			$("#not_int3").html("");
			$("#not_int4").html("");
		}
	});		// end of checkOutLego click
	
	$('#returnout').click(function(){

		LegoNum = $("#returnLegoSet").val();
		if (validateNum(LegoNum))
		{
			$.ajax({
				url: "DataBase_Inter.php",
				type: "POST",			
				data: { returnLegoSet: LegoNum},
				success: function(html)
				{
					$("#printTable").html(html);
					$("#not_int").html("");
					$("#not_int1").html("");
					$("#not_int2").html("");
					$("#not_int3").html("");
					$("#not_int4").html("");
				}
			})   //end of ajax call
		}else 
		{
			$("#printTable").html("  You did not enter an valid Lego set number.");
			$("#not_int").html("");
			$("#not_int1").html("");
			$("#not_int2").html("");
			$("#not_int4").html("");
		}
	});		// end of returnOut click
	
	$('#deleter').click(function(){

		LegoNum = $("#deleteLegoSet").val();
		if (validateNum(LegoNum))
		{
		$.ajax({
				url: "DataBase_Inter.php",
				type: "POST",			
				data: { deleteLegoSet: LegoNum},
				success: function(html)
				{
					$("#printTable").html(html);
					$("#not_int").html("");
					$("#not_int1").html("");
					$("#not_int2").html("");
					$("#not_int3").html("");
					$("#not_int4").html("");
				}
		})   //end of ajax call
		}else 
		{
			$("#printTable").html("  You did not enter an valid Lego set number.");
			$("#not_int").html("");
			$("#not_int1").html("");
			$("#not_int2").html("");
			$("#not_int3").html("");
		}
	});		// end of deleteOut click
		
	});		//end of doc ready

	function validateNum(LegoNum) //Verifies that LegoNum is a number. If not database
	{							  //insertion and queries will fail.
		return /^\+?[1-9]\d*$/.test(LegoNum);
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
			<div class = "collapse navbar-collapse navHeaderCollapse">
				<ul class= "nav navbar-nav navbar-right">
					<li class = "active"><a href='logout.php' id='logout'>Logout</a> </li>
				</ul>
			</div>
		</div>
	</div>
<div class = "container">
	<h4>
	Here you can add Lego collections you would like to share with your friends and family.<br>
		  Simply add the Lego sets you would like to share and check out Lego sets from your friends.<br>
		  It's like a Lego Library!!<br>
		  When an item is checked out simply email the owner and setup a time to pick it up.<br><br>
	
	
		  Please note: This Library uses Lego's unique set number for tracking. <br>
		  If you need help finding Lego's unique set number please follow this link Lego's website and there. <br>
	<a href = "http://service.lego.com/en-us/buildinginstructions" target = "_blank">Lego set number search</a>
	</h4>
	</div>

		
		
	<!-- Add, Delete, Return, Check out, Search Section   -->
<div class = "container" >
	<div class = "row">
		<div class = "col-md-2">
			<h3>Add a Set</h3>
			<form  id ="addForm" method = "POST">
				Lego Set Number (for grading any integer can be used)<input type="text" name="LegoNum" id = "LegoNum"><span id = "not_int"></span><br>
				Description: <input type="text" name = "disc" id = "disc"><span id = "not_disc"></span><br>
				<input class = "btn btn-primary" type="button" id = "add"  value="add" ><br>
			</form>
		</div>

		<div class = "col-md-2">
			<h3>Search a Set</h3>	
			<form id = "searchLegoForm" method = "POST">
				Please note you can only search by set number<br>
				<input type="text" name = "LegoSearch" id = "LegoSearch"><span id = "not_int1"></span>
				<input class = "btn btn-primary" type = "button" id = "search" value = "Search for a Lego Set" name ="search">
			</form>
		</div>
		<div class = "col-md-2">
			<h3>Check out a Set</h3>	
			<form id = "checkOutForm" method = "POST">
				<div>Please enter a Lego Number to check out<input type="text" name = "check" id = "checkOut">
				<input class = "btn btn-primary" type = "button" value = "Check out a Lego" name = "checkOutLego" id = "checkOutLego"><span id = "not_int2"></span></div>
		</form>	
		</div>
		<div class = "col-md-2">
			<h3>Return a Set</h3>	
				<form id = "returnForm" method = "POST">		
				<div>Please enter a Lego Number to return<input type="text" name = "returnLegoSet" id = "returnLegoSet">
				<input class = "btn btn-primary" type = "button" value = "Return a Lego" name = "returnout" id = "returnout"><span id = "not_int3"></span></div>
		</form>	
		</div>
		
		<div class = "col-md-2">
			<h3>Delete a Set</h3>	
			<form id = "deleteForm" method = "POST">
				<div>Please enter a Lego Number to delete<input type="text" id = "deleteLegoSet" name = "deleteLegoSet">
				<input class = "btn btn-primary" type = "button" value = "Delete a Lego" id = "deleter" name = "deleter"><span id = "not_int4"></span></div>
		</form>	
		</div>
	
	</div>
</div>

	<!-- Print Users and Lego Collection Section   -->
<div class = "container" >
	<div class = "row">
		<div class = "col-md-2">
			<h3>Print the listing of all users</h3>
			<form id = "printUsersForm" method = "POST">
			<input class = "btn btn-primary" type = "button" id = "printUserTable" value = "Print out listing of users" name ="users">
		</form>	
		</div>
	<div class = "col-md-3">	
			<h3>See our Combined Lego Collection</h3>
			<form id = "printTableForm" method = "POST">
				<input class = "btn btn-primary" type="button" value = "Print Lego table" name = "print" id = "printLegoTable">
			</form>
		</div>
	
	<div class = "col-md-3">
		<h3>Go to Missing Pieces Page</h3>
			<form id = "GotoPiecesPage" action = "Pieces.php" method = "POST">
				<input class = "btn btn-primary" type="submit" value = "Go to Pieces Page" id = "GotoPiecesPage">
			</form>
		</div>

	<div class = "col-md-2">
		<h3>Go to Photos Page</h3>
			<form id = "PhotosPage" action = "Photos.php" method = "POST">
				<input class = "btn btn-primary" type="submit" value = "Go to Photos Page" id = "GotoPhotosPage">
			</form>
		</div>
	</div>
</div>
		
	
	<!-- JumboTron   -->
<div class = "container">
	<div class = "jumbotron">
		
		<p id = "printTable"></p>
	</div>
</div>
	<!-- Lower Nav Bar  -->
<div class = "navbar navbar-default navbar-fixed-bottom">
	<div class = "container">
		<p class = "navbar-text">Site by Michael Jones</p>
	</div>
</div>
<?php 
	}  //end isset session variable
?>
</body>
</html>