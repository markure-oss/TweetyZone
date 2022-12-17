<?php

class Tweet{

    private $pdo,$user;

    public function __construct(){
        $this->pdo=Database::instance();
        $this->user=new User;
    }

      public function tweets($user_id, $num){
        // $stmt=$this->pdo->prepare("SELECT * FROM `tweets`, `users` WHERE `tweetBy` = `user_id` AND `user_id`=:userId ORDER BY postedOn DESC LIMIT :num");
       $stmt=$this->pdo->prepare("SELECT * FROM tweets t LEFT JOIN users u ON t.tweetBy=u.user_id WHERE t.tweetBy=:userId UNION SELECT * FROM tweets t LEFT JOIN users u ON t.tweetBy=u.user_id WHERE t.tweetBy IN (SELECT follow.receiver FROM follow WHERE follow.sender=:userId) ORDER BY postedOn DESC LIMIT :num");
        $stmt->bindParam(":userId",$user_id,PDO::PARAM_INT);
        $stmt->bindParam(":num",$num,PDO::PARAM_INT);
        $stmt->execute();
        $tweets=$stmt->fetchAll(PDO::FETCH_OBJ);
        foreach($tweets as $tweet){
        $tweetControls=new TweetControl;
        $controls=$tweetControls->createControls($tweet->tweetID,$tweet->tweetBy,$user_id);
        $retweet=$this->checkRetweet($user_id,$tweet->tweetID);
             if(!empty($retweet)){
                 $retweetUserData=$this->user->userData($retweet['retweetBy']);
             }
             echo '<article role="article" data-focusable="true" tabindex="0" class="post">
             '.(((!empty($retweet['retweetBy']))==$user_id) ? '<div class="retweet-header">
               <div class="retweet-image">
                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" ><g><path d="M23.615 15.477c-.47-.47-1.23-.47-1.697 0l-1.326 1.326V7.4c0-2.178-1.772-3.95-3.95-3.95h-5.2c-.663 0-1.2.538-1.2 1.2s.537 1.2 1.2 1.2h5.2c.854 0 1.55.695 1.55 1.55v9.403l-1.326-1.326c-.47-.47-1.23-.47-1.697 0s-.47 1.23 0 1.697l3.374 3.375c.234.233.542.35.85.35s.613-.116.848-.35l3.375-3.376c.467-.47.467-1.23-.002-1.697zM12.562 18.5h-5.2c-.854 0-1.55-.695-1.55-1.55V7.547l1.326 1.326c.234.235.542.352.848.352s.614-.117.85-.352c.468-.47.468-1.23 0-1.697L5.46 3.8c-.47-.468-1.23-.468-1.697 0L.388 7.177c-.47.47-.47 1.23 0 1.697s1.23.47 1.697 0L3.41 7.547v9.403c0 2.178 1.773 3.95 3.95 3.95h5.2c.664 0 1.2-.538 1.2-1.2s-.535-1.2-1.198-1.2z"/></g></svg>
               </div>
               <div class="retweet-user-link">
                 <a href="'.url_for(h($retweetUserData->username)).'" role="link" class="retweet-link">
                    <span>'.$retweetUserData->firstName.' '.$retweetUserData->lastName.' Retweeted</span>
                 </a>
               </div>
             </div>' : '').'
        <div class="mainContentContainer">
        <div class="userImageContainer">
            <img src="'.url_for($tweet->profileImage).'" alt="'.$tweet->firstName.' '.$tweet->lastName.'">
        </div>
        <div class="postContentContainer">
            <div class="post-header">
                <div class="post-header-featured-left">
                    <a href="'.$tweet->username.'" class="displayName">
                        '. $tweet->firstName.' '.$tweet->lastName.'
                    </a>
                    <span class="username">@'. $tweet->username.'</span>
                    <span class="date">'.$this->user->timeAgo($tweet->postedOn).'</span>
                </div>
                '.(($tweet->tweetBy==$user_id) ? '<span class="dot deletePostButton" id="deleteButton" data-tweetid="'.$tweet->tweetID.'" data-tweetby="'.$tweet->tweetBy.'" data-userid="'.$user_id.'">
                <svg class="dot-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" data-supported-dps="16x16" fill="currentColor" class="mercado-match" width="16" height="16" focusable="false">
                    <path d="M14 3.41L9.41 8 14 12.59 12.59 14 8 9.41 3.41 14 2 12.59 6.59 8 2 3.41 3.41 2 8 6.59 12.59 2z"/>
                </svg>
            </span>' : '' ).'
            </div>
            <div class="post-body">
                <div>'.$this->getTweetLinks($tweet->status).'</div>
                    '.((!empty($tweet->tweetImage)) ? '<div class="postContentContainer_postImage">
                    <img src="'.url_for($tweet->tweetImage).'"/>
                </div>' : '').'
            </div>
           '.$controls.'
        </div>
    </div>
</article>';
       }
       

    }


    public function profileTweets($profileId,$user_id){
        $stmt=$this->pdo->prepare("SELECT * FROM `tweets`, `users` WHERE `tweetBy` = `user_id` AND `user_id`=:userId ORDER BY postedOn DESC");
        $stmt->bindParam(":userId",$profileId,PDO::PARAM_INT);
        $stmt->execute();
        $tweets=$stmt->fetchAll(PDO::FETCH_OBJ);
        foreach($tweets as $tweet){
        $tweetControls=new TweetControl;
        $controls=$tweetControls->createControls($tweet->tweetID,$tweet->tweetBy,$user_id);
        $retweet=$this->checkRetweet($user_id,$tweet->tweetID);
             if(!empty($retweet)){
                 $retweetUserData=$this->user->userData($retweet['retweetBy']);
             }
             echo '<article role="article" data-focusable="true" tabindex="0" class="post">
             '.(((!empty($retweet['retweetBy']))==$user_id) ? '<div class="retweet-header">
               <div class="retweet-image">
                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" ><g><path d="M23.615 15.477c-.47-.47-1.23-.47-1.697 0l-1.326 1.326V7.4c0-2.178-1.772-3.95-3.95-3.95h-5.2c-.663 0-1.2.538-1.2 1.2s.537 1.2 1.2 1.2h5.2c.854 0 1.55.695 1.55 1.55v9.403l-1.326-1.326c-.47-.47-1.23-.47-1.697 0s-.47 1.23 0 1.697l3.374 3.375c.234.233.542.35.85.35s.613-.116.848-.35l3.375-3.376c.467-.47.467-1.23-.002-1.697zM12.562 18.5h-5.2c-.854 0-1.55-.695-1.55-1.55V7.547l1.326 1.326c.234.235.542.352.848.352s.614-.117.85-.352c.468-.47.468-1.23 0-1.697L5.46 3.8c-.47-.468-1.23-.468-1.697 0L.388 7.177c-.47.47-.47 1.23 0 1.697s1.23.47 1.697 0L3.41 7.547v9.403c0 2.178 1.773 3.95 3.95 3.95h5.2c.664 0 1.2-.538 1.2-1.2s-.535-1.2-1.198-1.2z"/></g></svg>
               </div>
               <div class="retweet-user-link">
                 <a href="'.url_for(h($retweetUserData->username)).'" role="link" class="retweet-link">
                    <span>'.$retweetUserData->firstName.' '.$retweetUserData->lastName.' Retweeted</span>
                 </a>
               </div>
             </div>' : '').'
        <div class="mainContentContainer">
        <div class="userImageContainer">
            <img src="'.url_for($tweet->profileImage).'" alt="'.$tweet->firstName.' '.$tweet->lastName.'">
        </div>
        <div class="postContentContainer">
            <div class="post-header">
                <div class="post-header-featured-left">
                    <a href="'.$tweet->username.'" class="displayName">
                        '. $tweet->firstName.' '.$tweet->lastName.'
                    </a>
                    <span class="username">@'. $tweet->username.'</span>
                    <span class="date">'.$this->user->timeAgo($tweet->postedOn).'</span>
                </div>
                '.(($tweet->tweetBy==$user_id) ? '<span class="dot deletePostButton" id="deleteButton" data-tweetid="'.$tweet->tweetID.'" data-tweetby="'.$tweet->tweetBy.'" data-userid="'.$user_id.'">
                <svg class="dot-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" data-supported-dps="16x16" fill="currentColor" class="mercado-match" width="16" height="16" focusable="false">
                    <path d="M14 3.41L9.41 8 14 12.59 12.59 14 8 9.41 3.41 14 2 12.59 6.59 8 2 3.41 3.41 2 8 6.59 12.59 2z"/>
                </svg>
            </span>' : '' ).'
            </div>
            <div class="post-body">
                <div>'.$this->getTweetLinks($tweet->status).'</div>
                    '.((!empty($tweet->tweetImage)) ? '<div class="postContentContainer_postImage">
                    <img src="'.url_for($tweet->tweetImage).'"/>
                </div>' : '').'
            </div>
           '.$controls.'
        </div>
    </div>
</article>';
       }
    }
    
    public function getTrendByHash($hashtag){
        $stmt=$this->pdo->prepare("SELECT DISTINCT `hashtag` FROM `trends` WHERE `hashtag` LIKE :hashtag LIMIT 5");
        $stmt->bindValue(":hashtag",$hashtag.'%');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getMention($mention){
        $stmt=$this->pdo->prepare("SELECT  * FROM `users` WHERE `username` LIKE :mention OR `firstName` LIKE :mention OR `lastName` LIKE :mention LIMIT 5");
        $stmt->bindValue(":mention",$mention.'%');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function addTrend($hashtag,$tweetId,$user_id){
        preg_match_all("/#+([a-zA-Z0-9_]+)/i",$hashtag,$matches);
        if($matches){
            $result=array_values($matches[1]);
        }

        $sql="INSERT INTO `trends` (`hashtag`,`tweet_id`,`user_id`,`createdOn`) VALUES (:hashtag,:tweetid,:userId,:dateOn)";

        foreach($result as $trend){
            if($stmt=$this->pdo->prepare($sql)){
                $stmt->execute(array(':hashtag'=>$trend,':tweetid'=>$tweetId,':userId'=>$user_id,':dateOn'=>date('Y-m-d H:i:s')));
            }
        }

    }
    
    public function addMention($status,$lastId,$userid){
        preg_match_all("/@+([a-zA-Z0-9_]+)/i",$status,$matches);

        if($matches){
            $result=array_values($matches[1]);
        }

        $sql="SELECT * FROM users WHERE username=:mention";

        foreach($result as $trend){
            if($stmt=$this->pdo->prepare($sql)){
                $stmt->execute(array(':mention'=>$trend));
                $data=$stmt->fetch(PDO::FETCH_OBJ);
            }
        }

        if(!empty($data)){
            if($data->user_id !=$userid){
                $this->user->create('notification',array('notificationFor'=>$data->user_id,'notificationFrom'=>$userid,'target'=>$lastId,"type"=>"mention","status"=>"0","notificationCount"=>"0","notificationOn"=>date('Y-m-d H:i:s')));
            }
        }
    }
        
    public function getTweetLinks($tweet){
        $tweet=preg_replace('/#([\w]+)/',"<a href='".url_for("hashtag/$1")."'>$0</a>",$tweet);
        $tweet=preg_replace('/@([\w]+)/',"<a href='".url_for("$1")."'>$0</a>",$tweet);
        return $tweet;
    }

    public function getLikes($tweetId){
        $stmt=$this->pdo->prepare("SELECT  count(*) as `count` FROM `likes` WHERE `likeOn`=:tweetId");
        $stmt->bindParam(":tweetId",$tweetId,PDO::PARAM_INT);
        $stmt->execute();
        $data=$stmt->fetch(PDO::FETCH_ASSOC);
        if($data["count"] > 0){
            return $data["count"];
        }
    }

    public function likes($likedBy,$tweetId,$tweetBy){
        // echo $tweetBy;
        if($this->wasLikedBy($likedBy, $tweetId)){
            // liked
            if($likedBy != $tweetBy){
                $this->user->delete('notification',array('notificationFor'=>$tweetBy,'notificationFrom'=>$likedBy,'target'=>$tweetId,"type"=>"like"));
            }
            $this->user->delete('likes',array('likeBy'=>$likedBy,'likeOn'=>$tweetId));
            $result = array("likes"=>-1);
            return json_encode($result);
        }else {
            //not liked
            if($likedBy != $tweetBy){
                $this->user->create('notification',array('notificationFor'=>$tweetBy,'notificationFrom'=>$likedBy,'target'=>$tweetId,"type"=>"like","status"=>"0","notificationCount"=>"0","notificationOn"=>date('Y-m-d H:i:s')));
            }
            $this->user->create('likes',array('likeBy'=>$likedBy,'likeOn'=>$tweetId));
            $result = array("likes"=>1);
            return json_encode($result);
        }
    }

    public function wasLikedBy($likedBy, $tweetId){
        $stmt=$this->pdo->prepare("SELECT  * FROM `likes` WHERE `likeOn`=:tweetId AND `likeBy`=:userId");
        $stmt->bindParam(":tweetId",$tweetId,PDO::PARAM_INT);
        $stmt->bindParam(":userId",$likedBy,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public function getPopupTweet($tweetId,$tweetBy){
        $stmt=$this->pdo->prepare("SELECT * FROM `tweets` LEFT JOIN `users` ON users.user_id=tweets.tweetBy WHERE tweets.tweetID=:tweetId AND tweets.tweetBy=:tweetby");
        $stmt->bindParam(":tweetId",$tweetId,PDO::PARAM_INT);
        $stmt->bindParam(":tweetby",$tweetBy,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function getModalComment($tweetId,$tweetBy){
        $stmt=$this->pdo->prepare("SELECT * FROM `comment` LEFT JOIN `users` ON users.user_id=comment.commentBy WHERE comment.commentID=:tweetid AND comment.commentBy=:tweetby");
        $stmt->bindParam(":tweetid",$tweetId,PDO::PARAM_INT);
        $stmt->bindParam(":tweetby",$tweetBy,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function getRetweet($tweetId){
        $stmt=$this->pdo->prepare("SELECT  count(*) as `count` FROM `retweet` WHERE `retweetFrom`=:tweetId");
        $stmt->bindParam(":tweetId",$tweetId,PDO::PARAM_INT);
        $stmt->execute();
        $data=$stmt->fetch(PDO::FETCH_ASSOC);
        if($data["count"] > 0){
            return $data["count"];
        }
    }

    public function ResetretweetCount($user_id,$tweetId,$tweetBy){
        if($this->wasRetweetBy($user_id,$tweetId)){
            if($user_id != $tweetBy){
                $this->user->delete('notification',array('notificationFor'=>$tweetBy,'notificationFrom'=>$user_id,'target'=>$tweetId,"type"=>"retweet"));
            }
            $this->user->delete('retweet',array('retweetBy'=>$user_id,'retweetFrom'=>$tweetId));
            $result=array("deretweet"=>-1);
            return json_encode($result);
        }
    }


    public function retweetCount($user_id,$tweetId,$comment,$tweetBy){
        if($this->wasRetweetBy($user_id,$tweetId)){
            if($user_id != $tweetBy){
                $this->user->delete('notification',array('notificationFor'=>$tweetBy,'notificationFrom'=>$user_id,'target'=>$tweetId,"type"=>"retweet"));
            }
            $this->user->delete('retweet',array('retweetBy'=>$user_id,'retweetFrom'=>$tweetId));
            $result=array("retweet"=>-1);
            return json_encode($result);
        }else{
            if($user_id != $tweetBy){
                // echo 'User_id:'.$user_id."+ tweetBy:".$tweetBy;
                $this->user->create('notification',array('notificationFor'=>$tweetBy,'notificationFrom'=>$user_id,'target'=>$tweetId,"type"=>"retweet","status"=>"0","notificationCount"=>"0","notificationOn"=>date('Y-m-d H:i:s')));
            }
            $this->user->create('retweet',array('retweetBy'=>$user_id,'retweetFrom'=>$tweetId));
            $result=array("retweet"=>1);
             return json_encode($result);
            //not liked
        }
    }

    public function wasRetweetBy($user_id, $tweetId){
        $stmt=$this->pdo->prepare("SELECT  * FROM `retweet` WHERE `retweetFrom`=:tweetId AND `retweetBy`=:userId");
        $stmt->bindParam(":tweetId",$tweetId,PDO::PARAM_INT);
        $stmt->bindParam(":userId",$user_id,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }


    public function checkRetweet($user_id,$tweetId){
        $stmt=$this->pdo->prepare("SELECT  * FROM `retweet` WHERE `retweetFrom`=:tweetId AND `retweetBy`=:userId");
        $stmt->bindParam(":tweetId",$tweetId,PDO::PARAM_INT);
        $stmt->bindParam(":userId",$user_id,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
        
    }

    public function getComments($tweetId){
        $stmt=$this->pdo->prepare("SELECT  count(*) as `count` FROM `comment` WHERE `commentOn`=:tweetId");
        $stmt->bindParam(":tweetId",$tweetId,PDO::PARAM_INT);
        $stmt->execute();
        $data=$stmt->fetch(PDO::FETCH_ASSOC);
        if($data["count"] > 0){
            return $data["count"];
        }
    }

    public function comment($commentBy,$commentOn,$comment,$postedBy){
        if($this->wasCommentBy($commentBy,$commentOn)){
            if($commentBy != $postedBy){
                $this->user->delete('notification',array('notificationFor'=>$postedBy,'notificationFrom'=>$commentBy,'target'=>$commentOn,"type"=>"comment"));
            }
            $this->user->delete('comment',array('commentBy'=>$commentBy,'commentOn'=>$commentOn));
            $result=array("comment"=>-1);
            return json_encode($result);
        }else{
            if($commentBy != $postedBy){
                $this->user->create('notification',array('notificationFor'=>$postedBy,'notificationFrom'=>$commentBy,'target'=>$commentOn,"type"=>"comment","status"=>"0","notificationCount"=>"0","notificationOn"=>date('Y-m-d H:i:s')));
            }
            $this->user->create('comment',array('commentBy'=>$commentBy,'commentOn'=>$commentOn,'comment'=>$comment,'commentAt'=>date('Y-m-d H:i:s')));
            $result=array("comment"=>1);
            return json_encode($result);
            //not liked
        }
    }

    public function wasCommentBy($commentBy,$commentOn){
        $stmt=$this->pdo->prepare("SELECT  * FROM `comment` WHERE `commentOn`=:tweetId AND `commentBy`=:userId");
        $stmt->bindParam(":tweetId",$commentOn,PDO::PARAM_INT);
        $stmt->bindParam(":userId",$commentBy,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }
    
    public function delComment($commentBy,$commentOn,$tweetBy){
        if($this->wasCommentBy($commentBy,$commentOn)){
            if($commentBy != $tweetBy){
                $this->user->delete('notification',array('notificationFor'=>$tweetBy,'notificationFrom'=>$commentBy,'target'=>$commentOn,"type"=>"comment"));
            }
            $this->user->delete('comment',array('commentBy'=>$commentBy,'commentOn'=>$commentOn));
            $result=array("delcomment"=>-1);
            return json_encode($result);
        }
    }

    public function tweetCounts($profileId){
        $stmt=$this->pdo->prepare("SELECT  count(*) as `count` FROM `tweets` WHERE `tweetBy`=:profileId");
        $stmt->bindParam(":profileId",$profileId,PDO::PARAM_INT);
        $stmt->execute();
        $data=$stmt->fetch(PDO::FETCH_ASSOC);
        if($data["count"] > 0){
            return $data["count"];
        }
    }

    public function createTab($name,$href,$isSelected){
        $className=$isSelected ? "tab active" : "tab";
        return "<a href='$href' class='$className'>
                 <span>$name</span>
             </a>";
    }

    public function repliesTweets($profileId,$user_id){
        $stmt=$this->pdo->prepare("SELECT * FROM `comment` LEFT JOIN `users` ON `commentBy`=`user_id` WHERE  `commentBy`=:profileId ORDER BY commentAt DESC");
        $stmt->bindParam(":profileId",$profileId,PDO::PARAM_INT);
        $stmt->execute();
        $tweets=$stmt->fetchAll(PDO::FETCH_OBJ);
        foreach($tweets as $tweet){
             $tweetControls=new TweetControl;
             $controls=$tweetControls->createControls($tweet->commentID,$tweet->commentBy,$user_id);
             $retweet=$this->checkRetweet($user_id,$tweet->commentID);
             if(!empty($retweet)){
                 $retweetUserData=$this->user->userData($retweet['commentBy']);
             }
             echo '<article role="article" data-focusable="true" tabindex="0" class="post">
             '.(((!empty($retweet['commentBy']))==$user_id) ? '<div class="retweet-header">
               <div class="retweet-image">
                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" ><g><path d="M23.615 15.477c-.47-.47-1.23-.47-1.697 0l-1.326 1.326V7.4c0-2.178-1.772-3.95-3.95-3.95h-5.2c-.663 0-1.2.538-1.2 1.2s.537 1.2 1.2 1.2h5.2c.854 0 1.55.695 1.55 1.55v9.403l-1.326-1.326c-.47-.47-1.23-.47-1.697 0s-.47 1.23 0 1.697l3.374 3.375c.234.233.542.35.85.35s.613-.116.848-.35l3.375-3.376c.467-.47.467-1.23-.002-1.697zM12.562 18.5h-5.2c-.854 0-1.55-.695-1.55-1.55V7.547l1.326 1.326c.234.235.542.352.848.352s.614-.117.85-.352c.468-.47.468-1.23 0-1.697L5.46 3.8c-.47-.468-1.23-.468-1.697 0L.388 7.177c-.47.47-.47 1.23 0 1.697s1.23.47 1.697 0L3.41 7.547v9.403c0 2.178 1.773 3.95 3.95 3.95h5.2c.664 0 1.2-.538 1.2-1.2s-.535-1.2-1.198-1.2z"/></g></svg>
               </div>
               <div class="retweet-user-link">
                 <a href="'.url_for(h($retweetUserData->username)).'" role="link" class="retweet-link">
                    <span>'.$retweetUserData->firstName.' '.$retweetUserData->lastName.' Retweeted</span>
                 </a>
               </div>
             </div>' : '').'
                 <div class="mainContentContainer">
                 <div class="userImageContainer">
                     <img src="'.url_for($tweet->profileImage).'" alt="'.$tweet->firstName.' '.$tweet->lastName.'">
                 </div>
                 <div class="postContentContainer">
                     <div class="post-header">
                         <div class="post-header-featured-left">
                             <a href="'.$tweet->username.'" class="displayName">
                                 '. $tweet->firstName.' '.$tweet->lastName.'
                             </a>
                             <span class="username">@'. $tweet->username.'</span>
                             <span class="date">'.$this->user->timeAgo($tweet->commentAt).'</span>
                         </div>
                         '.(($tweet->commentBy===$user_id) ? '<span class="dot deletePostButton" id="deleteButton" data-commentid="'.$tweet->commentID.'" data-commentby="'.$tweet->commentBy.'" data-userid="'.$user_id.'">
                            <svg class="dot-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" data-supported-dps="16x16" fill="currentColor" class="mercado-match" width="16" height="16" focusable="false">
                                <path d="M14 3.41L9.41 8 14 12.59 12.59 14 8 9.41 3.41 14 2 12.59 6.59 8 2 3.41 3.41 2 8 6.59 12.59 2z"/>
                            </svg>
                        </span>' : '' ).'
                     </div>
                     <div class="post-body">
                         <div>'.$this->getTweetLinks($tweet->comment).'</div>
                         
                     </div>
                     '.$controls.'
                 </div>
             </div>
         </article>';
        }
    }

    public function getHashtagTweets($hashtag,$user_id){
        $stmt=$this->pdo->prepare("SELECT * FROM users u LEFT JOIN tweets p ON p.tweetBy=u.user_id INNER JOIN trends t ON p.tweetID=t.tweet_id WHERE hashtag=:hashtag ORDER BY postedOn DESC");
        $stmt->bindParam(":hashtag",$hashtag,PDO::PARAM_STR);
        $stmt->execute();
        $tweets=$stmt->fetchAll(PDO::FETCH_OBJ);
        foreach($tweets as $tweet){
             $tweetControls=new TweetControl;
             $controls=$tweetControls->createControls($tweet->tweetID,$tweet->tweetBy,$user_id);
             $retweet=$this->checkRetweet($user_id,$tweet->tweetID);
             if(!empty($retweet)){
                 $retweetUserData=$this->user->userData($retweet['retweetBy']);
             }
             echo '<article role="article" data-focusable="true" tabindex="0" class="post">
             '.(((!empty($retweet['retweetBy']))==$user_id) ? '<div class="retweet-header">
               <div class="retweet-image">
                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" ><g><path d="M23.615 15.477c-.47-.47-1.23-.47-1.697 0l-1.326 1.326V7.4c0-2.178-1.772-3.95-3.95-3.95h-5.2c-.663 0-1.2.538-1.2 1.2s.537 1.2 1.2 1.2h5.2c.854 0 1.55.695 1.55 1.55v9.403l-1.326-1.326c-.47-.47-1.23-.47-1.697 0s-.47 1.23 0 1.697l3.374 3.375c.234.233.542.35.85.35s.613-.116.848-.35l3.375-3.376c.467-.47.467-1.23-.002-1.697zM12.562 18.5h-5.2c-.854 0-1.55-.695-1.55-1.55V7.547l1.326 1.326c.234.235.542.352.848.352s.614-.117.85-.352c.468-.47.468-1.23 0-1.697L5.46 3.8c-.47-.468-1.23-.468-1.697 0L.388 7.177c-.47.47-.47 1.23 0 1.697s1.23.47 1.697 0L3.41 7.547v9.403c0 2.178 1.773 3.95 3.95 3.95h5.2c.664 0 1.2-.538 1.2-1.2s-.535-1.2-1.198-1.2z"/></g></svg>
               </div>
               <div class="retweet-user-link">
                 <a href="'.url_for(h($retweetUserData->username)).'" role="link" class="retweet-link">
                    <span>'.$retweetUserData->firstName.' '.$retweetUserData->lastName.' Retweeted</span>
                 </a>
               </div>
             </div>' : '').'
                 <div class="mainContentContainer">
                 <div class="userImageContainer">
                     <img src="'.url_for($tweet->profileImage).'" alt="'.$tweet->firstName.' '.$tweet->lastName.'">
                 </div>
                 <div class="postContentContainer">
                     <div class="post-header">
                         <div class="post-header-featured-left">
                             <a href="'.$tweet->username.'" class="displayName">
                                 '. $tweet->firstName.' '.$tweet->lastName.'
                             </a>
                             <span class="username">@'. $tweet->username.'</span>
                             <span class="date">'.$this->user->timeAgo($tweet->postedOn).'</span>
                         </div>
                         '.(($tweet->tweetBy===$user_id) ? '<span class="dot deletePostButton" id="deleteButton" data-tweetid="'.$tweet->tweetID.'" data-tweetby="'.$tweet->tweetBy.'" data-userid="'.$user_id.'">
                            <svg class="dot-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" data-supported-dps="16x16" fill="currentColor" class="mercado-match" width="16" height="16" focusable="false">
                                <path d="M14 3.41L9.41 8 14 12.59 12.59 14 8 9.41 3.41 14 2 12.59 6.59 8 2 3.41 3.41 2 8 6.59 12.59 2z"/>
                            </svg>
                        </span>' : '' ).'
                     </div>
                     <div class="post-body">
                        <div>'.$this->getTweetLinks($tweet->status).'</div>
                            '.((!empty($tweet->tweetImage)) ? '<div class="postContentContainer_postImage">
                            <img src="'.url_for($tweet->tweetImage).'"/>
                            </div>' : '').'
                        </div>
                     '.$controls.'
                 </div>
             </div>
         </article>';
        }
    }

    public function trends(){
        $stmt=$this->pdo->prepare("SELECT *,COUNT(`tweetID`) AS `tweetsCount` FROM trends t LEFT JOIN tweets p ON p.tweetID=t.tweet_id AND status LIKE CONCAT('%#',`hashtag`,'%') GROUP BY `hashtag` ORDER BY `tweetsCount` DESC LIMIT 3");
        $stmt->execute();
        $trends=$stmt->fetchALL(PDO::FETCH_OBJ);
        // var_dump($trends);
        if(!empty($trends)){
            foreach($trends as $trend){
                echo '<div class="trends-content" data-trend="'.$trend->trendID.'">
                <h2 aria-level="2" role="heading">#'.$trend->hashtag.'</h2>
                <div class="trends-text"><span class="trends-count">'.$trend->tweetsCount.'</span> Tweets</div>
             </div>';
            }
        }
    }
    
}