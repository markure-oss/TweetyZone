<?php
  require_once("backend/initialize.php");
  if(Login::isLoggedIn()){
    $user_id=Login::isLoggedIn();
  }else if(isset($_SESSION['userLoggedIn'])){
    $user_id=$_SESSION['userLoggedIn'];
    $verify->authOnly($user_id);
  }else{
      redirect_to(url_for("index"));
  }

  if(is_get_request()){
    if(isset($_GET['username']) && !empty($_GET['username'])){
        $username=FormSanitizer::formSanitizerString($_GET['username']);
        $profileId=$loadFromUser->userIdByUsername($username);
        if(!$profileId){
            redirect_to(url_for("home"));
        }
        
    }else{
        $profileId=$user_id;
    }
}
$user=$loadFromUser->userData($user_id);
$notificationCount=$loadFromMessage->notificationCount($user_id);
$profileData=$loadFromUser->userData($profileId);
$date_joined=strtotime($profileData->signUpDate);
$pageTitle=$profileData->firstName.' '.$profileData->lastName.'(@'.$profileData->username.') / Twitter';
?>
<?php require_once 'backend/shared/header.php'; ?>
<div class="u-p-d" data-uid="<?php echo $user_id; ?>" data-pid="<?php echo $profileId; ?>"></div>
<?php require_once "backend/shared/nav_header.php"; ?>

<main role="main">
  <?php require_once "backend/shared/profile_header.php"; ?>
  <div class="tabsContainer">
    <?php echo $loadFromTweet->createTab("Tweets",url_for($profileData->username),true); ?>
    <?php echo $loadFromTweet->createTab("Tweets & replies",url_for($profileData->username.'/replies'),false); ?>
  </div>
  <section aria-label="Timeline:Your Profile Timeline" class="profilePostsContainer">
    <?php $loadFromTweet->profileTweets($profileId,$user_id); ?>
  </section>
  <div id="popUpModal" class="retweet-modal-container">
  </div>
  <div class="reply-wrapper">
  </div>
  <!-- <?php //require_once 'backend/shared/previewContainer.php'; ?> -->
  <div class="del-post-wrapper-container">
    <div class="del-post-wrapper">
      <div class="del-post-content">
        <h2 class="del-post-content-header">Delete Tweet?</h2>
        <p>This can’t be undone and it will be removed from your profile, the timeline of any accounts that follow you,
          and from Twitter search results.</p>
        <div class="del-btn-wrapper">
          <button class="del-btn" id="cancel" type="button">Cancel</button>
          <button class="del-btn" id="delete-post-btn" type="button">Delete</button>
        </div>
      </div>
    </div>
  </div>
  </section>

  <!-- right-rail -->
  <aside role="Complementary" class="right-rail">
    <div id="search-area">
      <form id="search-form" aria-label="Search Twitter" role="search">
        <input type="text" name="main-search" id="main-search" placeholder="Search Twitter" role="searchbox">
        <svg viewBox="0 0 24 24" class="search-icon">
          <g>
            <path
              d="M21.53 20.47l-3.66-3.66C19.195 15.24 20 13.214 20 11c0-4.97-4.03-9-9-9s-9 4.03-9 9 4.03 9 9 9c2.215 0 4.24-.804 5.808-2.13l3.66 3.66c.147.146.34.22.53.22s.385-.073.53-.22c.295-.293.295-.767.002-1.06zM3.5 11c0-4.135 3.365-7.5 7.5-7.5s7.5 3.365 7.5 7.5-3.365 7.5-7.5 7.5-7.5-3.365-7.5-7.5z">
            </path>
          </g>
        </svg>
      </form>
      <div id="search-show">
        <div class="search-result">
          <div class="search-title" style="">
            <div class="search-header">
              <h3>Try searching for people, topics, or keywords</h3>
            </div>
          </div>
          <!-- <ul id="suggestion">
                       
                     </ul> -->

        </div>
      </div>
    </div>
    <div class="aside-fixed">
      <section class="trends" aria-labelledby="accessible-list-0" role="region">
        <div class="trends-container">
          <div class="trends-container__header">
            <h1 aria-level="1" role="heading">Trends for you</h1>
          </div>
          <div class="trends-body" aria-label="Timeline: Trending now">
            <?php $loadFromTweet->trends(); ?>
          </div>
        </div>

      </section>
      <div class="follow">
        <h3 class="follow-heading">Who to follow</h3>
        <?php $loadFromFollow->whoToFollow($user_id,$user_id); ?>
        <!-- -->

        <footer class="follow-footer">
          <ul>
            <li><a href="#">Terms</a></li>
            <li><a href="#">Privacy policy</a></li>
            <li><a href="#">Cookies</a></li>
            <li><a href="#">About</a></li>
            <li><a href="#">More</a></li>
          </ul>
        </footer>
      </div>
    </div>
  </aside>
</main>

</section>
<script src="<?php echo url_for("frontend/assets/js/liveSearch.js"); ?>"></script>
<script src="<?php echo url_for("frontend/assets/js/notify.js"); ?>"></script>
<script src="<?php echo url_for("frontend/assets/js/follow.js"); ?>"></script>
<script src="<?php echo url_for("frontend/assets/js/delete.js"); ?>"></script>
<script src="<?php echo url_for("frontend/assets/js/hashtag.js"); ?>"></script>
<script src="<?php echo url_for("frontend/assets/js/retweet.js"); ?>"></script>
<script src="<?php echo url_for("frontend/assets/js/reply.js"); ?>"></script>
<script src="<?php echo url_for("frontend/assets/js/likeTweet.js"); ?>"></script>
<script src="<?php echo url_for("frontend/assets/js/fetchTweet.js"); ?>"></script>
<script src="<?php echo url_for("frontend/assets/js/common.js"); ?>"></script>