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
<div class="modal-content">
  <div class="modal-header">
    <span class="close" aria-label="Close" data-focusable="true" role="button" tabindex="0"><svg viewBox="0 0 24 24"
        class="close-icon">
        <g>
          <path
            d="M13.414 12l5.793-5.793c.39-.39.39-1.023 0-1.414s-1.023-.39-1.414 0L12 10.586 6.207 4.793c-.39-.39-1.023-.39-1.414 0s-.39 1.023 0 1.414L10.586 12l-5.793 5.793c-.39.39-.39 1.023 0 1.414.195.195.45.293.707.293s.512-.098.707-.293L12 13.414l5.793 5.793c.195.195.45.293.707.293s.512-.098.707-.293c.39-.39.39-1.023 0-1.414L13.414 12z">
          </path>
        </g>
      </svg></span>
  </div>
  <div class="modal-body">
    <div class="modal-body-header">
      <div class="modal-image-wrapper">
        <img src="<?php echo url_for($user->profileImage); ?>"
          alt="<?php echo $user->firstName.' '.$user->lastName; ?>">
      </div>
      <input type="text" placeholder="Add a comment" id="retweet-comment" autofocus="">
    </div>
    <div class="modal-retweet-content">
      <div class="modal-retweet-header">
        <div class="modal-user-img-wrapper">
          <img src="<?php echo url_for($post->profileImage); ?>"
            alt="<?php  echo $post->firstName.' '.$post->lastName; ?>" width="30px">
        </div>
        <div class="retweet-user-fullName">
          <h4><?php echo $post->firstName.' '.$post->lastName; ?></h4>
        </div>
        <div class="retweet-username">
          @<?php echo $post->username; ?>
        </div>
        <div class="retweet-date-post">
          <?php echo $loadFromUser->timeAgo($post->postedOn); ?>
        </div>
      </div>
      <div class="modal-retweet-post-body">
        <p><?php echo $loadFromTweet->getTweetLinks($post->status); ?></p>
        <?php if(!empty($post->tweetImage)) :?>
        <div class="postContentContainer_rImage">
          <img src="<?php echo url_for($post->tweetImage); ?>" />
        </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
  <div class="retweet-modal-footer">
    <div class="retweet-btn" id="retweet-btn" role="button" data-focusable="true" tabindex="0">
      <span class="retweet-post-text">Retweet</span>
    </div>
  </div>

</div>

<?php
          }else if(!empty($commentpost)){ ?>
<div class="modal-content">
  <div class="modal-header">
    <span class="close" aria-label="Close" data-focusable="true" role="button" tabindex="0"><svg viewBox="0 0 24 24"
        class="close-icon">
        <g>
          <path
            d="M13.414 12l5.793-5.793c.39-.39.39-1.023 0-1.414s-1.023-.39-1.414 0L12 10.586 6.207 4.793c-.39-.39-1.023-.39-1.414 0s-.39 1.023 0 1.414L10.586 12l-5.793 5.793c-.39.39-.39 1.023 0 1.414.195.195.45.293.707.293s.512-.098.707-.293L12 13.414l5.793 5.793c.195.195.45.293.707.293s.512-.098.707-.293c.39-.39.39-1.023 0-1.414L13.414 12z">
          </path>
        </g>
      </svg></span>
  </div>
  <div class="modal-body">
    <div class="modal-body-header">
      <div class="modal-image-wrapper">
        <img src="<?php echo url_for($user->profileImage); ?>"
          alt="<?php echo $user->firstName.' '.$user->lastName; ?>">
      </div>
      <input type="text" placeholder="Add a comment" id="retweet-comment" autofocus="">
    </div>
    <div class="modal-retweet-content">
      <div class="modal-retweet-header">
        <div class="modal-user-img-wrapper">
          <img src="<?php echo url_for($commentpost->profileImage); ?>"
            alt="<?php  echo $commentpost->firstName.' '.$commentpost->lastName; ?>" width="30px">
        </div>
        <div class="retweet-user-fullName">
          <h4><?php echo $commentpost->firstName.' '.$commentpost->lastName; ?></h4>
        </div>
        <div class="retweet-username">
          @<?php echo $commentpost->username; ?>
        </div>
        <div class="retweet-date-post">
          <?php echo $loadFromUser->timeAgo($commentpost->commentAt); ?>
        </div>
      </div>
      <div class="modal-retweet-post-body">
        <p><?php echo $loadFromTweet->getTweetLinks($commentpost->comment); ?></p>
      </div>
    </div>
  </div>
  <div class="retweet-modal-footer">
    <div class="retweet-btn" id="retweet-btn" role="button" data-focusable="true" tabindex="0">
      <span class="retweet-post-text">Retweet</span>
    </div>
  </div>

</div>
<?php
          }

    }

    if(isset($_POST['retweet']) && !empty($_POST['retweet'])){
        $comment=FormSanitizer::formSanitizerString($_POST['comment']);
        $tweetId=h($_POST['retweet']);
        $user_id=h($_POST['user_id']);
        $tweetBy=h($_POST['tweetby']);

       echo $loadFromTweet->retweetCount($user_id,$tweetId,$comment,$tweetBy);
        

    }

    if(isset($_POST['deretweet']) && !empty($_POST['deretweet'])){
          $tweetId=h($_POST['deretweet']);
         $user_id=h($_POST['user_id']);
         $tweetBy=h($_POST['tweetby']);
  
         echo $loadFromTweet->ResetretweetCount($user_id,$tweetId,$tweetBy);
          
      }

      
    if(isset($_POST['fetchretweet']) && !empty($_POST['fetchretweet'])){
          $tweetId=h($_POST['fetchretweet']);
          $user_id=h($_POST['user_id']);

          $retweet=$loadFromTweet->checkRetweet($user_id,$tweetId);

          if(!empty($retweet)){
            $loadFromTweet->tweets($user_id,10);
          }
  
        //  $loadFromTweet->retweetCount($user_id,$tweetId,$comment);   
  
      }
}

?>