<?php
/*
 *This script is meant to populate/add to the athlete database based on what competitions we have in
 *the comps database. It will search all the tables and add all athlete *name *comp *class *place that
 *do not already exist. Avoid duplicates by no repeating the primary key, which is *key = $name$year$comp.
 */

include 'dbconnect.php';
include 'utils.php';

// Select all the competition tables.
$tablequery =
    "SELECT TABLE_NAME " .
    "FROM INFORMATION_SCHEMA.TABLES " .
    "WHERE TABLE_NAME != 'athletes' AND TABLE_TYPE = 'BASE TABLE' " .
    "ORDER BY TABLE_NAME DESC;";
$result = mysql_query($tablequery) or die ("Unable to get tables.");

// Add all the data in each competition table to the athlete-centric table.
while($row = mysql_fetch_array($result)) {
    $compName = substr($row[0], 4);
    $compYear = substr($row[0], 0, 4);
    addNonDuplicates(getAllNames($row[0]),$compName,$compYear);
}
 
//Get all the participants from the current meet.
function getAllNames($tablename){
	$query = "SELECT name, class, place FROM $tablename;";
	echo "$query<BR>";
	$results = mysql_query($query);
	return $results;
}

//Add the names to the athletes database. Add *key *name *comp *class *place.
function addNonDuplicates($results,$comp,$year){
	for ($i=0; $i=mysql_fetch_row($results); $i++) {
		$compName = prettyPrint($comp);	//Get readable version
		$query = "INSERT IGNORE INTO athletes VALUES ('$i[0]$year$comp','$i[0]','$year','$compName','$comp','$i[1]','$i[2]');";
		echo "$query<BR>";
		mysql_query($query);
	}
}
?>