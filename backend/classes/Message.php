<?php
class Message{
    private $pdo;

    public function __construct(){
        $this->pdo=Database::instance();
    }

    public function recentMessages($userid){
        $stmt=$this->pdo->prepare("SELECT * FROM `messages` LEFT JOIN `users` ON `messageFrom`=`user_id` AND `messageID` IN (SELECT max(`messageID`) FROM `messages` WHERE `messageFrom`=`user_id`) WHERE `messageTo`=:user_id AND `messageFrom`=`user_id` GROUP BY `user_id` ORDER BY `messageID` DESC");
        $stmt->bindParam(":user_id",$userid,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchALL(PDO::FETCH_OBJ);
    }

    public function messageData($otherid,$userid){
        $stmt=$this->pdo->prepare("SELECT * FROM `messages` LEFT JOIN `users` ON `messageFrom`=`user_id` WHERE (`messageFrom`=:otherid AND `messageTo`=:user_id) OR (`messageFrom`=:user_id AND `messageTo`=:otherid) ORDER BY `messageOn` ASC");
        $stmt->bindParam(":user_id",$userid,PDO::PARAM_INT);
        $stmt->bindParam(":otherid",$otherid,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchALL(PDO::FETCH_OBJ);
    }
    public function notificationCount($userid){
        $stmt=$this->pdo->prepare("SELECT * FROM `notification` LEFT JOIN `users` ON notification.notificationFrom=users.user_id WHERE notification.notificationFor=:user_id AND notification.notificationCount='0' AND notificationFrom !=:user_id ORDER BY `notification`.notificationOn DESC");
        $stmt->bindParam(":user_id",$userid,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchALL(PDO::FETCH_OBJ);
    }

    public function notificationCountReset($userid){
        $stmt=$this->pdo->prepare("UPDATE `notification` SET `notificationCount`='1' WHERE `notificationFor`=:user_id AND `notificationCount`='0'");
        $stmt->bindParam(":user_id",$userid,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchALL(PDO::FETCH_OBJ);
    }
    
    public function notification($userid){
        $stmt=$this->pdo->prepare("SELECT * FROM `notification` LEFT JOIN `users` ON notification.notificationFrom=users.user_id WHERE notification.notificationFor=:user_id  AND notificationFrom !=:user_id ORDER BY `notification`.notificationOn DESC");
        $stmt->bindParam(":user_id",$userid,PDO::PARAM_INT);
        $stmt->execute();
        $notifications=$stmt->fetchALL(PDO::FETCH_OBJ);
        if(!empty($notifications)){
            foreach($notifications as $notify){
               if($notify->type=='follow'){
                   echo '<div class="notify-container" data-profileid="'.$notify->user_id.'" data-notificationid="'.$notify->ID.'">
                   <div class="notify-user-wrappper">
                      <svg xmlns="http://www.w3.org/2000/svg" class="p-icon" viewBox="0 0 24 24"><g><path d="M12.225 12.165c-1.356 0-2.872-.15-3.84-1.256-.814-.93-1.077-2.368-.805-4.392.38-2.826 2.116-4.513 4.646-4.513s4.267 1.687 4.646 4.513c.272 2.024.008 3.46-.806 4.392-.97 1.106-2.485 1.255-3.84 1.255zm5.849 9.85H6.376c-.663 0-1.25-.28-1.65-.786-.422-.534-.576-1.27-.41-1.968.834-3.53 4.086-5.997 7.908-5.997s7.074 2.466 7.91 5.997c.164.698.01 1.434-.412 1.967-.4.505-.985.785-1.648.785z"/></g></svg>
                   </div>
                   <div class="notify-wrapper-content">
                       <div class="notify-wrapper-user" style="height:40px;width:40px;margin-bottom:10px;flex-shrink:0;">
                          <a href="'.url_for($notify->username).'">
                               <img src="'.url_for($notify->profileImage).'" style="height:100%;width:100%;object-fit:cover;border-radius:50%;"/>
                          </a>
                       </div>
                       <div class="notify-content">
                           <a href="'.url_for($notify->username).'" class="notify-content__name">
                             '.$notify->firstName.' '.$notify->lastName.'
                            </a>
                            <div class="notify-content__text">
                               Followed you
                            </div>
                       </div>

                   </div>
                </div>';
               }else if($notify->type=='like'){
                   echo '<div class="notify-like-container" data-profileid="'.$notify->user_id.'" data-tweetid="'.$notify->target.'" data-notificationid="'.$notify->ID.'">
                   <div class="notify-like-wrappper">
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g><path d="M12 21.638h-.014C9.403 21.59 1.95 14.856 1.95 8.478c0-3.064 2.525-5.754 5.403-5.754 2.29 0 3.83 1.58 4.646 2.73.814-1.148 2.354-2.73 4.645-2.73 2.88 0 5.404 2.69 5.404 5.755 0 6.376-7.454 13.11-10.037 13.157H12z"/></g></svg>
                   </div>
                   <div class="notify-wrapper-content">
                       <div class="notify-wrapper-user" style="height:40px;width:40px;margin-bottom:10px;flex-shrink:0;">
                          <a href="'.url_for($notify->username).'">
                               <img src="'.url_for($notify->profileImage).'" style="height:100%;width:100%;object-fit:cover;border-radius:50%;"/>
                          </a>
                       </div>
                       <div class="notify-content">
                           <a href="'.url_for($notify->username).'" class="notify-content__name">
                           '.$notify->firstName.' '.$notify->lastName.'
                            </a>
                            <div class="notify-content__text">
                               Liked your tweet
                            </div>
                       </div>

                   </div>
                </div>';
               }else if($notify->type=='message'){
                   echo '<div class="notify-msg-container" data-profileid="'.$notify->user_id.'" data-tweetid="'.$notify->target.'" data-notificationid="'.$notify->ID.'">
                   <div class="notify-user-wrappper">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" data-supported-dps="24x24" fill="currentColor" class="mercado-match" width="24" height="24" focusable="false">
                        <path d="M16 4H8a7 7 0 000 14h4v4l8.16-5.39A6.78 6.78 0 0023 11a7 7 0 00-7-7zm-8 8.25A1.25 1.25 0 119.25 11 1.25 1.25 0 018 12.25zm4 0A1.25 1.25 0 1113.25 11 1.25 1.25 0 0112 12.25zm4 0A1.25 1.25 0 1117.25 11 1.25 1.25 0 0116 12.25z"/>
                        </svg>
                   </div>
                   <div class="notify-wrapper-content">
                       <div class="notify-wrapper-user" style="height:40px;width:40px;margin-bottom:10px;flex-shrink:0;">
                          <a href="'.url_for($notify->username).'">
                               <img src="'.url_for($notify->profileImage).'" style="height:100%;width:100%;object-fit:cover;border-radius:50%;"/>
                          </a>
                       </div>
                       <div class="notify-content">
                           <a href="'.url_for($notify->username).'" class="notify-content__name">
                           '.$notify->firstName.' '.$notify->lastName.'
                            </a>
                            <div class="notify-content__text">
                               Sent you a message
                            </div>
                       </div>

                   </div>
                </div>';
               }else if($notify->type=='comment'){
                echo '<div class="notify-comment-container" data-profileid="'.$notify->user_id.'" data-tweetid="'.$notify->target.'" data-notificationid="'.$notify->ID.'">
                        <div class="notify-user-wrappper">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g><path d="M14.046 2.242l-4.148-.01h-.002c-4.374 0-7.8 3.427-7.8 7.802 0 4.098 3.186 7.206 7.465 7.37v3.828c0 .108.044.286.12.403.142.225.384.347.632.347.138 0 .277-.038.402-.118.264-.168 6.473-4.14 8.088-5.506 1.902-1.61 3.04-3.97 3.043-6.312v-.017c-.006-4.367-3.43-7.787-7.8-7.788zm3.787 12.972c-1.134.96-4.862 3.405-6.772 4.643V16.67c0-.414-.335-.75-.75-.75h-.396c-3.66 0-6.318-2.476-6.318-5.886 0-3.534 2.768-6.302 6.3-6.302l4.147.01h.002c3.532 0 6.3 2.766 6.302 6.296-.003 1.91-.942 3.844-2.514 5.176z"/></g></svg>
                        </div>
                        <div class="notify-wrapper-content">
                            <div class="notify-wrapper-user" style="height:40px;width:40px;margin-bottom:10px;flex-shrink:0;">
                            <a href="'.url_for($notify->username).'">
                                    <img src="'.url_for($notify->profileImage).'" style="height:100%;width:100%;object-fit:cover;border-radius:50%;"/>
                            </a>
                            </div>
                            <div class="notify-content">
                                <a href="'.url_for($notify->username).'" class="notify-content__name">
                                '.$notify->firstName.' '.$notify->lastName.'
                                </a>
                                <div class="notify-content__text">
                                    Comment on your tweets
                                </div>
                            </div>

                        </div>
                    </div>';
               }else if($notify->type=='retweet'){
                echo '<div class="notify-retweet-container" data-profileid="'.$notify->user_id.'" data-tweetid="'.$notify->target.'" data-notificationid="'.$notify->ID.'">
                        <div class="notify-user-wrappper">
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" ><g><path d="M23.615 15.477c-.47-.47-1.23-.47-1.697 0l-1.326 1.326V7.4c0-2.178-1.772-3.95-3.95-3.95h-5.2c-.663 0-1.2.538-1.2 1.2s.537 1.2 1.2 1.2h5.2c.854 0 1.55.695 1.55 1.55v9.403l-1.326-1.326c-.47-.47-1.23-.47-1.697 0s-.47 1.23 0 1.697l3.374 3.375c.234.233.542.35.85.35s.613-.116.848-.35l3.375-3.376c.467-.47.467-1.23-.002-1.697zM12.562 18.5h-5.2c-.854 0-1.55-.695-1.55-1.55V7.547l1.326 1.326c.234.235.542.352.848.352s.614-.117.85-.352c.468-.47.468-1.23 0-1.697L5.46 3.8c-.47-.468-1.23-.468-1.697 0L.388 7.177c-.47.47-.47 1.23 0 1.697s1.23.47 1.697 0L3.41 7.547v9.403c0 2.178 1.773 3.95 3.95 3.95h5.2c.664 0 1.2-.538 1.2-1.2s-.535-1.2-1.198-1.2z"/></g></svg>
                        </div>
                        <div class="notify-wrapper-content">
                            <div class="notify-wrapper-user" style="height:40px;width:40px;margin-bottom:10px;flex-shrink:0;">
                            <a href="'.url_for($notify->username).'">
                                    <img src="'.url_for($notify->profileImage).'" style="height:100%;width:100%;object-fit:cover;border-radius:50%;"/>
                            </a>
                            </div>
                            <div class="notify-content">
                                <a href="'.url_for($notify->username).'" class="notify-content__name">
                                '.$notify->firstName.' '.$notify->lastName.'
                                </a>
                                <div class="notify-content__text">
                                    Retweet on your tweets
                                </div>
                            </div>

                        </div>
                    </div>';
               }
            }
        }
        
    }

    public function mentionNotification($userid){
        $stmt=$this->pdo->prepare("SELECT * FROM `notification` LEFT JOIN `users` ON notification.notificationFrom=users.user_id WHERE notification.notificationFor=:user_id AND notificationFrom !=:user_id AND type='mention' ORDER BY `notification`.notificationOn DESC");
        $stmt->bindParam(":user_id",$userid,PDO::PARAM_INT);
        $stmt->execute();
        $notifications=$stmt->fetchALL(PDO::FETCH_OBJ);
        if(!empty($notifications)){
            foreach($notifications as $notify){
               if($notify->type=='mention'){
                   echo '<div class="notify-container" data-profileid="'.$notify->user_id.'" data-notificationid="'.$notify->ID.'">
                   <div class="notify-user-wrappper">
                      <svg xmlns="http://www.w3.org/2000/svg" class="p-icon" viewBox="0 0 24 24"><g><path d="M12.225 12.165c-1.356 0-2.872-.15-3.84-1.256-.814-.93-1.077-2.368-.805-4.392.38-2.826 2.116-4.513 4.646-4.513s4.267 1.687 4.646 4.513c.272 2.024.008 3.46-.806 4.392-.97 1.106-2.485 1.255-3.84 1.255zm5.849 9.85H6.376c-.663 0-1.25-.28-1.65-.786-.422-.534-.576-1.27-.41-1.968.834-3.53 4.086-5.997 7.908-5.997s7.074 2.466 7.91 5.997c.164.698.01 1.434-.412 1.967-.4.505-.985.785-1.648.785z"/></g></svg>
                   </div>
                   <div class="notify-wrapper-content">
                       <div class="notify-wrapper-user" style="height:40px;width:40px;margin-bottom:10px;flex-shrink:0;">
                          <a href="'.url_for($notify->username).'">
                               <img src="'.url_for($notify->profileImage).'" style="height:100%;width:100%;object-fit:cover;border-radius:50%;"/>
                          </a>
                       </div>
                       <div class="notify-content">
                           <a href="'.url_for($notify->username).'" class="notify-content__name">
                             '.$notify->firstName.' '.$notify->lastName.'
                            </a>
                            <div class="notify-content__text">
                               Mentioned you
                            </div>
                       </div>

                   </div>
                </div>';
               }
            }
        }
        
    }
}