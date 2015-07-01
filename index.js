var httpObject = null;
var getBaseUrl = 'http://cs-people.bu.edu/sajarvis/usaw-results/';

// Get the HTTP Object.
function getHTTPObject(){
	if (window.XMLHttpRequest){
		//Make sure the object is currently null.
	    return new XMLHttpRequest();
	}
	else if (window.ActiveXObject) {
		return new ActiveXObject("Microsoft.XMLHTTP");
	}
	else {
	    alert("Your browser does not support AJAX.");
	    return null;
	}
}

// Reset the page's text to an overview message.'
function resetText(){
    document.getElementById('status').innerHTML = "";
    document.getElementById('tableHere').innerHTML =
        '<h3>What\'s this?</h3>' +
        '<p>Search above to look through a relatively complete database of US national events ' +
        'since the beginning of time (or at least since the modern weight classes were in effect) ' +
        'If you have a fix or addition to the results, <a href="mailto:steve.a.jarvis@gmail.com">email me</a> ' +
        'or file an issue on <a href="https://github.com/stevejarvis/usa-weightlifting-results">Github</a>.' +
        '<br><br>\'*\' denotes record attempt, \'x\' denotes missed attempt.' +
        '<br><br>Last updated <time datetime="2014-10-05">October 05, 2014</time>.' +
        '<br><br>Huge thanks to <a href="http://www.lifttilyadie.com/w8lift.htm">OWOW and Butch Curry</a> ' +
        'for organizing most of the results.</p>';
}

// Make the results table in the table div. If we have a faster typist than
// internet, it's possible the response will get back late, when the field
// has been deleted. If that's the case, still want to reset text, not display
// results.
function setTable(){
    if( document.getElementById('searchField').value != "") {
	    if(httpObject.readyState == 4){
            document.getElementById('tableHere').innerHTML = httpObject.responseText +
                '<br>\'*\' denotes record attempt<br>\'x\' denotes missed attempt';
		    httpObject = null;
        }
    }
    else {
        resetText();
    }
}

// Show what the heck we're doing. Set status field text. Holds both "searching"
// text and list of options.
function setOptions(){
    if( document.getElementById('searchField').value != "") {
	    if(httpObject.readyState == 4){
            document.getElementById('status').innerHTML = httpObject.responseText;
        }
    }
    else {
        resetText();
    }
}

// Query based on the search box.
function dbquery(){
	// Clear the comps and table when they start typing. Say we're lookin..
    if( document.getElementById('searchField').value != "") {
	    document.getElementById('status').innerHTML = "Searching...";
	    httpObject = getHTTPObject();
        if (httpObject != null) {
    	    httpObject.open("GET",
                            getBaseUrl.concat("query.php/?key="+document.getElementById('searchField').value),
                            true);
		    httpObject.send(null);
            httpObject.onreadystatechange = setOptions;
        }
    }
    else {
        resetText();
    }

	return false;
}

// Request the table from the search box
function getTableFromSearch(comp, year, div){
    if( document.getElementById('searchField').value != "") {
	    document.getElementById('tableHere').innerHTML = "Loading Table...";
	    httpObject = getHTTPObject();
	    if (httpObject != null) {
	        httpObject.open("GET",
                            getBaseUrl.concat("maketable.php/?comp="+comp+"&year="+year),
                            true);
	        httpObject.send(null);
	        httpObject.onreadystatechange = setTable;
            document.getElementById('tableHere').scrollIntoView(true);
	    }
    }
    else {
        resetText();
    }

    return false;
}

// Start with set text
window.onload = function() {
    resetText();
};
