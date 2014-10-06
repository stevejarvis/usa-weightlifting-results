<?php
// Change the comps to their name with a space
function prettyPrint($competition){
	if ($competition === 'NationalChampionship') return 'National Championship';
	else if ($competition === 'AmericanOpen') return 'American Open';
	else if ($competition === 'JuniorNationals') return 'Junior Nationals';
	else if ($competition === 'OlympicTrials') return 'Olympic Trials';
	else if ($competition === 'SchoolageNationals') return 'Schoolage Nationals';
	else if ($competition === 'CollegiateNationals') return 'Collegiate Nationals';
	else if ($competition === 'UniversityNationals') return 'University Nationals';
}
?>