<?php
/*
 *This script is meant to populate/add to the athlete database based on what competitions we have in
 *the comps database. It will search all the tables and add all athlete *name *comp *class *place that
 *do not already exist. Avoid duplicates by no repeating the primary key, which is *key = $name$year$comp.
 */

//Connect to comps.
$link = mysql_connect("localhost", "usoecwei_kow", "f199sup") or die ("Connect Fail.");
mysql_select_db("usoecwei_comps", $link) or die ("Select Fail.");

//Make an array of all meet names. Double loop will look through them all.
$comps = array("NationalChampionship","AmericanOpen","JuniorNationals","OlympicTrials","SchoolageNationals","CollegiateNationals");

for($i=0;$i<sizeof($comps);$i++){
	for($year=1998;$year<=date('Y');$year++){	//1998 is the epoch
		echo "COMP is $comps[$i]<BR>";
		addNonDuplicates(getAllNames($comps[$i],$year),$comps[$i],$year);
	}
}

//Get all the participants from the current meet.
function getAllNames($comp,$year){
	$query = "SELECT name, class, place FROM $year$comp;";
	echo "$query<BR>";
	$results = mysql_query($query);
	return $results;
}

//Add the names to the athletes database. Add *key *name *comp *class *place.
function addNonDuplicates($results,$comp,$year){
	for ($i=0; $i=mysql_fetch_row($results); $i++) {
		$compName = addSpace($comp);	//Get readable version
		$query = "INSERT IGNORE INTO athletes VALUES ('$i[0]$year$comp','$i[0]','$year','$compName','$comp','$i[1]','$i[2]');";
		echo "$query<BR>";
		mysql_query($query);
	}
}

//Change the comps to their name with a space
function addSpace($competition){
	if ($competition === 'NationalChampionship') return 'National Championship';
	else if ($competition === 'AmericanOpen') return 'American Open';
	else if ($competition === 'AmericanOpen') return 'American Open';
	else if ($competition === 'JuniorNationals') return 'Junior Nationals';
	else if ($competition === 'OlympicTrials') return 'Olympic Trials';
	else if ($competition === 'SchoolageNationals') return 'Schoolage Nationals';
	else if ($competition === 'CollegiateNationals') return 'Collegiate Nationals';
}
?>