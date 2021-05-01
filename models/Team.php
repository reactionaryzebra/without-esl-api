<?php
class Team{

  public $name;
  public $wins;
  public $losses;
  public $draws;
  public $points;

  public function __construct($name) {
    $this->name = $name;
  }

  public function addResult($outcome) {
    switch ($outcome) {
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
}
 ?>
