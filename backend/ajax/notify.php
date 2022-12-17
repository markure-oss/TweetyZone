<?php
require_once "../initialize.php";

if(is_post_request()){
    if(isset($_POST['notificationUpdate']) && !empty($_POST['notificationUpdate'])){
       $userid=h($_POST['notificationUpdate']);
       echo count($loadFromMessage->notificationCount($userid));
    }

    if(isset($_POST['notify']) && !empty($_POST['notify'])){
       $userid=h($_POST['notify']);
      $loadFromMessage->notificationCountReset($userid);
     }
}

?>