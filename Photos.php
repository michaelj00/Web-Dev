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
	<script type="text/javascript" src="jquery.form.js"></script>
	<script src="js/bootstrap.js" ></script>
	
</head>


<body>
<script type="text/javascript"> 
//<meta name "viewport" content = "width=device-width, intial-scale=1.0">
$(document).ready(function(){
		
	$('#photo_set_num_buttn').click(function(){

		LegoNum = $("#photo_set_num").val();
		if (validateNum(LegoNum))
		{
		$.ajax({
				url: "DataBase_Inter.php",
				type: "POST",			
				data: { photo_set_num: LegoNum},
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
	});		// end of photo_set_num_buttn click
	
	$('#see_photo_listing').click(function(){
		
		see_photo_listing = 1;
		$.ajax({
				url: "DataBase_Inter.php",
				type: "POST",			
				data: { see_photo_listing: see_photo_listing},
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
	});
		

	var options = { 
        url: "processupload.php",
		target:   '#printTable',   // target element(s) to be updated with server response 
        beforeSubmit:  beforeSubmit,  // pre-submit callback 
        resetForm: true        // reset the form after successful submit 
        }; 
        
    $('#MyUploadForm').submit(function() { 
        $(this).ajaxSubmit(options);  //Ajax Submit form            
           // return false to prevent standard browser submit and page navigation 
        return false; 
    }); 


	//see_photo_listing
	


	});		//end of doc ready
	
	
	function validateNum(LegoNum) //Verifies that LegoNum is a number. If not database
	{							  //insertion and queries will fail.
		return /^\+?[1-9]\d*$/.test(LegoNum);
	}
	//function to check file size before uploading.
function beforeSubmit(){
     //check whether browser fully supports all File API
    if (window.File && window.FileReader && window.FileList && window.Blob)
     {
         if(!$('#set_number').val())
		 {
			$("#printTable").html("You didn't enter a set number");
			return false;		 
		 }
		 
         if( !$('#imageInput').val()) //check empty input filed
         {
             $("#printTable").html("You didn't select a photo");
             return false
         }
         
         var fsize = $('#imageInput')[0].files[0].size; //get file size
         var ftype = $('#imageInput')[0].files[0].type; // get file type
         

         //allow only valid image file types 
         switch(ftype)
         {
             case 'image/png': case 'image/gif': case 'image/jpeg': case 'image/pjpeg':
                 break;
             default:
                 $("#printTable").html("<b>"+ftype+"</b> Unsupported file type!");
                 return false
         }
         
         //Allowed file size is less than 1 MB (1048576)
         if(fsize>1048576) 
         {
             $("#printTable").html("<b>"+fsize +"</b> Too big Image file! <br />Please reduce the size of your photo using an image editor.");
             return false
         }
                 
         //$('#submit-btn').hide(); //hide submit button
         $('#loading-img').show(); //hide submit button
         $("#printTable").html("");  
     }
     else
     {
         //Output error to older browsers that do not support HTML5 File API
         $("#printTable").html("Please upgrade your browser, because your current browser lacks some new features we need!");
         return false;
     }
}
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
	Welcome to the photos page! <br>
		Post your photos of your favorite creations. <br>
		Make your minifigures dance. Put Darth Vader's head on Slave Leah's body! Whatever you want.<br>
		<br><br>
	
	
	<a href = "DataBase_Page.php"> Back to Main Page</a>
	</h4>
	</div>

		
		
	<!-- Add, Delete, Return, Check out, Search Section   -->
<div class = "container" >
	<div class = "row">
		<div class = "col-md-4">
		<!---  All sourcing for image upload done here
			http://www.sanwebe.com/2012/05/ajax-image-upload-and-resize-with-jquery-and-php  action="processUpload.php"--->
		
		<h3>Upload an Photo</h3> 
		<form  method="post"  enctype="multipart/form-data" id="MyUploadForm">
			<input name = "set_num" id = "set_number" type = "text" /> Enter set number<br>
			<input name="image_file" id="imageInput" type="file" />
			<input class = "btn btn-primary" type="submit"  id="submit-btn" value="Upload" />
		
	</form>
	<div id="output"></div>
	</div>
		
	<div class = "col-md-4">
				
		<h3>See a set's photo</h3>
		<form  method="post" id="see_photo">
			<input name = "photo_set_number" id = "photo_set_num" type = "text" /> Enter set number<br>
			<input class = "btn btn-primary" type="button"  id="photo_set_num_buttn" value="See a Set" />
			</form>
	</div>
	<div class = "col-md-4">
				
		<h3>See photo set numbers for testing</h3>
		<form  method="post" id="see_photo_listing">
			<input class = "btn btn-primary" type="button"  id="see_photo_listing" value="See a Photo Numbers" />
		<!--- <img src="images/ajax-loader.gif" id="loading-img" style="display:none;" alt="Please Wait"/> --->
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