<?php
include 'dbconnect.php';

//Get the competition we're looking for from the url.
$key = $_GET['key'];

if(strlen($key) > 0){
    // Sanitize
	$key = mysql_real_escape_string($key);

	// Select stuff. Cha ching. First look for athletes by the key.
	$query =
        "SELECT name, comp, year, class, title " .
        "FROM athletes " .
        "WHERE name LIKE '%$key%'" .
        "ORDER by year DESC;";
	$resultAthletes = mysql_query($query) or die ("Unable to query database for athletes.");

    // Try to find competitions by the key too. Search table names directly.
    $keynospace = preg_replace('/\s+/', '', $key);
    $tablequery =
        "SELECT TABLE_NAME " .
        "FROM INFORMATION_SCHEMA.TABLES " .
        "WHERE TABLE_NAME like '%$keynospace%'";
    $resultComps = mysql_query($tablequery) or die ("Unable to get table names.");

	// All the comps we have for the selected competition are in result[i]'s.
	if ((mysql_num_rows($resultAthletes) == 0) &&
        (mysql_num_rows($resultComps) == 0)){
		echo "No results for " . $key . " as an athlete or competition.";
	}
    else {
        // If there are results, get them and make a list. First athletes.
        if( ! mysql_num_rows($resultAthletes) == 0){
            echo "<h4>Athletes</h4>";
            // Have to wrap everything in paragraph for style sheet.
            echo "<p>";
            while($row = mysql_fetch_array($resultAthletes)) {
                echo "<a onclick='getTableFromSearch(\"$row[4]\",$row[2], \"$row[3]\"); return false;'> $row[0] as a $row[3] in the $row[2] $row[1].</a><BR>";
            }
            echo "</p>";
        }
        // Same for competitions
        if (! mysql_num_rows($resultComps) == 0){
            echo "<h4>Competitions</h4>";
            // Have to wrap everything in paragraph for style sheet.
            echo "<p>";
            while($row = mysql_fetch_array($resultComps)) {
                $compName = substr($row[0], 4);
                $compYear = substr($row[0], 0, 4);
                $prettyName = addSpace($compName);
                echo "<a onclick='getTableFromSearch(\"$compName\",$compYear,\"tableHere\"); return false;'> The $compYear $prettyName.</a><BR>";
            }
            echo "</p>";
        }
    }
}

//Change the comps to their name with a space
function addSpace($competition){
	if ($competition === 'NationalChampionship') return 'National Championship';
	else if ($competition === 'AmericanOpen') return 'American Open';
	else if ($competition === 'JuniorNationals') return 'Junior Nationals';
	else if ($competition === 'OlympicTrials') return 'Olympic Trials';
	else if ($competition === 'SchoolageNationals') return 'Schoolage Nationals';
	else if ($competition === 'CollegiateNationals') return 'Collegiate Nationals';
}

?>