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
  
  // add more test cases
}