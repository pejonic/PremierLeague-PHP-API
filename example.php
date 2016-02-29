<?php
/** utilise composor to autoload dependancies **/
require 'vendor/autoload.php';

use Vlowe\PremierLeague\PremierLeague;

try {
	
	$epl = new PremierLeague();
	
	// returns raw data
	//$data = $epl->getData();
	
	// returns current season: "2015-2016"
	//$data = $epl->getSeason();
	
	// returns all team details
	$data = $epl->getTeams();
	
	// returns single team details
	//$data = $epl->getTeam('Liverpool');
	
	// returns all matches raw data
	//$data = $epl->getMatches();
	
	// returns all matches for team, inc club badges
	//$data = $epl->getMatches('Liverpool');
	
	// returns teams next match details
	//$data = $epl->getNextMatch('Liverpool');
	
	// returns all current standing details
	//$data = $epl->getStandings();
	
	// returns teams current standing details
	//$data = $epl->getStanding('Liverpool');

	var_dump($data);
	
} catch (Exception $e) {
	
	die('Fatal error: ' . $e->getMessage());
}