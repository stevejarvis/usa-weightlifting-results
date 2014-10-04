<?php
include 'dbconnect.php';

//Get vars from URL.
$comp = mysql_real_escape_string($_GET['comp']);
$year = mysql_real_escape_string($_GET['year']);

//Select all results for competition.
$query = mysql_real_escape_string("select * from $year$comp;");
$result = mysql_query($query) or die ("Unable to fetch results.");
	
//Array of all the chars we want to not show up in the results.
//Butch put extra odd record markers in there we're getting rid of.
//Still mark records, but only with a simple * following.
$needles = array("!","@","#","%","^","&","*");

//Title..
$readable = addSpace($comp);
?><div id="title"><h2> <?php echo "<B>$year $readable</B><BR>";?></h2></div><?php
	echo "<h3>WOMEN</h3>";
//Now echo in a nice table.
echo "<TABLE>";
//Print one row for a header.
echo "<SPAN id=\"header\"><TR><TD><h4>Class</h4></TD><TD><h4>Name</h4></TD><TD><h4>Birth</h4></TD><TD><h4>Team</h4></TD><TD><h4>Bodyweight</h4></TD>";
echo "<TD><h4>Snatch 1</h4></TD><TD><h4>Snatch 2</h4></TD><TD><h4>Snatch 3</h4></TD><TD><h4>Jerk 1</h4></TD>";
echo "<TD><h4>Jerk 2</h4></TD><TD><h4>Jerk 3</h4></TD><TD><h4>Total</h4></TD><TD><h4>Place</h4></TD></TR></SPAN>";
//This loop prints each row.
$ct=1;
$boys = false;
for ($i=1; $i=mysql_fetch_row($result); $i++) {
    //Break for each class.
    if($i[12] == '1' and $ct>1 and $i[0] != '56')
        insertBlankRow();
    //Big break for sex.
    if(($i[0] == '56' and $boys == false) or ($i[0] == '62' and $boys == false)){
        $ct = insertBoys();
        $boys = true;
    }
    if ($ct%2 == 0) echo ("<TR class=\"trtwo\">");
    else echo ("<TR class=\"trone\">");
    $ct++;
    //Inside loop prints each column.
    for ($n=0; $n<13; $n++) {
        echo "<TD>";
        $colCT++; 
			
        //If we're between 5 an 10 check for weird chars.
        //They will only occur as the 4th char in the string (e.g. 100&)
        if($n>4 and $n<11){
            //Mark whether we've broken out of loop
            $has_printed = false;
            foreach($needles as $bad_char){
                //As soon any weird string shows up we know they're there. Break.
                if(strpos($i[$n], $bad_char) > 0){
                    echo str_replace($needles, "", $i[$n])."<span style=\"color:red\">*</span>";
                    $has_printed = true;
                    break;
                }
            }
            if(!$has_printed){
                echo $i[$n];
            }
        }else{
            echo $i[$n];
        }
        echo "</TD>";
    }
    echo "</TR>";
}
echo "</TABLE>";
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

//Break into a new table for men
function insertBoys(){
	echo "</TABLE><BR>&nbsp<BR>";
	echo "<h3>MEN</h3>";
	echo "<TABLE width=100% >";
	//Print one row for a header.
	echo "<SPAN id=\"header\"><TR><TD><h4>Class</h4></TD><TD><h4>Name</h4></TD><TD><h4>Birth</h4></TD><TD><h4>Team</h4></TD><TD><h4>Bodyweight</h4></TD>";
	echo "<TD><h4>Snatch 1</h4></TD><TD><h4>Snatch 2</h4></TD><TD><h4>Snatch 3</h4></TD><TD><h4>Jerk 1</h4></TD>";
	echo "<TD><h4>Jerk 2</h4></TD><TD><h4>Jerk 3</h4></TD><TD><h4>Total</h4></TD><TD><h4>Place</h4></TD></TR></SPAN>";
	
	//Reset ct so table row colors sync
	return 1;
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

//Put each class in a div so we can click and go to it. Pass the class.
function insertDiv($class){
	echo "</DIV>";
	echo "<DIV id=\"$class\">";
}
?>
