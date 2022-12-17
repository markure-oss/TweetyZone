let uid = $(".u-p-d").data("uid");
$(function () {
  var path = window.location.href;
  $('#nav a').each(function () {
    if (this.href === path) {
      $(this).addClass('active');
    }
  })

});

const modal = document.querySelector("#myLogoutModal");

$(document).on("click", ".w-header-container", function () {
  modal.style.display = "block";
});

$(window).on("click", function (e) {
  if (e.target == modal) {
    modal.style.display = "none";
  }
});

$(document).on("click", ".go-back-arrow", function () {
  window.location.href = "http://127.0.0.1:8888/tweety/home";
});

$(document).on("click", ".notify-msg-container", function () {
  var otherid = $(this).data('profileid');
  if (otherid != undefined) {
    window.location.href = "http://127.0.0.1:8888/tweety/messages/" + otherid;
  }
})

$(document).on("keyup", "#postTextarea,#replyInput", function (e) {
  let textbox = $(e.target);
  let value = textbox.val().trim();
  let isReplyModal = textbox.parents(".reply-wrapper").length == 1;
  let submitButton = isReplyModal ? $("#replyBtn") : $("#submitPostButton");
  //  let submitButton=$("#submitPostButton");
  if (value == "") {
    submitButton.prop("disabled", true);
    return;
  } else if (value.length >= 200) {
    submitButton.prop("disabled", true);
    return;
  }


  submitButton.prop("disabled", false);
});

$("#addPhoto").change(function () {
  let postImageWrapper = document.querySelector(".postImageContainer__wrapper");
  let submitButton = $("#submitPostButton");
  let image = document.getElementById("postImageItem");

  if (this.files && this.files[0]) {
    postImageWrapper.style.display = "block";
    submitButton.prop("disabled", false);
    let reader = new FileReader();
    reader.onload = function (e) {
      image.src = e.target.result;
    }
    reader.readAsDataURL(this.files[0]);
  }
})
$("#submitPostButton").click(e => {
  e.preventDefault();
  let submitButton = $("#submitPostButton");
  let postImage = document.querySelector("#addPhoto").files[0];
  let postImageWrapper = document.querySelector(".postImageContainer__wrapper");
  let textValue = $("#postTextarea").val();
  let userid = uid;
  let max = 200;
  if ((textValue != "" && textValue != null) && postImage == null) {
    $.post("http://127.0.0.1:8888/tweety/backend/ajax/post.php", { onlyStatusText: textValue, userid: userid }, function (data) {
      $(".postContainer").html(data);
      $("#postTextarea").val("");
      $("#count").text(max);
      submitButton.prop("disabled", true);
    })
  } else if ((postImage != "" && postImage != null) && textValue == "") {
    let formData = new FormData();
    formData.append("user_id", userid);
    formData.append("postImage", postImage);
    $.ajax({
      url: "http://127.0.0.1:8888/tweety/backend/ajax/post.php",
      type: "POST",
      cache: false,
      processData: false,
      data: formData,
      contentType: false,
      success: (data) => {
        $(".postContainer").html(data);
        postImageWrapper.style.display = "none";
        $("#addPhoto").val("");
        submitButton.prop("disabled", true);
      }
    })
  } else if (postImage != null && textValue != "") {
    let formData = new FormData();
    formData.append("user_id", userid);
    formData.append("postImageText", postImage);
    formData.append("postText", textValue);
    $.ajax({
      url: "http://127.0.0.1:8888/tweety/backend/ajax/post.php",
      type: "POST",
      cache: false,
      processData: false,
      data: formData,
      contentType: false,
      success: (data) => {
        $(".postContainer").html(data);
        postImageWrapper.style.display = "none";
        $("#addPhoto").val("");
        submitButton.prop("disabled", true);
      }
    })
  }

});


// $("#submitPostButton").click(e => {
//   e.preventDefault();
//   let submitButton = $("#submitPostButton");
//   let postImage = document.querySelector("#addPhoto").files[0];
//   let postImageWrapper = document.querySelector(".postImageContainer__wrapper");
//   let textValue = $("#postTextarea").val();
//   let userid = uid;
//   let max = 200;
//   if (textValue != "" && textValue != null) {
//     $.post("http://127.0.0.1:8888/tweety/backend/ajax/post.php", { onlyStatusText: textValue, userid: userid, }, function (data) {
//       $(".postContainer").html(data);
//       $("#postTextarea").val('');
//       $("#count").text(max);
//       submitButton.prop('disabled', true)
//     })
//   }


// });