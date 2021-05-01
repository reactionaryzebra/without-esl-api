<?php
class Team{

  public $name;
  public $wins;
  public $losses;
  public $draws;
  public $points;
  public $goals_scored;
  public $goals_against;

  public function __construct($name) {
    $this->name = $name;
  }

  public function addResult($result) {
    $is_home_team = $result['home_team'] === $this->name;
    if ($is_home_team) {
      $this->goals_scored = $this->goals_scored + $result['home_team_goals'];
      $this->goals_against = $this->goals_against + $result['away_team_goals'];
    } else {
      $this->goals_scored = $this->goals_scored + $result['away_team_goals'];
      $this->goals_against = $this->goals_against + $result['home_team_goals'];
    }
    $resolved_outcome = '';
    if ($result['outcome'] === "D") {
      $resolved_outcome = 'draw';
    } else if (($is_home_team && $result['outcome'] === "H") || (!$is_home_team && $result['outcome'] === "A")) {
      $resolved_outcome = "win";
    }
    else {
      $resolved_outcome = 'loss';
    }

    switch ($resolved_outcome) {
      case 'win':
        $this->wins = $this->wins + 1;
        $this->points = $this->points + 3;
        break;
      case 'loss':
        $this->losses = $this->losses + 1;
        break;
      case 'draw':
        $this->draws = $this->draws + 1;
        $this->points = $this->points + 1;
        break;
      default:
        break;
    }
  }

  public function getGoalDifference() {
    return $this->goals_scored - $this->goals_against;
  }

}
 ?>
