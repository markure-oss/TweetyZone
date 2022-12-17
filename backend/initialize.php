<?php 
ob_start();
date_default_timezone_set("Asia/Ho_Chi_Minh");  
require_once "config.php";
include "classes/PHPMailer.php";
include "classes/SMTP.php";
include "classes/Exception.php";


spl_autoload_register(function($class){
    require_once "classes/{$class}.php";
});

session_start();

$account = new Account;
$loadFromUser=new User;
$verify=new Verify;
$tweetControls=new TweetControl;
$loadFromTweet=new Tweet;
$loadFromFollow=new Follow;
$loadFromMessage = new Message;
include_once("function.php");