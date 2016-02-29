# PHP Premier League API

## Introduction

This is a PHP package for extracting data from http://www.premierleague.com/

You can get team, match and league standings data to be used in your own application.


## Usage

* get all data received from JSON api

        getData()
        
* get current season: returns "2015-2016"

        getSeason()    
        
* get all team details, including badge and standing details

        getTeams()   
        
* get the team details for the specified team, including badge and standing details

        getTeam('Liverpool')  
        
* get all matches raw data

        getMatches()
       
* get matches data for the specified team, including badges for home and away teams

        getMatches('Liverpool')
        
* get teams next match details, including badges for home and away teams

        getNextMatch('Liverpool')
        
* get the current league standings

        getStandings()
        
* get the current league standings for the specified team

        getStanding('Liverpool')


## Example

![Example usage](https://raw.githubusercontent.com/vlowe85/PremierLeague-PHP-API/master/example.png)

An example of the usage is [provided in this repository](example.php).