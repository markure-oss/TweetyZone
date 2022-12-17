let pass=document.getElementById("pass");
let pass2=document.getElementById("cpass");
function showPassword(){
    if(pass.type==='password' || pass2.type==="password"){
        pass.type='text';
        pass2.type="text";
    }else{
        pass.type='password';
        pass2.type="password";
    }
}

function showLoginPassword(){
    if(pass.type==='password'){
        pass.type='text';
     
    }else{
        pass.type='password';
    }
}