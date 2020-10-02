	<!DOCTYPE html>
	<html lang="en">
	<head>
		<title>test submit persona</title>
	</head>

	<script src="http://code.jquery.com/jquery-latest.min.js"></script>

	<body>
	<script type="text/javascript">

 
		$(document).ready(function(){
			//initialize number of boxes in largest scope
			var counter = 2;
			//when you click something with an id='addButton'
			$("#addButton").click(function(){
				if(counter>999){
					alert("Can't have more than 999 personas");
					return false;
				}
				counter++;
				//if there aren't too many boxes, use createElement to make a new one
				//with the id='TextBoxDiv2'
				var newTextBoxDiv = $(document.createElement("div")).attr("id", "TextBoxDiv" + counter);
				
				//(target).after(content to insert)
				//insert all this html after the <div id=TextBoxDiv2></div> element
				newTextBoxDiv.after().html('<label>Persona #'+ counter + ' : </label>' + '<input type="text" name="personas" id="textbox' + counter + '" value="" >');
				//add newTextBox element to element with id=TextBoxesGroup
				newTextBoxDiv.appendTo("#TextBoxesGroup");
			});

			$("#removeButton").click(function () {
				if(counter==2){
					  alert("Can't have less than 2 personas in a group");
					  return false;
				   }   	
				//remove element with id=TextBoxDiv2
				$("#TextBoxDiv" + counter).remove();
				counter--;
			});
					

			var personas = [];
			$("#submitall").click(function () {
				
				//for every textbox get the inputted value
				for(i=0; i<counter; ){
					i++;
					personas.push($('#textbox'+i).val());
				}

			});


 		}); 


	</script>


	<p>Enter the name of the "persona group" in the following box. Examples: 'Meyers Briggs types', 'The Always Sunny cast', 'Pokemon elemental types', etc</p>
	<form action="action_page.php" method="post">
	Persona Group Name: <input type="text" name="groupname">
	<br/>


	<p>Enter the all the "persona names" for your persona group in the following boxes. You can add as many personas as you need.</p>
	<input type="button" value="Add Persona" id="addButton">
	<input type="button" value="Remove Persona" id="removeButton">
	<div id="TextBoxesGroup">
		<div id="TextBoxDiv1">
			<label>Persona #1 : </label><input type="textbox" id="textbox1" name="personas">
		</div>
		<div id="TextBoxDiv2">
			<label>Persona #2 : </label><input type="textbox" id="textbox2" name="personas">
		</div>
	</div>


	<!-- <input type="button" value="Get TextBox Value" id="getButtonValue"> -->
	
	<br/>
	<input type="submit" id="submitall" value="Submit that persona group name and these personas">
	</form>
	</body>
	</html>

