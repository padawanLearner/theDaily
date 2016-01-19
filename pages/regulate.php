<?php 
function connectToSQL(){
	//The first connection is for localhost testing of the app	
	if($_SERVER['HTTP_HOST'] == "localhost"){
		require('../../utility/dbConnect.php');
	}
	else{
		require('../../../phpFunctions/dbConnect.php');
	}
}

function getCategories(){
	connectToSQL();
	$query= "SELECT distinct category from questions where category !=''";
	$GLOBALS['stmt'] = mysqli_prepare( $GLOBALS['conn'], $query);		
	mysqli_stmt_execute($GLOBALS['stmt']);

	//Verify failure or success
	if(!$GLOBALS['stmt']){
		echo("Error description: " . mysqli_error($GLOBALS['conn']));
	}
	else{
		// echo "Query Success";
	}
}

function displayCategories(){
	getCategories();	
	mysqli_stmt_bind_result($GLOBALS['stmt'], $category);

	/* fetch values */
	while (mysqli_stmt_fetch($GLOBALS['stmt'])) {
		echo "<input type='radio' name='category' value='".$category."'>".$category."<br>";
	}

	/* close statement */
	mysqli_stmt_close($GLOBALS['stmt']);



}

function getDaily($day){

	connectToSQL();
	//PDO mysqli insert question, each question has the question itself, the answer, and the category
	//$query= file_get_contents("../sql/getDaily.sql");
	$query = "SELECT question,answer,category 
	FROM questions 
	LEFT JOIN dailies 
	ON questions.questionId = dailies.questionId 
	WHERE category = 'Vocabulary' AND dailies.day = '$day' 
	ORDER BY RAND() 
	LIMIT 1";  

	$stmt = mysqli_prepare( $GLOBALS['conn'], $query);		
	mysqli_stmt_execute($stmt);

	//Verify failure or success
	if(!$stmt){
		echo("Error description: " . mysqli_error($GLOBALS['conn']));
	}
	else{
		// echo "Query Success";
	}

	mysqli_stmt_bind_result($stmt, $question, $answer,$category);

	$questions = array();
	$answers = array();
	$categories = array();
	$ctr=0;
	while (mysqli_stmt_fetch($stmt)) {		
		array_push($questions,$question);
		array_push($answers,$answer);
		array_push($categories, $category);
	}

	//Store quiz into SESSION 
	$_SESSION["questions"] = $questions;
	$_SESSION["answers"] = $answers;
	$_SESSION["categories"] = $categories;
	$_SESSION["ctr"] = 0;

	//Close connections
	mysqli_stmt_close($stmt);
	mysqli_close($GLOBALS['conn']);
}
function getNewDaily(){	
	connectToSQL();
	//PDO mysqli insert question, each question has the question itself, the answer, and the category
	$query= file_get_contents("../sql/getNewDaily.sql");
	$stmt = mysqli_prepare( $GLOBALS['conn'], $query);		
	mysqli_stmt_execute($stmt);

	//Verify failure or success
	if(!$stmt){
		echo("Error description: " . mysqli_error($GLOBALS['conn']));
	}
	else{
		// echo "Query Success";
	}

	mysqli_stmt_bind_result($stmt, $question, $answer,$category);

	$questions = array();
	$answers = array();
	$categories = array();
	$ctr=0;
	while (mysqli_stmt_fetch($stmt)) {		
		array_push($questions,$question);
		array_push($answers,$answer);
		array_push($categories, $category);
	}

	//Store quiz into SESSION 
	$_SESSION["questions"] = $questions;
	$_SESSION["answers"] = $answers;
	$_SESSION["categories"] = $categories;
	$_SESSION["ctr"] = 0;

	//Close connections
	mysqli_stmt_close($stmt);
	mysqli_close($GLOBALS['conn']);

}		 











/*
   session_start();

   if ((isset($_POST['question'])) &&(isset($_POST['answer']))){

   if($_SERVER['HTTP_HOST'] == "localhost"){
   require('../../utility/dbConnect.php');
   }
   else{
   require('../../../phpFunctions/dbConnect.php');
   }
//PDO mysqli insert question, each question has the question itself, the answer, and the category
$query= file_get_contents("../sql/insertQuestionAnswerCategory.sql");
$stmt = mysqli_prepare( $GLOBALS['conn'], $query);		
mysqli_stmt_bind_param($stmt, "sss", $newQuestion, $newAnswer, $newCategory);
$newQuestion = $_POST['question'];
$newAnswer = $_POST['answer'];
$newCategory = $_POST['category'];


mysqli_stmt_execute($stmt);
//Verify failure or success
if(!$stmt){
echo("Error description: " . mysqli_error($GLOBALS['conn']));
}
else{
echo "Question created. Add button to return to home page";
}
//Close connections
mysqli_stmt_close($stmt);
mysqli_close($GLOBALS['conn']);
}
elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['length']) && isset($_POST['category'])){

if($_SERVER['HTTP_HOST'] == "localhost"){
require('../../utility/dbConnect.php');
}
else{
require('../../../phpFunctions/dbConnect.php');
}
$query = "SELECT question, answer FROM questions WHERE category =";
foreach ($_POST['category'] as $category) {
$query .= ("'".$category."'or");
}

$query = substr($query,0, strlen($query)-2)."ORDER BY RAND() LIMIT ".$_POST['length'];


if ($stmt = mysqli_prepare($GLOBALS['conn'], $query)) {


mysqli_stmt_execute($stmt);

mysqli_stmt_bind_result($stmt, $question, $answer);


$questions = array();
$answers = array();
$ctr=0;
while (mysqli_stmt_fetch($stmt)) {		
array_push($questions,$question);
array_push($answers,$answer);
}

//Store quiz into SESSION 
$_SESSION["questions"] = $questions;
$_SESSION["answers"] = $answers;
$_SESSION["ctr"] = 0;

mysqli_stmt_close($stmt);
}		 
//Close connection
mysqli_close($GLOBALS['conn']);


exit(header('Location: quiz.php'));
}
else{
	echo "go to homepage";
}
*/

?>
