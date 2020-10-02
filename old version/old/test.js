	<script src="http://code.jquery.com/jquery-latest.min.js"></script>

	<body>
	<script type="text/javascript">
		var xhttp_forajax = new XMLHttpRequest();
		xhttp_forajax.open("GET", "test.txt", true);
		xhttp_forajax.send();

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
				newTextBoxDiv.after().html('<label>Persona #'+ counter + ' : </label>' + '<input type="text" name="textbox' + counter + '" id="textbox' + counter + '" value="" >');
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
					
			$("#getButtonValue").click(function () {
				//initialize msg in case nothing was input
				var msg = '';
				//for every textbox get the inputted value
				for(i=0; i<counter; ){
					i++;
					msg += "\n Persona #" + i + " : " + $('#textbox' + i).val();
				}
				alert(msg);
			});

			// $("#submit").click(function() {
			// 	var groupName;
			// 	groupName = $("#groupName").val();
			// });

			// $("#finalsubmit").click(function() {
			// 	var plist = [];
			// 	var groupName;
			// 	groupName = $("#groupName").val();
			// 	for(i=0; i<counter; ){
			// 		i++;
			// 		plist.append($('#textbox' + i).val());
			// 	}

			// });

			// function onClick(event) {
			// 	alert('hi');
			// 	for(i=0; i<counter; ){
			// 		i++;
			// 		titles += $('#textbox' + i).val();
			// 	}

			// 	$('#textbox' + i).val();

			// 	titles = $('input[name^=titles]').map(function(idx, elem) 
			// 		{return $(elem).val();}).get();
			// }


		});


	</script>