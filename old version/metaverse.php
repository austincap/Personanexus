<html>
<head>
	<style>
	body {
		font-family: "Courier New", Courier, monospace;
	}

	div.space {
		display: inline-block;

	}

/*	.test span{
		display: none;
		visibility: hidden;
	}
	.test::after {
		visibility: visible;
		content: '@';
	}*/


	</style>
</head>
<body>
	<script src="http://code.jquery.com/jquery-latest.min.js"></script>
	<script type="text/javascript">
	$(document).ready(function(){
		var newid = "11";
		var xpos = 1;
		var ypos = 1;


		$(function(){


			$(window).keydown(function(e){
				var tempid = newid;
				var key = e.which;
				switch(key) {
					case 13:
					if(xpos==0 & ypos==0){
						alert("secret~");
						window.location.href = "http://google.com";
					}
					break;

					case 38:
						if((ypos-1)<0){
							break;
						};
						ypos-=1;
						newid=String(ypos).concat(xpos);
						//alert(newid);
						break;
					case 39:
						if((xpos+1)>7){
							break;
						};
						xpos+=1;
						newid=String(ypos).concat(xpos);
						//alert(newid);
						break;
					case 37:
						if((xpos-1)<0){
							break;
						};
						xpos-=1;
						newid=String(ypos).concat(xpos);
						//alert(newid);
						break;
					case 40:
						if((ypos+1)>4){
							break;
						};
						ypos+=1;
						newid=String(ypos).concat(xpos);
						//alert(newid);
						break;
					default:
						return;
				}
				e.preventDefault();
			
				$(function(){
					document.getElementById(newid).style.color = "red";
				});

				$(function(){
					if (tempid=="00"){
						alert(tempid);
						document.getElementById(tempid).outerHTML='<a href="http://google.com">.</a>';
					} else{
					document.getElementById(tempid).textContent=".";
					document.getElementById(newid).textContent="@";
					}
				});

			});
		});
	});
	</script>
<h1>
<div class="space" id="00"><span class="test"><a href="http://google.com">.</a></span></div><div class="space" id="01"><span class="test">.</span></div><div class="space" id="02"><span class="test">.</span></div><div class="space" id="03"><span class="test">.</span></div><div class="space" id="04"><span class="test">.</span></div><div class="space" id="05"><span class="test">.</span></div><div class="space" id="06"><span class="test">.</span></div><div class="space" id="07"><span class="test">.</span></div><br/><div class="space" id="10"><span class="test">.</span></div><div class="space" id="11"><span class="test">.</span></div><div class="space" id="12"><span class="test">.</span></div><div class="space" id="13"><span class="test">.</span></div><div class="space" id="14"><span class="test">.</span></div><div class="space" id="15"><span class="test">.</span></div><div class="space" id="16"><span class="test">.</span></div><div class="space" id="17"><span class="test">.</span></div><br/><div class="space" id="20"><span class="test">.</span></div><div class="space" id="21"><span class="test">.</span></div><div class="space" id="22"><span class="test">.</span></div><div class="space" id="23"><span class="test">.</span></div><div class="space" id="24"><span class="test">.</span></div><div class="space" id="25"><span class="test">.</span></div><div class="space" id="26"><span class="test">.</span></div><div class="space" id="27"><span class="test">.</span></div><br/><div class="space" id="30"><span class="test">.</span></div><div class="space" id="31"><span class="test">.</span></div><div class="space" id="32"><span class="test">.</span></div><div class="space" id="33"><span class="test">.</span></div><div class="space" id="34"><span class="test">.</span></div><div class="space" id="35"><span class="test">.</span></div><div class="space" id="36"><span class="test">.</span></div><div class="space" id="37"><span class="test">.</span></div><br/><div class="space" id="40"><span class="test">.</span></div><div class="space" id="41"><span class="test">.</span></div><div class="space" id="42"><span class="test">.</span></div><div class="space" id="43"><span class="test">.</span></div><div class="space" id="44"><span class="test">.</span></div><div class="space" id="45"><span class="test">.</span></div><div class="space" id="46"><span class="test">.</span></div><div class="space" id="47"><span class="test">.</span></div><br/>
</h1>
<br>
.....<br>

.....<br>

.....<br>

.....<br>

.....<br>

</body>

</html>
