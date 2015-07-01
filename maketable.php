<?php

    header('Access-Control-Allow-Origin: http://www.nerdster.org');  

    include 'utils.php';

    $dbLocation = 'usaw_results.sqlite';

    $db = new SQLite3( $dbLocation );
    if( !$db ) 
    {
        echo $db->lastErrorMsg();
    }

    // Get vars from URL.
    $comp = $_GET['comp'];
    $year = $_GET['year'];

    // Select all results for competition.
    $queryStr = SQLite3::escapeString( "SELECT * FROM \"$year$comp\";" );
    $results = $db->query( $queryStr ) or die ( $db->lastErrorMsg() );
        
    // Array of all the chars we want to not show up in the results.
    // Butch put extra odd record markers in there we're getting rid of.
    // Still mark records, but only with a simple * following.
    $needles = array("!","@","#","%","^","&","*","~","+");

    //Title..
    $readable = prettyPrint($comp);

    echo "<div id=\"title\"><h2> <?php echo \"<B>$year $readable</B><BR> </h2></div>";

    // Inserts a header for starting a fresh table.
    $ct = insertBeginTable();
    echo "<h3>WOMEN</h3>";
    insertGenericHeader();

    // This loop prints each row.
    $boys = false;
    while( $row = $results->fetchArray() ) {
        //Break for each class.
        if($row[12] == '1' and $ct>1 and $row[0] != '56') 
            insertBlankRow();
        // Big break for sex. It's unsure on which class we'll start, but (hopefully)
        // it'll be one of either 56 or 62.
        if(($row[0] == '56' or $row[0] == '62') and $boys == false){
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
                $startStr = str_replace($needles, "<span>*</span>", $row[$n]);
                echo $startStr;
            }else{
                echo $row[$n];
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
?>
