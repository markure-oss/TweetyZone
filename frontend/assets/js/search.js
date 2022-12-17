let userid = $(".u-p-d").data("uid");
let timer;
$(function () {

    $(document).on("keydown", ".s-user", function (e) {
        let textbox = $(e.target);
        clearTimeout(timer);


        timer = setTimeout(() => {
            let search = textbox.val().trim();
            if (search != "") {
                $.post("http://127.0.0.1:8888/tweety/backend/ajax/search.php", { search: search, userid: userid }, function (data) {

                    $(".s-result-user").html(data);

                });
                // console.log("data");
            } else {
                $(".s-result-user").html("");
                // console.log("no data");
            }
        }, 500);
    })

});