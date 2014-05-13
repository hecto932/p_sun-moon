<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function get_tweets($user = "DevelopmentWint", $numtweets = 30)
{
	session_start();
	require_once("assets/front/twitteroauth/twitteroauth/twitteroauth.php"); 	//Path to twitteroauth library you downloaded in step 3
	
	$twitteruser 		= $user; 												//user name you want to reference
	$notweets 			= $numtweets; 											//how many tweets you want to retrieve
	$consumerkey 		= "HOZvS2XC7rqIGD5sgfRUBw"; 							//Noted keys from step 2
	$consumersecret 	= "IbrfLJ64pamDVSg80kftNkR4QAWlf7CvhQfyYSljXew"; 		//Noted keys from step 2
	$accesstoken 		= "1934385056-Vierar57ehw6Hw4mxQV2UhWR0chpUuvUtsaefhs"; //Noted keys from step 2
	$accesstokensecret 	= "L0UNOhSjDWTISMxfSv0rh4zzjYuglpHC8vu6JiQyHw"; 		//Noted keys from step 2
	
	function getConnectionWithAccessToken($cons_key, $cons_secret, $oauth_token, $oauth_token_secret) {
	  $connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
	  return $connection;
	}
	
	$connection = getConnectionWithAccessToken($consumerkey, $consumersecret, $accesstoken, $accesstokensecret);
	
	$tweets = $connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=".$twitteruser."&count=".$notweets);
	
	return $tweets;
}
