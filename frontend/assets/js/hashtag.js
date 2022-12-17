$(function () {
    const hashModal = document.querySelector(".hash-box-wrapper");

    $(window).on("click", function (e) {
        if (e.target == hashModal) {
            hashModal.style.display = "none";
        }
    });

    var regex = /[#|@](\w+)$/ig;

    $(document).on("keyup", "#postTextarea", function (e) {
        let textbox = $(e.target);
        let content = textbox.val().trim();
        let max = 200;
        let text = content.match(regex);
        if (text != null && text != "") {
            var dataString = 'hashtag=' + text;
            $.ajax({
                type: "POST",
                data: dataString,
                url: "http://127.0.0.1:8888/tweety/backend/ajax/getHashtag.php",
                cache: false,
                success: function (data) {
                    hashModal.style.display = "block";
                    $(".hash-box ul").html(data);
                    $(".hash-box li").click(function () {
                        let value = $.trim($(this).find('.getValue').text());
                        let oldContent = $("#postTextarea").val();
                        let newContent = oldContent.replace(regex, " ");
                        $("#postTextarea").val(newContent + value + ' ');
                        hashModal.style.display = "none";
                        $("#postTextarea").focus();
                        $("#count").text(max - content.length);
                    })
                }
            })
        } else {
            hashModal.style.display = "none";
        }

        $("#count").text(max - content.length);
        if (content.length >= 200) {
            $("#count").css("color", "#f00");
        } else {
            $("#count").css("color", "#000");
        }
        // console.log(content);
    })

    $("#submitPostButton").click(e => {
        e.preventDefault();
        $.post("http://127.0.0.1:8888/tweety/backend/ajax/post.php", { fetchHashtag: true }, function (data) {
            $(".trends-body").html(data);
            $("#postTextarea").val("");
            $(".hash-box li").hide();
        })

    });

});