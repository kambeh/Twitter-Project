<?php
require "twitteroauth/autoload.php";

use Abraham\TwitterOAuth\TwitterOAuth;

$twitteruser = "chevyVolt";
$num_tweets = 500;
$str = "";
$hours = array();
$timeStamp = array();
$tmp = array();

const CONSUMER_KEY = "YOUR_OAUTH_ACCESS_TOKEN";
const CONSUMER_SECRET = "YOUR_OAUTH_ACCESS_TOKEN_SECRET";
$access_token = "YOUR_CONSUMER_KEY";
$access_token_secret = "YOUR_CONSUMER_SECRET";

$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token, $access_token_secret);
$content = $connection->get("account/verify_credentials");
$statues = $connection->get("statuses/user_timeline", array("screen_name" => $twitteruser, "count" => $num_tweets));

// pre-fill hours array in 24-hrs format
$hours = array_fill(0, 24, 0);

if(isset($statues->errors)) {
	echo $statues->errors[0]->message;
}
else {
	foreach ($statues as $key => $data) {
		$tmp = explode(' ', $data->created_at);
		array_push($timeStamp, $tmp[3]);
	}
}

foreach ($timeStamp as $time) {
	$tmp = explode(':', $time);
	
	// convert hour part to int
	$hr = (int)$tmp[0];
	
	// increment by one for each group
	$hours[$hr] += 1;
}

// convert data to json format
$jsonarr = json_encode($hours);
?>