<?php
include 'dbconnect.php';

// Get vars from URL.
$comp = mysql_real_escape_string($_GET['comp']);
$year = mysql_real_escape_string($_GET['year']);

// Select all results for competition.
$query = mysql_real_escape_string("select * from $year$comp;");
$result = mysql_query($query) or die ("Unable to fetch results.");
	
// Array of all the chars we want to not show up in the results.
// Butch put extra odd record markers in there we're getting rid of.
// Still mark records, but only with a simple * following.
$needles = array("!","@","#","%","^","&","*","~","+");

//Title..
$readable = addSpace($comp);
?>
<div id="title"><h2> <?php echo "<B>$year $readable</B><BR>";?> </h2></div>
<?php
// Inserts a header for starting a fresh table.
$ct = insertBeginTable();
echo "<h3>WOMEN</h3>";
insertGenericHeader();
// This loop prints each row.
$boys = false;
for ($i=1; $i=mysql_fetch_row($result); $i++) {
    //Break for each class.
    if($i[12] == '1' and $ct>1 and $i[0] != '56') 
        insertBlankRow();
    // Big break for sex. It's unsure on which class we'll start, but (hopefully)
    // it'll be one of either 56 or 62.
    if(($i[0] == '56' or $i[0] == '62') and $boys == false){
        $ct = insertBreakTable();
        echo "<h3>MEN</h3>";
        insertGenericHeader();
        $boys = true;
    }
    // Classes can be used to set alternating colors for rows in css.
    if ($ct%2 == 0) echo ("<TR class=\"trtwo\">");
    else echo ("<TR class=\"trone\">");
    $ct++;
    // Inside loop prints each column.
    for ($n=0; $n<13; $n++) {
        echo "<TD>";
        $colCT++; 
			
        // If we're between columns 5 an 10 check for weird chars.
        if($n>4 and $n<11){
            // Replace anything in "needles" with nothing and follow the entry with a "*".
            $startStr = str_replace($needles, "<span>*</span>", $i[$n]);
            echo $startStr;
        }else{
            echo $i[$n];
        }
        echo "</TD>";
    }
    echo "</TR>";
}
insertEndTable();
insertBlankRow();

//Blank row between all classes
function insertBlankRow(){
	//Blank row here
	echo "<TR>";
	for($i=0; $i<13; $i++)
        // Not sure I needed to do this...
		echo "<TD>&nbsp</TD>";
	echo "</TR>";
}

// Start of top table
function insertBeginTable(){
	echo "<TABLE width=100% >";
	//Reset ct so table row colors sync
	return 1;
}

//Break into a new table for men
function insertBreakTable(){
	echo "</TABLE><BR>&nbsp<BR>";
	echo "<TABLE width=100% >";
	// Reset ct so table row colors sync
	return 1;
}

// Insert the generic header for table.
function insertGenericHeader(){
	// Print one row for a header.
	echo "<SPAN id=\"header\"><TR><TD><h4>Class</h4></TD><TD><h4>Name</h4></TD><TD><h4>Birth</h4></TD><TD><h4>Team</h4></TD><TD><h4>Bodyweight</h4></TD>";
	echo "<TD><h4>Snatch 1</h4></TD><TD><h4>Snatch 2</h4></TD><TD><h4>Snatch 3</h4></TD><TD><h4>Jerk 1</h4></TD>";
	echo "<TD><h4>Jerk 2</h4></TD><TD><h4>Jerk 3</h4></TD><TD><h4>Total</h4></TD><TD><h4>Place</h4></TD></TR></SPAN>";
}

function insertEndTable() {
    echo "</TABLE>";
}

// Change the comps to their name with a space
function addSpace($competition){
	if ($competition === 'NationalChampionship') return 'National Championship';
	else if ($competition === 'AmericanOpen') return 'American Open';
	else if ($competition === 'JuniorNationals') return 'Junior Nationals';
	else if ($competition === 'OlympicTrials') return 'Olympic Trials';
	else if ($competition === 'SchoolageNationals') return 'Schoolage Nationals';
	else if ($competition === 'CollegiateNationals') return 'Collegiate Nationals';
}
?>
