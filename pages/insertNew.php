<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<!-- Bootstrap -->
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>





<script type="text/javascript">
/*
   This function returns the value of the currently selected radio button
 */
function getCheckedRadio(radioGroup) {
	for (var i = 0; i < radioGroup.length; i++) {
		var button = radioGroup[i];
		if (button.checked) {
			return button;
		}
	}
	return undefined;
}


/*
   /This function updates the serverside info for the query

 */
function addQuestion(){
	var checkedButton = getCheckedRadio(document.getElementsByName("category"));
	if (!checkedButton) {
		alert("Invalid category");
	}




	xmlhttp=new XMLHttpRequest(); //make ajax object
	var params = "action=add&question="+document.getElementById("question").value+"&answer="+document.getElementById("answer").value+"&category="+checkedButton.value;
	xmlhttp.open("POST","insert.php",true);

	//Send the proper header information along with the request
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.setRequestHeader("Content-length", params.length);
	xmlhttp.setRequestHeader("Connection", "close");


	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){  //the callback that will receive the response   
			alert(xmlhttp.responseText);
		}
	}

	xmlhttp.send(params);

}

/*
   Reset all the data from the questions the user has planned to enter into the database
 */
function reset(){
	xmlhttp=new XMLHttpRequest(); //make ajax object
	var params = "action=reset"
		xmlhttp.open("POST","insert.php",true);

	//Send the proper header information along with the request
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.setRequestHeader("Content-length", params.length);
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){  //the callback that will receive the response   
			alert(xmlhttp.responseText);
		}
	}
	xmlhttp.send(params);
}

/*
   Put in motion the insertion of the question(s) on the server
 */
function insertQuestion(){
	xmlhttp=new XMLHttpRequest(); //make ajax object
	var params = "action=insert"
		xmlhttp.open("POST","insert.php",true);

	//Send the proper header information along with the request
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.setRequestHeader("Content-length", params.length);
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){  //the callback that will receive the response   
			alert(xmlhttp.responseText);
		}
	}
	xmlhttp.send(params);
}



//This function appends what the user inputs to the UI
function extendQuery(){
	var node = document.createElement("LI"); 
	node.id = "hmmOk";
	var textnode = document.createTextNode("Question: " + document.getElementById("question").value);         // Create a text node
	node.appendChild(textnode);                              // Append the text to <li>
	document.getElementById("myList").appendChild(node);
}
</script>
</head>

<body>
<nav class="navbar navbar-default" role="navigation">
<div class="navbar-collapse collapse">
<ul class="nav nav-justified">
<li><a href="theDaily.php">see the daily!</a></li>
<li><a href="insertNew.php">insert content</a></li>
</ul>
</div>
</nav>
<ul id="myList">
</ul>
<!-- Insert Question -->
<form id="content"  action="extendQuery()" >
<div class="row">
<div class="col-xs-6">	 
<label for="answer">What is the tip or shortcut?</label>
<br>
<textarea class='form-control' rows="20" name="answer" id="answer"></textarea>
</div>
<div class="col-xs-6">
<label for="question">What does the tip or shortcut do?</label>
<br>
<textarea class='form-control' rows="20" name="question" id="question"></textarea>
</div >

</div>
<br>
<!-- Need checkboxes for category plus a section for "new" category-->
<label for="questionCategory">What program or platform is this tip or shortcut for?</label>
<br>
<?php
require "regulate.php";
displayCategories();
?>
<!-- <input type="text" class="form-control" name="category" id="category"> -->
<br>
<!-- <button type="submit" name="addAnother">Add Another </button>-->
</form>

<button onclick="addQuestion()" name="addAnother2">Click me to add another question</button><br>
<button onclick="reset()" name="reset">I messed up.  Reset all the questions I was going to insert</button><br>
<button onclick="insertQuestion()" name="insertQuestions">I'm done. Insert these questions into the database </button><br>
<br>
<br>
<br>
<form  action='insert.php' method='post' accept-charset='UTF-8'>
<fieldset >
<label for='password' >Password:</label>
<input type='password' name='password' id='password' maxlength="50" />
<input type='submit' name='Submit' value='Submit Questions' />
</fieldset>
</form>
</body>
</html>
