<?php

/**
 * 
 */
class Model
{

	const MAND_EXAMS = ["magyar nyelv és irodalom", "történelem", "matematika"];
	
	const ELTE_IK_PRO = 
	[
		"mand" => "matematika",
		"opt"  => ["biológia", "fizika", "informatika", "kémia"]
	];
	
	const PPKE_BTK_ANG = [
		"mand" =>  "angol (emelt szinten)",
		"opt"  =>  ["francia", "német", "olasz", "orosz", "spanyol", "történelem"]
	];
	
	
	const RESULT_TABLE = 
	[
		false => "Nincs rendben",
		true =>  "Rendben van."
	];

	const PLUS_LANG_POINTS = 
	[
		"B2" => 28,
		"C1" => 40
	];

	private array  $testcase;
	private array  $maturesubjects;
	private array  $maturesubjectnames;
	private string $major;
	private array  $langexams;

	
	public function __construct(array $testcase)
	{
		$this->testcase = $testcase;
		$this->maturesubjects = $this->getmaturesubjects();
		$this->maturesubjectnames = $this->getmaturesubjectnames();
		$this->major = $this->getMajor();
		$this->langexams = $this->getLangExams();
	}

	public function getmaturesubjects() : array
	{
		$_maturesubjects = $this->testcase['erettsegi-eredmenyek'];
		return $_maturesubjects;
	}

	public function getmaturesubjectnames() : array
	{
		$_array =  $this->testcase['erettsegi-eredmenyek'];
		$_maturesubjectnames = array_map(fn ($a) => $a['nev'], $_array);
		return $_maturesubjectnames;
	}


	public function getMajor() : string
	{
		$_array =  $this->testcase["valasztott-szak"];
		$_major = $_array['egyetem'] . "_" . $_array['kar'] . "_" . substr($_array['szak'], 0, 3);
		return strtoupper($_major);
	}

	public function getLangExams() : array
	{
		$_plusPoints = $this->testcase['tobbletpontok'];
		$_langExams = [];
		foreach ($_plusPoints as $_plusPoint) {
			if( $_plusPoint['kategoria'] == 'Nyelvvizsga' ) $_langExams[] = $_plusPoint;
		}
		return $_langExams;
	}


	function checkMandSubjects() : bool
	{
		if( !is_array( $this->maturesubjectnames ) ) return false;
		$_arraydiff = array_diff(self::MAND_EXAMS, $this->maturesubjectnames);
		return count($_arraydiff) == 0;
	}


	function checkProfSubject() : bool
	{
		if( !is_array( $this->maturesubjectnames ) ) return false;
		$_major = constant('self::' . $this->major);
		$_prof = $_major['mand'];
		return in_array($_prof, $this->maturesubjectnames);
	}


	function checkOptSubjects() : array
	{
		if( !is_array( $this->maturesubjectnames ) ) return false;
		$_major = constant('self::' . $this->major);
		$_arrayinter = array_intersect($this->maturesubjectnames, $_major['opt']);
		return $_arrayinter;
	}


	public function check20percent() : bool
	{
		foreach ($this->maturesubjects as $maturesubject) {
			if ( (int) $maturesubject['eredmeny'] < 20) {
				return false;
			}
		}
		return true;
	}

	public function getLangExamsScore() : int
	{
		$_langExamScore = 0;
		foreach ($this->langexams as $langexam)
		$_langExamScore += self::PLUS_LANG_POINTS[$langexam['tipus']] ?? '0';
		return $_langExamScore;
	}

	
	public function getProfSubjectScore() : int
	{
		$_major = constant('self::' . $this->major);
		$_prof = array_filter($this->maturesubjects, fn($ms) => $ms['nev'] == $_major['mand']);
		$_prof = array_values($_prof);
		return (int) $_prof[0]['eredmeny'];
	}


	public function getBestOptSubjectScore() : int
	{
		$_major = constant('self::' . $this->major);
		$_arrayinter = array_filter($this->maturesubjects, fn($ms) => in_array($ms['nev'], $_major['opt']) );
		usort($_arrayinter, fn($a, $b) => $a['eredmeny']<$b['eredmeny']);
		return (int) $_arrayinter[0]['eredmeny'];
	}


	# kötelező tárgy pontértékét és 
	# a legjobban sikerült kötelezően választható tárgy pontértékét 
	# kell összeadni és az így kapott összeget megduplázni.

	# $mandMatureSubject = getMandMatureSubject();
	# $bestProfSubject = getBestProfSubject();
	# $score = ( $mandMatureSubject + $bestProfSubject ) * 2
	public function getBaseScore() : int
	{
		$score = ( $this->getProfSubjectScore() + $this->getBestOptSubjectScore() ) * 2;
		return $score;
	}


	public function getPlusScore() : int
	{
		$_score = 0;
		foreach ($this->maturesubjects as $maturesubject) {
			if($maturesubject['tipus'] == "emelt" && (int) $maturesubject['eredmeny'] >19 ) $_score += 50;
		}
		return $_score;
	}

	

}





# function checkMandSubjects($value_array)
# {
# 	if( !is_array( $value_array ) ) return false;
# 	$_arraydiff = array_diff(MAND_EXAMS, $value_array);
# 	return $_arraydiff;
# }
# 
# 
# function checkProfSubjects($value_array = [])
# {
# 	if( !is_array( $value_array ) ) return false;
# 	$_arraydiff = array_diff(MAND_EXAMS, $value_array);
# 	return $_arraydiff;
# }
?>