<?php
include 'dbConnect.php';

//Get the competition we're looking for from the url.
$name = $_GET['name'];

if(strlen($name) > 0){
    // Sanitize
	$name = mysql_real_escape_string($name);

	// Select stuff. Cha ching.
	$query =
        "SELECT name, comp, year, class, title " .
        "FROM athletes " .
        "WHERE name LIKE '%$name%'" .
        "order by year desc;";
	$result = mysql_query($query) or die ("Unable to query database.");

	//All the comps we have for the selected competition are in result[i]'s.
	if (mysql_num_rows($result) == 0){
		echo "Sorry, we don't have results for that person.";
	}

	//If there are results, get them and make a list.
	else{
		while($row = mysql_fetch_array($result)) {
			echo "<a onclick='getTableFromSearch(\"$row[4]\",$row[2], \"$row[3]\"); return false;'> $row[0] as a $row[3] in the $row[2] $row[1].</a><BR>";
		}
	}
}
?>