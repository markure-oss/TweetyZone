<?php
require_once "../initialize.php";

if(is_post_request()){
    if(isset($_POST['fetchTweet']) && !empty($_POST['fetchTweet'])){
        $limit=$_POST['fetchTweet'];
        $userid=h($_POST['userid']);
        $loadFromTweet->tweets($userid,$limit);
    }
}

?>