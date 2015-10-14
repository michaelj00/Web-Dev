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

$(document).ready(function(){
		
		/* All .click functions work similarly documentation can be
				seen here. */
	
	$('#print_part_list').click(function(){

		print_part_list = 1; 	//set print_part_list. 
		$.ajax({
				url: "DataBase_Inter.php",		//url to call from ajax
				type: "POST",			
				data: { print_part_list: print_part_list},
				success: function(html)			//if ajax call is successful 
												//display html results
				{
					$("#printTable").html(html);
				}
		})   //end of ajax call 
	});		// end of printUserTable
	
	$('#add_part').click(function(){

		ElementNum=$("#ElementNum").val();
		desc=$("#desc").val();
		if (desc == "")
		{
			$("#printTable").html("   You did not enter a description.");
		} 		
		else if (validateNum(ElementNum))
		{
			$.ajax({
				url: "DataBase_Inter.php",
				type: "POST",			
				data: { ElementNum: ElementNum, desc :desc},
				success: function(html)
				{
					$("#printTable").html(html); 
				}
			})   //end of ajax call
		}else $("#printTable").html("   You did not enter an valid element number.");
		
	});		//end of click function
	
	$('#deleteLegoParter').click(function(){

		LegoNum = $("#delete_LegoPart").val();
		if (validateNum(LegoNum))
		{
		$.ajax({
				url: "DataBase_Inter.php",
				type: "POST",			
				data: { delete_LegoPart: LegoNum},
				success: function(html)
				{
					$("#printTable").html(html);
				}
		})   //end of ajax call
		}else 
		{
			$("#printTable").html("  You did not enter an valid Lego set number.");
		}
	});		// end of deleteLegoPart click
	
	$('#your_lego_part').click(function(){

		your_lego_part = 1;
		$.ajax({
				url: "DataBase_Inter.php",
				type: "POST",			
				data: { your_lego_part: your_lego_part},
				success: function(html)
				{
					$("#printTable").html(html);
				}
		})   //end of ajax call 
	});		// end of printUserTable

	
	$('#same_Lego_Parts').click(function(){

		LegoNum = $("#same_LegoPart").val();
		if (validateNum(LegoNum))
		{
		$.ajax({
				url: "DataBase_Inter.php",
				type: "POST",			
				data: { same_LegoPart: LegoNum},
				success: function(html)
				{
					$("#printTable").html(html);
				}
		})   //end of ajax call
		}else 
		{
			$("#printTable").html("  You did not enter an valid Lego set number.");
		}
	});		// end of deleteLegoPart click

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
	Welcome to the missing sock page! I mean missing PART page.<br>
		It is here we collect all the groups missing parts and once the list is long enough
		we will make a bulk order and have them shipped to one address.<br>
		We'll email you when they are ready.<br><br>
	
	Please note: Missing pieces uses Lego's unique element id for tracking. <br>
		  If you need help finding Lego's unique piece number please follow this link Lego's website and there. <br>
	<a href = "http://shop.lego.com/en-US/Pick-A-Brick-ByTheme" target = "_blank">Lego piece search</a>
	
	<a href = "DataBase_Page.php" style = "text-align:right"> Back to Main Page</a>
	</h4>
	</div>

		
		
	<!-- Add, Delete, Return, Check out, Search Section   -->
<div class = "container" >
	<div class = "row">
		<div class = "col-md-2">
				<!--- Add a missing piece the the missing piece table -->
			<h3>Add a Missing Piece to the Next Order</h3>
			<form  id ="add_part_form" method = "POST">
				Lego Element Number (for grading any integer can be used)
				<input type="text" name="ElementNum" id = "ElementNum"><span id = "not_int"></span><br>
				<input type="text" name = "desc" id = "desc"><span id = "not_disc"></span>Description:<br>
				If Multiple Parts are Needed they require seperate additions<br>
				<input class = "btn btn-primary" type="button" id = "add_part"  value=" add part" ><br>
			</form>
		</div>

		<div class = "col-md-2">
				<!--- View the entire missing piece table -->
			<h3>View Next Part Order</h3>	
			<form id = "view_part_list" method = "POST">
				<input class = "btn btn-primary" type = "button" id = "print_part_list" value = "Print out part list" ><span id = "not_int"></span><br>
			</form>
		</div>
		
		<div class = "col-md-2">
				<!--- Delete a missing piece the the missing piece table -->			
			<h3>Delete a Part</h3>	
			<form id = "delete_LegoParts" method = "POST">
				<div>Please enter a Lego Element Number to delete
				<input type="text" name = "delete_LegoPart" id = "delete_LegoPart" ><span id = "not_int"></span><br>
				<input class = "btn btn-primary" type = "button" id = "deleteLegoParter" value = "Delete a Lego Part" >
				</div>
		</form>	
		</div>
	
		<div class = "col-md-2">
				<!--- View the missing piece you have requested -->			
			<h3>View Your Requested Parts</h3>	
			<form id = "your_parts" method = "POST">
				<input class = "btn btn-primary" type = "button" id = "your_lego_part" value = "See Your Parts" >
		</form>	
		</div>
		
		<div class = "col-md-2">
				<!--- This tests the many to many relationship. Enter a part number to see who has requested the 
						same part  -->
			<h3>See Who Ordered the Same Part</h3>	
			<form id = "same_Lego_Part" method = "POST">
				<div>Please enter a Lego Element Number to see matches
				<input type="text" name = "same_LegoPart" id = "same_LegoPart" ><span id = "not_int"></span><br>
				<input class = "btn btn-primary" type = "button" id = "same_Lego_Parts" value = "See Same Parts" ></div>
		</form>	
		</div>
	
	</div>
</div>

	


	<!-- JumboTron  is where everything will display -->
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