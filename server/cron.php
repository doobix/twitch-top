<?php
require('config.php');

// Database
// define('DB_HOST', '');
// define('DB_USER', '');
// define('DB_PASS', '');
// define('DB_NAME', '');

// Twitch Client ID
// define('TWITCH_CLIENT_ID', '')

// Create connection
$link = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if (!$link) {
  die("Connection failed: " . mysqli_connect_error());
}

// Get Twitch Data
$twitch = json_decode(get_url_contents("https://api.twitch.tv/kraken/games/top?limit=10&client_id=" . TWITCH_CLIENT_ID));
for ($i = 0; $i < sizeof($twitch->top); $i++) {
  // Sanitize input
  $twitchID = clean($twitch->top[$i]->game->_id, $link);
  $viewers = clean($twitch->top[$i]->viewers, $link);

  // Check if game exists
  $sql = "SELECT * FROM `twitch_games` WHERE `twitch_id` = '$twitchID'";
  $result = mysqli_query($link, $sql) or die(mysqli_error($link));
  $num_rows = mysqli_num_rows($result);
  if (!$num_rows) {
    $giantbombID = clean($twitch->top[$i]->game->giantbomb_id, $link);
    $gameName = clean($twitch->top[$i]->game->name, $link);

    // Insert new game into table
    $sql = "INSERT INTO `twitch_games` (twitch_id, giantbomb_id, name) VALUES ('$twitchID', '$giantbombID', '$gameName')";
    $result = mysqli_query($link, $sql) or die(mysqli_error($link));
  }

  // Insert game/viewers
  $sql = "INSERT INTO `twitch_topgames` (twitch_id, viewers) VALUES ('$twitchID', '$viewers')";
  $result = mysqli_query($link, $sql) or die(mysqli_error($link));
}

// Close connection
mysqli_close($link);

// Remove special characters
// $input : string to be sanitized
// $link : the connection to MySQL
function clean($input, $link) {
  $input = htmlspecialchars($input);
  $input = mysqli_real_escape_string($link, $input);
  return $input;
}

// PHP Helper Functions
function get_url_contents($url){
    $crl = curl_init();
    $timeout = 5;
    curl_setopt ($crl, CURLOPT_URL,$url);
    curl_setopt ($crl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt ($crl, CURLOPT_CONNECTTIMEOUT, $timeout);
    $ret = curl_exec($crl);
    curl_close($crl);
    return $ret;
}

function post_url_contents($url, $fields) {

    foreach($fields as $key=>$value) { $fields_string .= $key.'='.urlencode($value).'&'; }
    rtrim($fields_string, '&');

    $crl = curl_init();
    $timeout = 5;

    curl_setopt($crl, CURLOPT_URL,$url);
    curl_setopt($crl,CURLOPT_POST, count($fields));
    curl_setopt($crl,CURLOPT_POSTFIELDS, $fields_string);

    curl_setopt ($crl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt ($crl, CURLOPT_CONNECTTIMEOUT, $timeout);
    $ret = curl_exec($crl);
    curl_close($crl);
    return $ret;
}
?>
