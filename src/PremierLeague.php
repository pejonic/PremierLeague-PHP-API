<?php
namespace Vlowe\PremierLeague;

class PremierLeague {

	/**
	 * JSON API URL
	 */
	const EPL_API = 'http://www.premierleague.com/ajax/site-header.json';

	/**
	 * Team badges, not included in json data so adding manually
	 */
	const BADGES = array(
			'Arsenal'		 => 'http://cdn.ismfg.net/static/plfpl/img/badges/badge_1.png',
			'Aston Villa'	 => 'http://cdn.ismfg.net/static/plfpl/img/badges/badge_2.png',
			'Bournemouth'	 => 'http://cdn.ismfg.net/static/plfpl/img/badges/badge_3.png',
			'Chelsea' 		 => 'http://cdn.ismfg.net/static/plfpl/img/badges/badge_4.png',
			'Crystal Palace' => 'http://cdn.ismfg.net/static/plfpl/img/badges/badge_5.png',
			'Everton'		 => 'http://cdn.ismfg.net/static/plfpl/img/badges/badge_6.png',
			'Leicester'		 => 'http://cdn.ismfg.net/static/plfpl/img/badges/badge_7.png',
			'Liverpool'		 => 'http://cdn.ismfg.net/static/plfpl/img/badges/badge_8.png',
			'Man City'		 => 'http://cdn.ismfg.net/static/plfpl/img/badges/badge_9.png',
			'Man Utd'		 => 'http://cdn.ismfg.net/static/plfpl/img/badges/badge_10.png',
			'Newcastle'		 => 'http://cdn.ismfg.net/static/plfpl/img/badges/badge_11.png',
			'Norwich'		 => 'http://cdn.ismfg.net/static/plfpl/img/badges/badge_12.png',
			'Southampton'	 => 'http://cdn.ismfg.net/static/plfpl/img/badges/badge_13.png',
			'Spurs'			 => 'http://cdn.ismfg.net/static/plfpl/img/badges/badge_14.png',
			'Stoke'			 => 'http://cdn.ismfg.net/static/plfpl/img/badges/badge_15.png',
			'Sunderland'	 => 'http://cdn.ismfg.net/static/plfpl/img/badges/badge_16.png',
			'Swansea'		 => 'http://cdn.ismfg.net/static/plfpl/img/badges/badge_17.png',
			'Watford'		 => 'http://cdn.ismfg.net/static/plfpl/img/badges/badge_18.png',
			'West Brom'		 => 'http://cdn.ismfg.net/static/plfpl/img/badges/badge_19.png',
			'West Ham'		 => 'http://cdn.ismfg.net/static/plfpl/img/badges/badge_20.png'
	);

	/**
	 * Transport instance
	 * @var Transport instance
	 */
	protected $_transport;

	/**
	 * Json data storage
	 * @var assoc array
	 */
	private $_json;

	/**
	 * League standings
	 * @var assoc array
	 */
	private $_standings;


	/**
	 * Constructor - initialize transport instance and get data
	 */
	public function __construct()
	{
		$this->init();
	}

	/**
	 * Initialize transport instance and get data
	 */
	public function init()
	{
		$this->_transport = new Transport();
		$this->_json = json_decode($this->_transport->request(self::EPL_API), true);
	}

	/**
	 * Returns all data as array - public
	 */
	public function getData() {

		return $this->_json;
	}

	/**
	 * Returns current season as string - public
	 */
	public function getSeason() {

		return $this->_json['siteHeaderSection']['currentSeason']['season'];
	}

	/**
	 * Returns array of teams - public
	 */
	public function getTeams() {

		$teams = array();
		foreach ($this->_json['siteHeaderSection']['clubList'] as $team) {
				
			$info = array(
					'id'          => $team['clubId'],
					'name' 		  => $team['clubName'],
					'overridden'  => $team['clubOverriddenName'],
					'sorting' 	  => $team['clubSortingName'],
					'badge'		  => self::BADGES[$team['clubName']],
					'standing'    => $this->getStanding($team['clubName'])['position'],
					'played'      => $this->getStanding($team['clubName'])['gamesPlayed'],
					'points'      => $this->getStanding($team['clubName'])['points']
						
			);
			array_push($teams, $info);
		}
		return $teams;
	}

	/**
	 * Returns team details array - public
	 */
	public function getTeam($name) {
			
		foreach ($this->_json['siteHeaderSection']['clubList'] as $key) {
			if($key['clubName'] == $name) {
				return array(
						'id'          => $key['clubId'],
						'name' 		  => $key['clubName'],
						'overridden'  => $key['clubOverriddenName'],
						'sorting' 	  => $key['clubSortingName'],
						'badge'		  => self::BADGES[$key['clubName']],
						'standing'    => $this->getStanding($key['clubName'])['position'],
						'played'      => $this->getStanding($key['clubName'])['gamesPlayed'],
						'points'      => $this->getStanding($key['clubName'])['points'],
						'error' 	  => 'none'

				);
			}
		}
		// if no team found throw exception
		throw new \Exception('PremierLeague::getTeam() failed to find team: ' . $name . '.');
	}

	/**
	 * Returns match details array - public
	 */
	public function getMatches($team = null) {

		if(empty($team)) {
			// if no team specified, return all matches
			return $this->_json['siteHeaderSection']['matches'];
		}
			
		$matches = array();
		foreach ($this->_json['siteHeaderSection']['matches'] as $match) {
				
			if(($match['homeTeamName'] == $team) || ($match['awayTeamName'] == $team)) {

				// add the team badges, because they are nice to have
				$match['homeTeamBadge'] = self::BADGES[$match['homeTeamName']];
				$match['awayTeamBadge'] = self::BADGES[$match['awayTeamName']];

				array_push($matches, $match);
			}
		}

		if(empty($matches)) {
			throw new \Exception('PremierLeague::getMatches() failed to find matches for team: ' . $team . '.');
		}

		return $matches;
	}

	/**
	 * Returns match next details - public
	 */
	public function getNextMatch($team) {

		if(empty($team)) {
			throw new \Exception('PremierLeague::getNextMatch() a team name was not given.');
		}
			
		foreach ($this->_json['siteHeaderSection']['matches'] as $match) {

			if((($match['homeTeamName'] == $team) || ($match['awayTeamName'] == $team))
					&& ($match['matchState'] == 'PRE_MATCH'))
			{
				// add the team badges, because they are nice to have
				$match['homeTeamBadge'] = self::BADGES[$match['homeTeamName']];
				$match['awayTeamBadge'] = self::BADGES[$match['awayTeamName']];

				return $match;
			}
		}

		throw new \Exception('PremierLeague::getNextMatch() failed to find matches for team: ' . $team . '.');
	}

	/**
	 * Returns current league standings - public
	 * The JSON api does not provide this data, instead we will scrape it from the premier league home page
	 */
	public function getStandings() {

		$url = parse_url(self::EPL_API);
		$html = (new Transport())->request($url['scheme']."://".$url['host']);

		// scrape the league table from the home page
		$html = $this->scrapeBetween($html, '<table cellspacing="0" cellpadding="0" class="leagueTable">', '</table>');

		$dom = new \DOMDocument;
		$dom->loadHTML($html);

		$rows = $dom->getElementsByTagName('tr');

		$standings = array();
		foreach ($rows as $row) {
				
			$standing = array();
			$columns = $row->getElementsByTagName('td');
			foreach ($columns as $column) {

				$standing[] = $column->nodeValue;
			}
				
			if(!empty($standing)) {
				// tidy array keys up with nice names
				$standing['position'] 	  = $standing[0]; 		unset($standing[0]);
				$standing['teamName'] 	  = trim($standing[1]); unset($standing[1]);
				$standing['gamesPlayed']  = $standing[2]; 		unset($standing[2]);
				$standing['points']   	  = $standing[3]; 		unset($standing[3]);

				array_push($standings, $standing);
			}
		}
		$this->_standings = $standings;

		return $standings;

	}

	/**
	 * Returns current league standing for team - public
	 */
	public function getStanding($team) {

		if(empty($this->_standings)) {
			$this->getStandings();
		}
			
		foreach ($this->_standings as $standing) {
				
			if($standing['teamName'] == $team) {

				return $standing;
			}
		}

		throw new \Exception('PremierLeague::getStanding() failed to find standing for team: ' . $team . '.');
	}

	/**
	 * Scrape html data between two entitys - private
	 */
	private function scrapeBetween($data, $start, $end) {

		$data = stristr($data, $start);
		$data = substr($data, strlen($start));
		$stop = stripos($data, $end);
		$data = substr($data, 0, $stop);

		return $data;
	}

}