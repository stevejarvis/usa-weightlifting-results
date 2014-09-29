<?php
include 'dbConnect.php';

//Get the competition we're looking for from the url.
$comp = $_GET['target'];

if($comp != "null"){
    // Sanitize
	$comp = mysql_real_escape_string($comp);

	//Select stuff. Cha ching.
	$query = "select year, name from comps where name = '$comp' order by year desc;";
	$result = mysql_query($query) or die ("Unable to query database.");

	//All the years we have for the selected competition are in result[0]'s.
	if (mysql_num_rows($result) == 0){
		echo "Sorry, we don't have results for that competition.";
	}

	//If there are years, get them and make a list.
	else{
		echo "<div id='yearDropdown'>";
		//Make the yearly selection list.
		?><SELECT onChange="getTable()" name="year" id="year"/><?php
		echo "<OPTION value='null'>Select Year...</OPTION>";
		for ($i=1; $i=mysql_fetch_row($result); $i++) {
			echo "<OPTION value=$i[0]>$i[0]</OPTION>";
		}
		?></SELECT><?php
		echo "</div>";
	}
}
?>