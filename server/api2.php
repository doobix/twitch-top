<?php
require('config.php');

/*
The output of this file looks like this:

top: [
  {
    date: "2015-02-09 13:44:53",
    League of Legends: 131716,
    Minecraft: 81695,
    Counter-Strike: Global Offensive: 65849,
    H1Z1: 58279,
    Hearthstone: Heroes of Warcraft: 46070,
    ArmA III: 35689,
    Dota 2: 34983,
    Quake Live: 20758,
    World of Warcraft: Warlords of Draenor: 17419,
    FIFA 15: 17078
  },
  ...
],
games: [
  "League of Legends",
  "Minecraft",
  "Counter-Strike: Global Offensive",
  "H1Z1",
  "Hearthstone: Heroes of Warcraft",
  "ArmA III",
  "Dota 2",
  "Quake Live",
  "World of Warcraft: Warlords of Draenor",
  "FIFA 15",
  ...
]
*/

// Database
// define('DB_HOST', '');
// define('DB_USER', '');
// define('DB_PASS', '');
// define('DB_NAME', '');

// Create connection
$link = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if (!$link) {
  die("Connection failed: " . mysqli_connect_error());
}

// Change header to JSON content-type
header('Content-Type: application/json');
// Allow specific domains to access
header('Access-Control-Allow-Origin: http://seewes.com');
header('Access-Control-Allow-Origin: http://www.seewes.com');

// Check if game exists
$sql = "SELECT a.time, a.viewers, b.name FROM `twitch_topgames` as a JOIN `twitch_games` as b on a.twitch_id = b.twitch_id ORDER by a.time DESC, a.viewers DESC LIMIT 160";
$result = mysqli_query($link, $sql) or die(mysqli_error($link));
$num_rows = mysqli_num_rows($result);
$json = "";
$currentDate = "";
$openBracket = false;
$gamesArray = array();

$json .= "{";

// Top games with time and viewers
$json .= "\"top\": [";
if ($num_rows > 0) {
  while($row = mysqli_fetch_assoc($result)) {
    if ($currentDate != $row['time']) {
      if ($openBracket) {
        $json = substr($json, 0, -1);
        $json .= "},";
        $openBracket = false;
      }

      $currentDate = $row['time'];

      $json .= "{";
      $openBracket = true;
      $json .= "\"date\": \"" . $row['time'] . "\",";
      $json .= "\"" . $row['name'] . "\": " . $row['viewers'] . ",";
    } else {
      $json .= "\"" . $row['name'] . "\": " . $row['viewers'] . ",";
    }

    if (!$gamesArray[$row['name']]) {
      $gamesArray[$row['name']] = 1;
    } else {
      $gamesArray[$row['name']]++;
    }
  }
}
$json = substr($json, 0, -1);
$json .= "}";
$json .= "],";

// List of games
$json .= "\"games\": [";
foreach($gamesArray as $game => $num) {
  $json .= "\"" . $game . "\",";
}
$json = substr($json, 0, -1);
$json .= "]";

$json .= "}"; // end JSON

echo $json;

// Close connection
mysqli_close($link);
?>
