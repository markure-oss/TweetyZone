<?php
require_once "../initialize.php";

if(is_post_request()){
    
    if(isset($_POST['useridForAjax']) && !empty($_POST['otheridForAjax'])){
         $userid=h($_POST['useridForAjax']);
         $otherid=h($_POST['otheridForAjax']);
         $msg=FormSanitizer::formSanitizerString($_POST['msg']);
         $lastInsetedId=$loadFromUser->create("messages",array("message"=>$msg,"messageFrom"=>$userid,"messageTo"=>$otherid,"messageOn"=>date("Y-m-d H:i:s")));
         if($userid != $otherid){
            $loadFromUser->create('notification',array('notificationFor'=>$otherid,'notificationFrom'=>$userid,'target'=>$lastInsetedId,"type"=>"message","status"=>"0","notificationCount"=>"0","notificationOn"=>date('Y-m-d H:i:s')));
         }
         $msgData=$loadFromMessage->messageData($otherid,$userid);
          if(!empty($msgData)){
               echo '<div class="past-data-count" datacount="'.count($msgData).'"></div>';
               foreach($msgData as $msg){
                   if($msg->messageFrom==$userid){
                      echo '<div class="right-sender-msg">
                       <div class="right-sender-text-time">
                      <div class="right-sender-text-wrapper">
                       <div class="s-text">
                          <div class="s-msg-text">
                              '.$msg->message.'
                           </div>
                       </div>
                  </div>
                   <div class="sender-time">'.$loadFromUser->timeAgo($msg->messageOn).'</div>
                   </div>
                   </div>';
                   }else{
                        echo '<div class="left-receiver-msg">
                        <a href="'.url_for($msg->username).'" class="receiver-img">
                        <img src="'.url_for($msg->profileImage).'" alt="'.$msg->firstName.' '.$msg->lastName.'">
                        </a>
                        <div class="receiver-text-time">
                        <div class="left-receiver-text-wrapper">
                                    <div class="r-text">
                                        <div class="r-msg-text">
                                        '.$msg->message.'
                                        </div>
                                    </div>
                        </div>
                        <div class="sender-time">'.$loadFromUser->timeAgo($msg->messageOn).'</div>
                        </div>
                        </div>';
                   }
                   
               }
                    //        
                
          }
    
 
     }

     if(isset($_POST['yourid']) && !empty($_POST['showmsg'])){
        $userid=h($_POST['yourid']);
        $otherid=h($_POST['showmsg']);
    

        $msgData=$loadFromMessage->messageData($otherid,$userid);
         if(!empty($msgData)){
              echo '<div class="past-data-count" datacount="'.count($msgData).'"></div>';
              foreach($msgData as $msg){
                  if($msg->messageFrom==$userid){
                     echo '<div class="right-sender-msg">
                      <div class="right-sender-text-time">
                     <div class="right-sender-text-wrapper">
                      <div class="s-text">
                         <div class="s-msg-text">
                             '.$msg->message.'
                          </div>
                      </div>
                 </div>
                  <div class="sender-time">'.$loadFromUser->timeAgo($msg->messageOn).'</div>
                  </div>
                  </div>';
                  }else{
                       echo '<div class="left-receiver-msg">
                       <a href="'.url_for($msg->username).'" class="receiver-img">
                       <img src="'.url_for($msg->profileImage).'" alt="'.$msg->firstName.' '.$msg->lastName.'">
                       </a>
                       <div class="receiver-text-time">
                       <div class="left-receiver-text-wrapper">
                                   <div class="r-text">
                                       <div class="r-msg-text">
                                       '.$msg->message.'
                                       </div>
                                   </div>
                       </div>
                       <div class="sender-time">'.$loadFromUser->timeAgo($msg->messageOn).'</div>
                       </div>
                       </div>';
                  }
                  
              }
                   
               
         }
   

    }
    
}

?>