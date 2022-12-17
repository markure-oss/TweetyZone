<?php
require_once "../initialize.php";

if(is_post_request()){
    if(isset($_POST['search']) && !empty($_POST['search'])){
        $search=FormSanitizer::formSanitizerString($_POST['search']);
        $userid=h($_POST['userid']);

        $result=$loadFromUser->search($search);
        // var_dump($result);
        if(!empty($result)){
            foreach($result as $user){
                if($user->user_id != $userid){
                    echo '<li role="option" aria-selected="true">
                            <div role="button" tabindex="0" data-focusable="true" class="h-ment" data-profileid="'.$user->user_id.'">
                                <div class="ment-w-container">
                                <div class="profile-user-icon">
                                    <div class="profile-user-wrapper">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="p-icon" viewBox="0 0 24 24"><g><path d="M12.225 12.165c-1.356 0-2.872-.15-3.84-1.256-.814-.93-1.077-2.368-.805-4.392.38-2.826 2.116-4.513 4.646-4.513s4.267 1.687 4.646 4.513c.272 2.024.008 3.46-.806 4.392-.97 1.106-2.485 1.255-3.84 1.255zm5.849 9.85H6.376c-.663 0-1.25-.28-1.65-.786-.422-.534-.576-1.27-.41-1.968.834-3.53 4.086-5.997 7.908-5.997s7.074 2.466 7.91 5.997c.164.698.01 1.434-.412 1.967-.4.505-.985.785-1.648.785z"></path></g></svg>
                                    </div>
                                    <div class="f-follow">
                                        Follow
                                    </div>
                                </div>
                                <div class="ment-profile-wrapper">
                                    <div class="ment-profile-pic">
                                        <img src="'.url_for($user->profileImage).'" alt="'.$user->firstName.' '.$user->lastName.'">
                                    </div>
                                    <div class="ment-profile-name">
                                        <div class="ment-user-fullName">
                                            <span class="ment-user-fullName-text">'.$user->firstName.' '.$user->lastName.'</span>
                                        </div>
                                        <div class="ment-user-username">
                                            <span class="ment-user-username-text getValue">@'.$user->username.'</span>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                </li>';
                }
            }
        }
    // }

    // if(isset($_POST['liveSearch']) && !empty($_POST['liveSearch'])){
    //     $search=FormSanitizer::formSanitizerString($_POST['liveSearch']);

    //     $result=$loadFromUser->search($search);
    //     echo '<ul id="suggestion">';
    //     if(!empty($result)){
    //         foreach($result as $user){
    //            echo '<li>
    //                 <a href="'.url_for($user->username).'">
    //                         <div id="image-wrapper-suggest">
    //                             <img src="'.url_for($user->profileImage).'" alt="'.$user->firstName.' '.$user->lastName.'">
    //                         </div>
    //                         <div class="suggest-name">
    //                             <h2>'.$user->firstName.' '.$user->lastName.'</h2>
    //                             <h4>@'.$user->username.'</h4>
    //                         </div>
    //                 </a>
    //                 </li>';
    //         }
    //     }else{
    //         echo '<div class="no-result">No Results Found</div>';
    //     }
    //     echo '</ul>';


    }
}

?>