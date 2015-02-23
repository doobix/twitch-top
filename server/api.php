<?php
require('config.php');

/*
The output of this file looks like this:

top: [
  {
    name: "League of Legends",
    time: "2015-02-09 13:44:53",
    viewers: "131716"
  },
  {
    name: "Minecraft",
    time: "2015-02-09 13:44:53",
    viewers: "81695"
  },
  {
    name: "Counter-Strike: Global Offensive",
    time: "2015-02-09 13:44:53",
    viewers: "65849"
  },
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
$sql = "SELECT a.time, a.viewers, b.name FROM `twitch_topgames` as a JOIN `twitch_games` as b on a.twitch_id = b.twitch_id ORDER by a.time DESC, a.viewers DESC LIMIT 960";
$result = mysqli_query($link, $sql) or die(mysqli_error($link));
$num_rows = mysqli_num_rows($result);
$counter = 0;
$json = "";

$json .= "{";
$json .= "\"top\": [";
if ($num_rows > 0) {
  while($row = mysqli_fetch_assoc($result)) {
    $counter++;
    $json .= "{";
    $json .= "\"name\": \"" . $row['name'] . "\",";
    $json .= "\"time\": \"" . $row['time'] . "\",";
    $json .= "\"viewers\": \"" . $row['viewers'] . "\"";
    $json .= "}";
    $json .= ",";
  }
}
$json = substr($json, 0, -1);
$json .= "]";
$json .= "}";

echo $json;

// Close connection
mysqli_close($link);
?>