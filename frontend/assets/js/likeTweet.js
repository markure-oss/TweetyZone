function likeTweet(button, tweetId, likedBy, tweetBy) {
    $.post("http://127.0.0.1:8888/tweety/backend/ajax/likeTweet.php", { tweetID: tweetId, likedBy: likedBy, likeOn: tweetBy }, function (data) {
        // alert(data);
        let likeButton = $(button);
        likeButton.addClass("like-active");

        let result = JSON.parse(data);
        updateLikesValue(likeButton.find('.likesCount'), result.likes);
        if (result.likes < 0) {
            likeButton.removeClass("like-active");
            likeButton.find(".fa-heart").addClass("fa-heart-o");
            likeButton.find(".fa-heart-o").removeClass("fa-heart");
        } else {
            likeButton.addClass("like-active");
            likeButton.find(".fa-heart-o").addClass("fa-heart");
            likeButton.find(".fa-heart").removeClass("fa-heart-o");
        }

    });
}

function updateLikesValue(element, num) {
    let likesCountVal = element.text() || "0";
    element.text(parseInt(likesCountVal) + parseInt(num));
}