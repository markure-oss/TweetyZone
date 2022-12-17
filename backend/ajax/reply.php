<?php
require_once "../initialize.php";

if(is_post_request()){

   
    if(isset($_POST['tweetId']) && !empty($_POST['tweetId'])){
         $tweetId=FormSanitizer::formSanitizerString($_POST['tweetId']);
         $userId=h($_POST['user_id']);
         $tweetBy=h($_POST['postedby']);

         $post=$loadFromTweet->getPopupTweet($tweetId,$tweetBy);
         $commentpost=$loadFromTweet->getModalComment($tweetId,$tweetBy);
         $user=$loadFromUser->userData($userId);
         if(!empty($post)){
         ?>
<div class="reply-modal-content">
  <div class="reply-modal-header">
    <span class="close" aria-label="Close" data-focusable="true" role="button" tabindex="0"><svg viewBox="0 0 24 24"
        class="close-icon">
        <g>
          <path
            d="M13.414 12l5.793-5.793c.39-.39.39-1.023 0-1.414s-1.023-.39-1.414 0L12 10.586 6.207 4.793c-.39-.39-1.023-.39-1.414 0s-.39 1.023 0 1.414L10.586 12l-5.793 5.793c-.39.39-.39 1.023 0 1.414.195.195.45.293.707.293s.512-.098.707-.293L12 13.414l5.793 5.793c.195.195.45.293.707.293s.512-.098.707-.293c.39-.39.39-1.023 0-1.414L13.414 12z">
          </path>
        </g>
      </svg></span>
  </div>
  <div class="reply-modal-body">
    <div class="reply-container">
      <div class="reply-wrapper-image">
        <img src="<?php echo url_for($post->profileImage); ?>"
          alt="<?php  echo $post->firstName.' '.$post->lastName; ?>">
      </div>
      <div class="reply-content-wrapper">
        <div class="reply-content-desc">
          <div class="reply-user-fullName">
            <?php  echo $post->firstName.' '.$post->lastName; ?> </div>
          <div class="reply-username">
            @<?php  echo $post->username; ?> </div>
          <div class="reply-desc-date">
            <span class="reply-date-time">.</span><?php  echo $loadFromUser->timeAgo($post->postedOn); ?>
          </div>
        </div>
        <div class="reply-desc-text">
          <?php  echo $loadFromTweet->getTweetLinks($post->status); ?> </div>
        <div class="reply-to-desc">
          <span class="reply-to">Reply to</span> <a href="<?php  echo url_for(h($post->username)); ?>"
            class="reply-username-link">@<?php  echo $post->username; ?></a>
        </div>
      </div>
    </div>
    <div class="reply-user-msg">
      <div class="reply-wrapper-image">
        <img src="<?php  echo url_for($user->profileImage); ?>"
          alt="<?php  echo $user->firstName.' '.$user->lastName; ?>">
      </div>
      <textarea id="replyInput" placeholder="Tweet your reply" autofocus=""></textarea>
    </div>
  </div>
  <div class="reply-modal-footer">
    <button class="reply-btn" id="replyBtn" role="button" data-focusable="true" tabindex="0" disabled="true">
      Reply
    </button>
  </div>
</div>

<?php

         }else if(!empty($commentpost)){ ?>
<div class="reply-modal-content">
  <div class="reply-modal-header">
    <span class="close" aria-label="Close" data-focusable="true" role="button" tabindex="0"><svg viewBox="0 0 24 24"
        class="close-icon">
        <g>
          <path
            d="M13.414 12l5.793-5.793c.39-.39.39-1.023 0-1.414s-1.023-.39-1.414 0L12 10.586 6.207 4.793c-.39-.39-1.023-.39-1.414 0s-.39 1.023 0 1.414L10.586 12l-5.793 5.793c-.39.39-.39 1.023 0 1.414.195.195.45.293.707.293s.512-.098.707-.293L12 13.414l5.793 5.793c.195.195.45.293.707.293s.512-.098.707-.293c.39-.39.39-1.023 0-1.414L13.414 12z">
          </path>
        </g>
      </svg></span>
  </div>
  <div class="reply-modal-body">
    <div class="reply-container">
      <div class="reply-wrapper-image">
        <img src="<?php echo url_for($commentpost->profileImage); ?>"
          alt="<?php  echo $commentpost->firstName.' '.$commentpost->lastName; ?>">
      </div>
      <div class="reply-content-wrapper">
        <div class="reply-content-desc">
          <div class="reply-user-fullName">
            <?php  echo $commentpost->firstName.' '.$commentpost->lastName; ?> </div>
          <div class="reply-username">
            @<?php  echo $commentpost->username; ?> </div>
          <div class="reply-desc-date">
            <span class="reply-date-time">.</span><?php  echo $loadFromUser->timeAgo($commentpost->commentAt); ?>
          </div>
        </div>
        <div class="reply-desc-text">
          <?php  echo $loadFromTweet->getTweetLinks($commentpost->comment); ?> </div>
        <div class="reply-to-desc">
          <span class="reply-to">Reply to</span> <a href="<?php  echo url_for(h($commentpost->username)); ?>"
            class="reply-username-link">@<?php  echo $commentpost->username; ?></a>
        </div>
      </div>
    </div>
    <div class="reply-user-msg">
      <div class="reply-wrapper-image">
        <img src="<?php  echo url_for($user->profileImage); ?>"
          alt="<?php  echo $user->firstName.' '.$user->lastName; ?>">
      </div>
      <textarea id="replyInput" placeholder="Tweet your reply" autofocus=""></textarea>
    </div>
  </div>
  <div class="reply-modal-footer">
    <button class="reply-btn" id="replyBtn" role="button" data-focusable="true" tabindex="0" disabled="true">
      Reply
    </button>
  </div>
</div>
<?php }


    }

    if(isset($_POST['comment']) && !empty($_POST['comment'])){
        $comment=FormSanitizer::formSanitizerString($_POST['comment']);
        $commentOn=h($_POST['commentOn']);
        $commentBy=h($_POST['commentBy']);
        $postedBy=$_POST['tweetBy'];

       echo $loadFromTweet->comment($commentBy,$commentOn,$comment,$postedBy);
        

    }

    if(isset($_POST['delComment']) && !empty($_POST['delComment'])){
          $commentOn=h($_POST['delComment']);
          $commentBy=h($_POST['commentBy']);
         $tweetBy=h($_POST['tweetBy']);
  
         echo $loadFromTweet->delComment($commentBy,$commentOn,$tweetBy);
          
      }
}

?>