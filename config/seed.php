<?php
include_once '../config/Database.php';
include_once '../models/result.php';

$database = new Database();
$db = $database->getConnection();

// $create_table_query = "CREATE TABLE IF NOT EXISTS results (
//   id serial NOT NULL PRIMARY KEY,
//   season int NOT NULL,
//   home_team varchar NOT NULL,
//   away_team varchar NOT NULL,
//   home_team_goals int NOT NULL,
//   away_team_goals int NOT NULL,
//   outcome varchar(1) NOT NULL
// );";
// $table = pg_query($db, $create_table_query);

$data_1011 = file_get_contents('../data/season-1011_json.json');
$results_1011 = json_decode($data_1011, true);

foreach ($results_1011 as $_result) {
  $result = new Result($db);
  $result->season = "1011";
  $result->home_team = $_result['HomeTeam'];
  $result->away_team = $_result['AwayTeam'];
  $result->home_team_goals = $_result['FTHG'];
  $result->away_team_goals = $_result['FTAG'];
  $result->outcome = $_result['FTR'];
  $success = $result->create();
}
 ?>
