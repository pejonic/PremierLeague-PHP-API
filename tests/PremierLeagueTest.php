<?php
 
use Vlowe\PremierLeague\PremierLeague;
 
class PremierLeagueTest extends PHPUnit_Framework_TestCase {
 
  public function testGetSeason()
  {
    $epl = new PremierLeague();
    $this->assertEquals('2015-2016', $epl->getSeason());
  }
 
  public function testGetTeams()
  {
  	$epl = new PremierLeague();
  	$returnArray = $epl->getTeams();
  	
  	foreach ($returnArray as $array) {
  		
  		$this->assertArrayHasKey('id', $array);
  		$this->assertArrayHasKey('name', $array);
  		$this->assertArrayHasKey('overridden', $array);
  		$this->assertArrayHasKey('sorting', $array);
  		$this->assertArrayHasKey('badge', $array);
  		$this->assertArrayHasKey('standing', $array);
  		$this->assertArrayHasKey('played', $array);
  		$this->assertArrayHasKey('points', $array);
  	}
  }  
  
  public function testGetTeam()
  {
  	$epl = new PremierLeague();
  	$returnArray = $epl->getTeam('Liverpool');
  
  	$this->assertArrayHasKey('id', $returnArray);
  	$this->assertArrayHasKey('name', $returnArray);
  	$this->assertArrayHasKey('overridden', $returnArray);
  	$this->assertArrayHasKey('sorting', $returnArray);
  	$this->assertArrayHasKey('badge', $returnArray);
  	$this->assertArrayHasKey('standing', $returnArray);
  	$this->assertArrayHasKey('played', $returnArray);
  	$this->assertArrayHasKey('points', $returnArray);
  }
  
 public function testGetMatches()
  {
    $epl = new PremierLeague();
    $returnArray = $epl->getMatches();

    // this is raw data from JSON api
    foreach ($returnArray as $array) {
      
      $this->assertArrayHasKey('matchState', $array);
      $this->assertArrayHasKey('timestamp', $array);
      $this->assertArrayHasKey('score', $array);
      $this->assertArrayHasKey('venue', $array);
      $this->assertArrayHasKey('matchCmsAliasData', $array);
      $this->assertArrayHasKey('minutesIntoMatch', $array);
    }

    $returnArray = $epl->getMatches('Liverpool');
    foreach ($returnArray as $array) {
      
      $this->assertArrayHasKey('matchState', $array);
      $this->assertArrayHasKey('timestamp', $array);
      $this->assertArrayHasKey('score', $array);
      $this->assertArrayHasKey('venue', $array);
      $this->assertArrayHasKey('matchCmsAliasData', $array);
      $this->assertArrayHasKey('minutesIntoMatch', $array);
      // manually added badge urls
      $this->assertArrayHasKey('homeTeamBadge', $array);
      $this->assertArrayHasKey('awayTeamBadge', $array);
    }
  }

 public function testGetNextMatch()
  {
    $epl = new PremierLeague();
    $returnArray = $epl->getNextMatch('Liverpool');

    $this->assertArrayHasKey('matchState', $returnArray);
    $this->assertArrayHasKey('timestamp', $returnArray);
    $this->assertArrayHasKey('score', $returnArray);
    $this->assertArrayHasKey('venue', $returnArray);
    $this->assertArrayHasKey('matchCmsAliasData', $returnArray);
    $this->assertArrayHasKey('minutesIntoMatch', $returnArray);
    // manually added badge urls
    $this->assertArrayHasKey('homeTeamBadge', $returnArray);
    $this->assertArrayHasKey('awayTeamBadge', $returnArray);
  }

 public function testGetStandings()
  {
    $epl = new PremierLeague();
    $returnArray = $epl->getStandings();

    foreach ($returnArray as $array) {
      
      $this->assertArrayHasKey('position', $array);
      $this->assertArrayHasKey('teamName', $array);
      $this->assertArrayHasKey('gamesPlayed', $array);
      $this->assertArrayHasKey('points', $array);
    }
  }

 public function testGetTeamStanding()
  {
    $epl = new PremierLeague();
    $returnArray = $epl->getStanding('Liverpool');

    $this->assertArrayHasKey('position', $returnArray);
    $this->assertArrayHasKey('teamName', $returnArray);
    $this->assertArrayHasKey('gamesPlayed', $returnArray);
    $this->assertArrayHasKey('points', $returnArray);
  }

}