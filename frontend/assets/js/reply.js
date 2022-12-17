$(function () {

    let reply_modal = document.querySelector(".reply-wrapper");

    $(document).on("click", ".replyModal,.commented", function () {
        $post_id = $(this).data('tweetid');
        $user_id = $(this).data('userid');
        $tweetby = $(this).data('tweetby');
        $counter = $(this).find('.replyCount');
        $button = $(this);
        let isCommented = $button.hasClass("commented");
        if (isCommented) {
            $.post("http://127.0.0.1:8888/tweety/backend/ajax/reply.php", { delComment: $post_id, commentBy: $user_id, tweetBy: $tweetby }, function (data) {


                let result = JSON.parse(data);
                updateRetweetValue($counter, result.delcomment);

                if (result.delcomment < 0) {
                    $button.removeClass('commented').addClass('replyModal');
                    $button.removeClass('replyCountColor');
                    $counter.removeClass('replyCountColor');
                }

            });
        } else {
            reply_modal.style.display = "block";

            $.post("http://127.0.0.1:8888/tweety/backend/ajax/reply.php", { tweetId: $post_id, user_id: $user_id, postedby: $tweetby }, function (data) {
                $(".reply-wrapper").html(data);
            })
        }



    })

    $(document).on("click", "#replyBtn", function () {
        let textValue = $("#replyInput").val().trim();
        // // let retweetComment=$("#retweet-comment").val().trim();
        // if (textValue != "" && textValue != null) {
        $.post("http://127.0.0.1:8888/tweety/backend/ajax/reply.php", { comment: textValue, commentOn: $post_id, commentBy: $user_id, tweetBy: $tweetby }, function (data) {
            $(".reply-wrapper").hide();

            let result = JSON.parse(data);
            updateRetweetValue($counter, result.comment);

            if (result.comment < 0) {
                $button.removeClass('commented').addClass('replyModal');
                $button.removeClass('replyCountColor');
                $counter.removeClass('replyCountColor');
            } else {
                $button.addClass('commented').removeClass('replyModal');
                $button.addClass('replyCountColor');
                $counter.addClass('replyCountColor');
            }

        })
        // }

    });

    // $(document).on("click",".retweet-btn",function(){

    //     $.post("http://127.0.0.1:8888/tweety/backend/ajax/retweet.php",{fetchretweet:$post_id,user_id:$user_id},function(data){
    //         $(".retweet-modal-container").hide();
    //         $(".postContainer").html(data);


    //     })
    // });

    function updateRetweetValue(element, num) {
        let retweetCountVal = element.text() || "0";
        element.text(parseInt(retweetCountVal) + parseInt(num));
    }

    $(document).on("click", ".close", function () {
        reply_modal.style.display = "none";
    })

    $(document).on("click", function (e) {
        if (e.target == reply_modal) {
            reply_modal.style.display = "none";
        }

    })
})