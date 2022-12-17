<?php 
  require_once("../initialize.php");
  if(is_post_request()){
    if(isset($_POST['onlyStatusText']) && !empty($_POST['onlyStatusText'])){
      $text = FormSanitizer::formSanitizerString($_POST['onlyStatusText']);
      $userid = $_POST['userid'];
      $lastId = $loadFromUser->create("tweets",["status"=>$text,"tweetBy"=>$userid,"postedOn"=>date("Y-m-d H:i:s")]);

      preg_match_all("/#+([a-zA-Z0-9_]+)/i",$text,$hashtag);
      if(!empty($hashtag)){
          $loadFromTweet->addTrend($text,$lastId,$userid);
      }
      $loadFromTweet->addMention($text,$lastId,$userid);
      $loadFromTweet->tweets($userid,10);
    }
  }
  
  if(!empty($_FILES['postImage'])){
    $postImage=$_FILES['postImage'];
    $userid=h($_POST['user_id']);
    
    
    $postImagePath=$loadFromUser->uploadPostImage($postImage);
    $loadFromUser->create("tweets",["tweetBy"=>$userid,"tweetImage"=>$postImagePath,"postedOn"=>date('Y-m-d H:i:s')]);
    $loadFromTweet->tweets($userid,10);

  }

  if(!empty($_POST['fetchHashtag'])){
    $loadFromTweet->trends(); 
  }

  if(isset($_POST['postText']) && !empty($_FILES['postImageText'])){
    $text=FormSanitizer::formSanitizerString($_POST['postText']);
    $postImage=$_FILES['postImageText'];
    $userid=h($_POST['user_id']);
    $postImagePath=$loadFromUser->uploadPostImage($postImage);

    $lastId=$loadFromUser->create("tweets",["status"=>$text,"tweetBy"=>$userid,"tweetImage"=>$postImagePath,"postedOn"=>date('Y-m-d H:i:s')]);
    preg_match_all("/#+([a-zA-Z0-9_]+)/i",$text,$hashtag);
    if(!empty($hashtag)){
      $loadFromTweet->addTrend($text,$lastId,$userid);
    }
    $loadFromTweet->tweets($userid,10);
  }
?>