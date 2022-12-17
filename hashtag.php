<?php

require_once "backend/initialize.php";
if(Login::isLoggedIn()){
    $user_id=Login::isLoggedIn();
}else if(isset($_SESSION['userLoggedIn'])){
  $user_id=$_SESSION['userLoggedIn'];
  $verify->authOnly($user_id);
}else{
    redirect_to(url_for("index"));
}

if(is_get_request()){
    if(isset($_GET['hashtag']) && !empty($_GET['hashtag'])){
        $hashtag=FormSanitizer::formSanitizerString($_GET['hashtag']);
        
    }else{
        redirect_to(url_for("home"));
    }
}
$user=$loadFromUser->userData($user_id);
$profileData=$loadFromUser->userData($user_id);
$notificationCount=$loadFromMessage->notificationCount($user_id);
$pageTitle='#'.$hashtag.' Twitter Search /Twitter';
?>
<?php require_once 'backend/shared/header.php'; ?>
<div class="u-p-d" data-uid="<?php echo $user_id; ?>" data-pid="<?php echo $user_id; ?>"></div>
<?php require_once "backend/shared/nav_header.php"; ?>
<main role="main">
  <section class="mainSectionContainer">
    <div class="header-top">
      <div class="go-back-arrow" aria-label="Back" role="button" data-focusable="true" tabindex="0">
        <svg viewBox="0 0 24 24" class="color-blue">
          <g>
            <path
              d="M20 11H7.414l4.293-4.293c.39-.39.39-1.023 0-1.414s-1.023-.39-1.414 0l-6 6c-.39.39-.39 1.023 0 1.414l6 6c.195.195.45.293.707.293s.512-.098.707-.293c.39-.39.39-1.023 0-1.414L7.414 13H20c.553 0 1-.447 1-1s-.447-1-1-1z">
            </path>
          </g>
        </svg>
      </div>
      <div class="header-top-pro">
        <h4><?php  echo $hashtag; ?></h4>

        <div class="tweet-no"><?php //echo $profileData->username; ?></div>
      </div>
    </div>
    <div class="tabsContainer">
      <?php echo $loadFromTweet->createTab("TOP",url_for('hashtag/'.$hashtag),true); ?>

    </div>
    <section aria-label="Timeline:Hashtag" class="profilePostsContainer">
      <?php $loadFromTweet->getHashtagTweets($hashtag,$user_id); ?>
    </section>
    <div id="popUpModal" class="retweet-modal-container">
    </div>
    <div class="reply-wrapper">
    </div>
    <div class="del-post-wrapper-container">
      <div class="del-post-wrapper">
        <div class="del-post-content">
          <h2 class="del-post-content-header">Delete Tweet?</h2>
          <p>This can’t be undone and it will be removed from your profile, the timeline of any accounts that follow
            you, and from Twitter search results.</p>
          <div class="del-btn-wrapper">
            <button class="del-btn" id="cancel" type="button">Cancel</button>
            <button class="del-btn" id="delete-post-btn" type="button">Delete</button>
          </div>
        </div>
      </div>
    </div>

  </section>
  <aside role="Complementary">Aside</aside>
</main>
</section>
<script src="<?php echo url_for("frontend/assets/js/notify.js"); ?>"></script>
<script src="<?php echo url_for("frontend/assets/js/follow.js"); ?>"></script>
<script src="<?php echo url_for("frontend/assets/js/delete.js"); ?>"></script>
<script src="<?php echo url_for("frontend/assets/js/hashtag.js"); ?>"></script>
<script src="<?php echo url_for("frontend/assets/js/retweet.js"); ?>"></script>
<script src="<?php echo url_for("frontend/assets/js/reply.js"); ?>"></script>
<script src="<?php echo url_for("frontend/assets/js/likeTweet.js"); ?>"></script>
<script src="<?php echo url_for("frontend/assets/js/fetchTweet.js"); ?>"></script>
<script src="<?php echo url_for("frontend/assets/js/common.js"); ?>"></script>