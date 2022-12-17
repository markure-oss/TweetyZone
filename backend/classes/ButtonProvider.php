<?php

class ButtonProvider{

    public static function createTweetButton($text,$image,$class,$countClassName,$tweetId,$tweetBy,$user_id){
        return '<button class="'.$class.'" data-tweetid="'.$tweetId.'" data-tweetby="'.$tweetBy.'" data-userid="'.$user_id.'">
                    '.$image.'
                    <span class="'.$countClassName.'">'.$text.'</span>
                </button>';
    }

    public static function createLikeTweetButton($text,$image,$class,$action,$tweetId,$tweetBy,$user_id){
        return '<button class="'.$class.'" onclick="'.$action.'" data-tweetid="'.$tweetId.'" data-tweetby="'.$tweetBy.'" data-userid="'.$user_id.'">
                    '.$image.'
                    <span class="likesCount">'.$text.'</span>
                </button>';
    }
}