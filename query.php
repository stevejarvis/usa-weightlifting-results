<?php

    header('Access-Control-Allow-Origin: http://www.nerdster.org');  

    include 'utils.php';

    //Get the competition we're looking for from the url.
    $key = $_GET['key'];

    $dbLocation = 'usaw_results.sqlite';

    $db = new SQLite3( $dbLocation );
    if( !$db ) 
    {
        echo $db->lastErrorMsg();
    }

    if( strlen($key) > 0 ){

        // Select stuff. Cha ching. First look for athletes by the key.
        $athleteQueryStr = SQLite3::escapeString( 
            "SELECT name, comp, year, class, title " .
            "FROM athletes " .
            "WHERE name LIKE \"%$key%\" " .
            "ORDER BY year DESC;" );
        $resultAthletes = $db->query( $athleteQueryStr ) or die ( $db->lastErrorMsg() );

        // Try to find competitions by the key too. Search table names directly.
        $keynospace = preg_replace('/\s+/', '', $key);
        $tableQueryStr = SQLite3::escapeString( 
            "SELECT name " .
            "FROM sqlite_master " .
            "WHERE type=\"table\" " .
            "AND name LIKE \"%$keynospace%\" " .
            "ORDER BY name DESC;" );
        $resultComps = $db->query( $tableQueryStr ) or die ( $db->lastErrorMsg() );

        // If there are results, get them and make a list. First athletes.
        $athletesFound = false;
        echo "<h4>Athletes</h4>";
        // Have to wrap everything in paragraph for style sheet.
        echo "<p>";
        while( $row = $resultAthletes->fetchArray() ) {
            echo "<a onclick='getTableFromSearch(\"$row[4]\",$row[2], \"$row[3]\"); return false;'> $row[0] as a $row[3] in the $row[2] $row[1].</a><BR>";
            $athletesFound = true;
        }
        if( ! $athletesFound )
            echo "No athletes found like '" . $key . "'.";

        echo "</p>";
        
        // Same for competitions
        $compsFound = false;
        echo "<h4>Competitions</h4>";
        // Have to wrap everything in paragraph for style sheet.
        echo "<p>";
        while( $row = $resultComps->fetchArray() ) {
            $compName = substr($row[0], 4);
            $compYear = substr($row[0], 0, 4);
            $prettyName = prettyPrint($compName);
            echo "<a onclick='getTableFromSearch(\"$compName\",$compYear,\"tableHere\"); return false;'> The $compYear $prettyName.</a><BR>";
            $compsFound = true;
        }
        if( ! $compsFound )
            echo "No competitions found like '" . $key . "'.";

        echo "</p>";
    }

?>
