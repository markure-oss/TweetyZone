<?php

if(is_post_request()){
  $fname=FormSanitizer::formSanitizerName($_POST['firstName']);
  $lname=formSanitizer::formSanitizerName($_POST['lastName']);
  $email=formSanitizer::formSanitizerString($_POST['email']);
  $password=formSanitizer::formSanitizerString($_POST['pass']);
  $password2=formSanitizer::formSanitizerString($_POST['pass2']);
  $username = $account->generateUsername($fname, $lname);
  $wasSuccessfully = $account->register($fname,$lname,$username,$email,$password,$password2);
  if($wasSuccessfully){
    session_regenerate_id();
    $_SESSION['userLoggedIn'] = $wasSuccessfully;
    if(isset($_POST['remember'])){
      $_SESSION['rememberMe'] = $_POST['remember'];
    }
    redirect_to(url_for("verification"));
  }
}

?>