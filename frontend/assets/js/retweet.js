$(function () {
    let modal = document.querySelector(".retweet-modal-container");
    $(document).on("click", ".retweet,.retweeted", function () {
        $post_id = $(this).data('tweetid');
        $user_id = $(this).data('userid');
        $tweetby = $(this).data('tweetby');
        $counter = $(this).find('.retweetCount');
        $button = $(this);
        let isRetweeted = $button.hasClass("retweeted");
        if (isRetweeted) {
            $.post("http://127.0.0.1:8888/tweety/backend/ajax/retweet.php", { deretweet: $post_id, user_id: $user_id, tweetby: $tweetby }, function (data) {

                let result = JSON.parse(data);
                updateRetweetValue($counter, result.deretweet);

                if (result.deretweet < 0) {
                    $(".retweet-header").hide();
                    $button.removeClass('retweeted').addClass('retweet');
                }

            })
        } else {
            modal.style.display = "block";

            $.post("http://127.0.0.1:8888/tweety/backend/ajax/retweet.php", { tweetId: $post_id, user_id: $user_id, postedby: $tweetby }, function (data) {
                $(".retweet-modal-container").html(data);
            })
        }



    })

    $(document).on("click", ".retweet-btn", function () {
        let retweetComment = $("#retweet-comment").val().trim();
        $.post("http://127.0.0.1:8888/tweety/backend/ajax/retweet.php", { retweet: $post_id, user_id: $user_id, comment: retweetComment, tweetby: $tweetby }, function (data) {
            $(".retweet-modal-container").hide();

            let result = JSON.parse(data);
            updateRetweetValue($counter, result.retweet);
            if (result.retweet < 0) {
                $(".retweet-header").hide();
                $button.removeClass('retweeted').addClass('retweet');
            } else {
                $button.removeClass('retweet').addClass('retweeted');
            }
        })
    });

    $(document).on("click", ".retweet-btn", function () {
        $.post("http://127.0.0.1:8888/tweety/backend/ajax/retweet.php", { fetchretweet: $post_id, user_id: $user_id }, function (data) {
            $(".retweet-modal-container").hide();
            $(".postContainer").html(data);
        })
    });


    function updateRetweetValue(element, num) {
        let retweetCountVal = element.text() || "0";
        element.text(parseInt(retweetCountVal) + parseInt(num));
    }

    $(document).on("click", ".close", function () {
        modal.style.display = "none";
    })

    $(document).on("click", function (e) {
        if (e.target == modal) {
            modal.style.display = "none";
        }

    })
})