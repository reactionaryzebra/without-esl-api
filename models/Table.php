<?php
include_once '../models/Team.php';

class Table{
  private $conn;
  private $table_name = "results";

  public $season;
  public $excluded_teams;
  public $teams = [];

  public function __construct($db, $season, $excluded_teams) {
    $this->season = $season;
    $this->excluded_teams = $excluded_teams;
    $this->conn = $db;
  }

  private function getResults() {
    $results = pg_query($this->conn, "select * from $this->table_name where season = $this->season");
    return pg_fetch_all($results);
  }

  private function getTeams($results) {
    $all_teams = array();
    foreach ($results as $result) {
      $team = $result['home_team'];
      if (!in_array($team, $this->excluded_teams)){
        $all_teams[$team] = new Team($team);
      }
    }
    return $all_teams;
  }

  private function recordResults($results) {
    foreach ($results as $result) {
      $home_team = $result['home_team'];
      $away_team = $result['away_team'];

      if ($result['outcome'] === "H") {
        $this->teams[$result['home_team']]->addResult('win');
        $this->teams[$result['away_team']]->addResult('loss');
      } else if ($result['outcome'] === "A") {
        $this->teams[$result['home_team']]->addResult('loss');
        $this->teams[$result['away_team']]->addResult('win');
      } else {
        $this->teams[$result['home_team']]->addResult('draw');
        $this->teams[$result['away_team']]->addResult('draw');
      }
    }
  }

  public function build() {
    $results = $this->getResults();
    $this->teams = $this->getTeams($results);
    $this->recordResults($results);
  }

  public function getSortedTable() {
    if (count($this->teams) < 1) return "Table must be built first";
    $teams = array_values($this->teams);
    function sortByPoints($a, $b) {
      return $b->points - $a->points;
    }
    uasort($teams, "sortByPoints");
    echo "<pre>"; print_r($teams);
    return $teams;
  }
}
?>
