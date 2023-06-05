<?php
header('Access-Control-Allow-Methods: GET');

define('DATA_PATH', "homework_input.php");
define('MODEL_PATH', "modelClass.php");

include DATA_PATH;
include MODEL_PATH;


if( $_SERVER['REQUEST_METHOD'] !== 'GET' ) return false;


if( isset($_GET['testcase'])  && in_array($_GET['testcase'], [1,2,3,4]))
{
	switch ($_GET['testcase']) {
		case '1':
			$testcase = $exampleData;
			break;
		case '2':
			$testcase = $exampleData1;
			break;
		case '3':
			$testcase = $exampleData2;
			break;
		case '4':
			$testcase = $exampleData3;
			break;
		
		default:
			$testcase = $exampleData;
			break;
	}

	$model = new Model($testcase);
	if( !$model->checkMandSubjects() ) { echo "Nincsenek meg a kötelező érettségi tárgyak"; return false; }
	if( !$model->checkProfSubject() ) { echo "Nincs meg a kötelező szakmai tárgy"; return false; }
	if( !$model->checkOptSubjects()  ) { echo "Nincs meg a kötelezően választható szakmai tárgy"; return false; }
	if( !$model->check20percent()    ) { echo "Nincs meg a 20%"; return false; }

	

	echo "<pre> getProfSubjectScore: ";
	echo $output = $model->getProfSubjectScore();
	echo "<br> getBestOptSubjectScore: ";
	echo $output = $model->getBestOptSubjectScore();
	echo "<br> getBaseScore: ";
	echo $output = $model->getBaseScore();
	echo "<br> getLangExamsScore: ";
	echo $output = $model->getLangExamsScore();
	echo "<br> getPlusScore: ";
	echo $output = $model->getPlusScore();
	echo "</pre>";
}


?>