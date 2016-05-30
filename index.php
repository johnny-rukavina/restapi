<?php
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">  
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>	
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
  <title>JSON REST API DEMO</title>		
  <link rel="stylesheet" href="css/style.css">
  <link href='https://fonts.googleapis.com/css?family=Lato:300' rel='stylesheet' type='text/css'>	
</head>
<body>	   
<div class="container">
	<h1>JSON REST API DEMO VERSION 2</h1>		
</div>
<div class="container">	
	<div>
		<form class="form-inline" id="mainform" action="index.php" method="POST">
			<div class="form-group">
				<label for="providers">Providers:</label>
				<select class="form-control" id="providers">				
				</select>
			</div>
			<div class="form-group">
				<button type="button" class="btn btn-info" data-target="#edit" onclick="hideDivs('#edit','#delete','#add'); getData();">Edit</button>		 
				<button type="button" class="btn btn-info" data-target="#delete" onclick="deleteData();">Delete</button>		 
				<button type="button" class="btn btn-info" data-target="#add" onclick="hideDivs('#add','#delete','#edit')">Add</button>		 
			</div>
		</form>
	</div>
	<div id="edit" class="collapse">		
		<form class="form-inline" id="editform" action="index.php" method="POST">
			<div class="form-group">
		    <label for="name">Name</label>
		    <input type="text" class="form-control" id="name" placeholder="Enter name">	
			</div>	
			<div class="form-group">
		    <label for="location">Location</label>
		    <input type="text" class="form-control" id="location" placeholder="Enter location">
			</div>
			<div class="form-group">
		    <label for="phone">Phone</label>
		    <input type="text" class="form-control" id="phone" placeholder="Enter phone">			
			</div>			
			<div class="form-group">
		    <label for="services">Services</label>
		    <select multiple class="form-control" id="services" size="8">
		    </select>
			</div>
			<div class="button-group">	
				<button type="button" class="btn btn-info" data-target="#save" onclick="saveData()">Save</button>	
				<button type="button" class="btn btn-info" data-target="#cancel" onclick="hideDivs('#edit','#delete','#add');">Cancel</button>					
			</div>
		</form>
	</div>
	<div id="add" class="collapse">		
		<form class="form-inline" id="newform" action="index.php" method="POST">
			<div class="form-group">
		    <label for="name_new">Name</label>
		    <input type="text" class="form-control" id="name_new" placeholder="Enter name">		
		    <label for="location_nw">Location</label>
		    <input type="text" class="form-control" id="location_new" placeholder="Enter location">
		    <label for="phone_new">Phone</label>
		    <input type="text" class="form-control" id="phone_new" placeholder="Enter phone">	    
			</div>
			<div class="form-group">
		    <label for="services_new">Services</label>
		    <select multiple class="form-control" id="services_new" size="8">
		    </select>
			</div>
			<div class="button-group">	
					<button type="button" class="btn btn-info" data-target="#save" onclick="saveNew()">Save</button>	
					<button type="button" class="btn btn-info" data-target="#cancel" onclick="hideDivs('#add','#delete','#edit');">Cancel</button>					
			</div>
		</form>
	</div>
	<div id="confirmsave" class="collapse">
		<p>Provider information updated.</p>
	</div>
	<div id="confirmnew" class="collapse">
		<p>New Provider added.</p>
	</div>		
	<div id="delete" class="collapse">
		<p>Provider Deleted.</p>
	</div>			
</div>
</body>
</html>
<script type="text/javascript" src="demo.js"></script>
