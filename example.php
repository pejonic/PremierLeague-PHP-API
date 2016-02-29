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
} catch (Exception $e) {
	
	die('Fatal error: ' . $e->getMessage());
}
?>
<!doctype html>
<html lang="en">
	<head>
		<title>PHP Premier League</title>
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" integrity="sha256-7s5uDGW3AHqw6xtJmNNtr+OBRJUlgkNJEo78P4b0yRw= sha512-nNo+yCHEyn0smMxSswnf/OnX6/KwJuZTlNZBjauKhTK0c+zT+q5JOCx0UFhXQ6rJR9jg6Es8gPuD2uZcYDLqSw==" crossorigin="anonymous">
	</head>
	<body>
	    <nav class="navbar">
	      <div class="container">
	        <div class="navbar-header">
	          <a class="navbar-brand" href="#">PHP Premier League Example</a>
	        </div>
	      </div>
	    </nav>
		<div class="container">
			<div class="row">
				<div class="col-md-7">
					<h3>Standings</h3>
					<table class="table table-hover col-md-4">
				        <tr>
				        	<th>POS</th>
				        	<th></th>
				            <th>Team</th>
				            <th>Played</th>
				            <th>Points</th>
				            <th>Next game</th>
				        </tr>
					        <?php foreach($data as $team) { ?>
					        <tr>
						        <td><?php echo $team['standing'] ?></td>
					        	<td><img src='<?php echo $team['badge'] ?>' height='20px'/></td>
					            <td><?php echo $team['name'] ?></td>
					            <td><?php echo $team['played'] ?></td>
					            <td><?php echo $team['points'] ?></td>
					            <td>
					            	<img src='<?php echo $epl->getNextMatch($team['name'])['homeTeamBadge']; ?>' height='20px'/>
					            	 vs 
					            	<img src='<?php echo $epl->getNextMatch($team['name'])['awayTeamBadge']; ?>' height='20px'/> 
					            </td>
					        </tr>
							<?php } ?>
					</table>
				</div>
			</div>
		</div>
	</body>
</html>