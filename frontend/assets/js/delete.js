$(function () {

    let delete_modal = document.querySelector(".del-post-wrapper-container");

    $(document).on("click", "#deleteButton", function () {
        $post_id = $(this).data('tweetid');
        $user_id = $(this).data('userid');
        $tweetby = $(this).data('tweetby');
        delete_modal.style.display = "block";
    })

    $(document).on("click", "#delete-post-btn", function () {
        $.post("http://127.0.0.1:8888/tweety/backend/ajax/deletePost.php", { tweetId: $post_id, userId: $user_id, tweetBy: $tweetby }, function (data) {

            delete_modal.style.display = "none";
            $(".postContainer").html(data);

        })


    });



    $(document).on("click", "#cancel", function () {
        delete_modal.style.display = "none";
    })

    $(document).on("click", function (e) {
        if (e.target == delete_modal) {
            delete_modal.style.display = "none";
        }

    })
})