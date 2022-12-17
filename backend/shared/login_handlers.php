<?php 
  if(isset($_SESSION['userLoggedIn'])){
    redirect_to(url_for("home"));

  }else if(Login::isLoggedIn()){
    redirect_to(url_for("home"));
  }
  
  if(is_post_request()){
    if(isset($_POST['un']) && !empty($_POST['un'])){
     $username_email=formSanitizer::formSanitizerString($_POST['un']);
     $password=formSanitizer::formSanitizerString($_POST['pass']);
       

       
      $wasSuccessful=$account->login($username_email,$password);
       if($wasSuccessful){
           session_regenerate_id();
           $_SESSION['userLoggedIn']=$wasSuccessful;
           if(isset($_POST['rememberMe'])){
            $tstrong=true;
            $token=bin2hex(openssl_random_pseudo_bytes(64,$tstrong));
            $loadFromUser->create("token",["user_id"=>$wasSuccessful,"token"=>sha1($token)]);
            setcookie('FBID',$token,time()+3600*24*7,"/",NULL,NULL);
           }
           redirect_to(url_for("home"));
      }
    }
  }


?>