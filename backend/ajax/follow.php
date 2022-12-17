<?php
require_once "../initialize.php";

if(is_post_request()){
    if(isset($_POST['follow']) && !empty($_POST['follow'])){
        $followID=h($_POST['follow']);
        $userId=h($_POST['userId']);
        $loadFromFollow->follow($followID,$userId);

    }

    if(isset($_POST['unfollow']) && !empty($_POST['unfollow'])){
        $unfollowID=h($_POST['unfollow']);
        $userId=h($_POST['userId']);
        $loadFromFollow->unfollow($unfollowID,$userId);

       

    }
}

?>