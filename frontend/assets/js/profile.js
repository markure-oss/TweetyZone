var cropper;
$uid=$(".u-p-d").data("uid");
$(function(){
    var modal=document.querySelector(".modal-pic");
    var profileModal=document.querySelector(".art-pic-step");
    var previewContainer=document.querySelector(".modal-preview-container");
    var coverModal=document.querySelector(".art-cov-step");
    

  
    $(document).on("click","#set-up-profile",function(){
        modal.style.display="block";
        profileModal.style.display="block";
        coverModal.style.display="none";
    });

    $(document).on("click","#a-modal-skip",function(){
        profileModal.style.display="none";
        coverModal.style.display="block";
    });

    $(document).on("click",".profile-go-back",function(){
        coverModal.style.display="none";
        previewContainer.style.display="none";
        profileModal.style.display="block";
        $("#topcard_filePhoto").val("");
    });

    $(document).on("click",".cover-go-back",function(){
        previewContainer.style.display="none";
        profileModal.style.display="none";
        coverModal.style.display="block";
        $("#topcard_covfilePhoto").val("");
        let hasClassCover=$(this).hasClass("cover-go-back");
        if(hasClassCover){
            $(".go-back-arrow").addClass("profile-go-back").removeClass("cover-go-back");
        }
    });

    $(document).on("change","#topcard_filePhoto",function(e){
        // console.log(this.files[0])
        if(this.files && this.files[0]){
            profileModal.style.display="none";
            $(".go-back-arrow").addClass("profile-go-back").removeClass("cover-go-back");
            previewContainer.style.display="block";
            let reader=new FileReader();
            reader.onload=function(e){
                let image=document.getElementById("imagePreview");
                image.src=e.target.result;
                if(cropper !== undefined){
                    cropper.destroy();
                }
                cropper=new Cropper(image,{
                    aspectRatio:1 / 1,
                    background:false
                });
                // console.log(e);
            }
            reader.readAsDataURL(this.files[0]);
        }
    })
 
    $(document).on("click","#imageUploadButton",function(){
      
        let isProfile=$(".go-back-arrow").hasClass("profile-go-back");
        if(isProfile){
            var name=document.getElementById("topcard_filePhoto").files[0];
            let canvas=cropper.getCroppedCanvas();
            if(canvas == null){
                alert("Could not upload image,make usre it is an image file");
                return;
            }
            canvas.toBlob((blob)=>{
                let formData=new FormData();
                formData.append("croppedImage",blob);
                // alert($uid);
                formData.append("userId",$uid);
                $.ajax({
                    url:"http://localhost/tweety/backend/ajax/profilePhoto.php",
                    type:"POST",
                    processData:false,
                    data:formData,
                    contentType:false,
                    success:function(data){
                        // alert(data);
                         location.reload(true);
                    }
                })
                // console.log(blob);
            })
            // console.log(name);
            //   alert("Is a profile page!");
        }else{
            var name=document.getElementById("topcard_filePhoto").files[0];
            let canvas=cropper.getCroppedCanvas();
            if(canvas == null){
                alert("Could not upload image,make usre it is an image file");
                return;
            }
            canvas.toBlob((blob)=>{
                let formData=new FormData();
                formData.append("croppedCoverImage",blob);
                // alert($uid);
                formData.append("userId",$uid);
                $.ajax({
                    url:"http://localhost/tweety/backend/ajax/profilePhoto.php",
                    type:"POST",
                    processData:false,
                    data:formData,
                    contentType:false,
                    success:function(data){
                        // alert(data);
                        location.reload(true);
                    }
                })
                // console.log(blob);
            })

        }
    })
    $(document).on("change","#topcard_covfilePhoto",function(e){
        // console.log(this.files[0])
        if(this.files && this.files[0]){
            coverModal.style.display="none";
            $(".go-back-arrow").removeClass("profile-go-back").addClass("cover-go-back");
            previewContainer.style.display="block";
            let reader=new FileReader();
            reader.onload=function(e){
                let image=document.getElementById("imagePreview");
                image.src=e.target.result;
                if(cropper !== undefined){
                    cropper.destroy();
                }
                cropper=new Cropper(image,{
                    aspectRatio:16 / 9,
                    background:false
                });
                // console.log(e);
            }
            reader.readAsDataURL(this.files[0]);
        }
    })

    $(window).on("click",function(e){
        if(e.target==modal){
            modal.style.display="none";
        }
    })
  
  

   
})