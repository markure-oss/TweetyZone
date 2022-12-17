$(function () {
    $(".f-btn").click(function () {
        let followID = $(this).data("follow");
        let userId = $(this).data("user");
        $button = $(this);
        if ($button.hasClass("follow-btn")) {
            $.post("http://127.0.0.1:8888/tweety/backend/ajax/follow.php", { follow: followID, userId: userId }, function (data) {

                let result = JSON.parse(data);
                $button.removeClass("follow-btn");
                $button.addClass("following-btn");
                $button.text("Following");
                $(".count-followers").text(result.followers);
                $(".count-following").text(result.followering);

            });
        } else {
            $.post("http://127.0.0.1:8888/tweety/backend/ajax/follow.php", { unfollow: followID, userId: userId }, function (data) {

                let result = JSON.parse(data);
                $button.addClass("follow-btn");
                $button.removeClass("following-btn");
                $button.text("Follow");
                $(".count-followers").text(result.followers);
                $(".count-following").text(result.followering);

            });
        }


    })




});