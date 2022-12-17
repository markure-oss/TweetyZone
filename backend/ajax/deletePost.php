<?php
require_once "../initialize.php";

if(is_post_request()){
    if(isset($_POST['tweetId']) && !empty($_POST['tweetId'])){
       $tweetId=FormSanitizer::formSanitizerString($_POST['tweetId']);
       $userId=h($_POST['userId']);
       $tweetBy=h($_POST['tweetBy']);

       if($tweetBy==$userId){
            $loadFromUser->delete("tweets",["tweetBy"=>$userId,"tweetID"=>$tweetId]);
       }
       $loadFromTweet->tweets($userId,10);
    }
}

?>