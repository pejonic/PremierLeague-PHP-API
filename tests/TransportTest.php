<?php
 
use Vlowe\PremierLeague\Transport;
 
class TransportTest extends PHPUnit_Framework_TestCase {
 
  public function testTransport()
  {
    $cURL = new Transport();
    $payload = $cURL->request('http://www.premierleague.com/');

 	$this->assertGreaterThan(0, strlen($payload));
  }
 

}