<?php
require_once "../initialize.php";

if(is_post_request()){
    if(isset($_POST['tweetID']) && !empty($_POST['tweetID'])){
        $tweetId=FormSanitizer::formSanitizerString($_POST['tweetID']);
        $likedBy=h($_POST['likedBy']);
        $tweetBy=h($_POST['likeOn']);
        
        echo $loadFromTweet->likes($likedBy,$tweetId,$tweetBy);


    }
}

?>