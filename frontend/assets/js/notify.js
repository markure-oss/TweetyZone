$(function () {
    let userid = $(".u-p-d").data("uid");

    function notificationUpdate(userId) {
        if (userId != undefined) {
            $.post("http://127.0.0.1:8888/tweety/backend/ajax/notify.php", { notificationUpdate: userId }, function (data) {
                if (data.trim() == '0') {
                    $(".notification-badge--count").empty();
                    $(".notification-badge-show").css({ "opacity": "0 !important" });
                } else {
                    $(".notification-badge-show").css({ "opacity": "1 !important" });
                    $(".notification-badge--count").html(data);
                }
            });
        } else {
            alert("Argument value is null");
        }
    }

    var notificationInterval;
    notificationInterval = setInterval(() => {
        notificationUpdate(userid);
    }, 1000);

    $(document).on("click", ".global-nav__primary-link-notif", function () {
        if (userid != undefined) {
            $.post("http://127.0.0.1:8888/tweety/backend/ajax/notify.php", { notify: userid }, function (data) {

            });
        }
    });
})