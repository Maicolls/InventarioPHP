$(document).ready(function(){
    $('.login-info-box').fadeOut();
    $('.login-show').addClass('show-log-panel');
});

const toggle = document.querySelector(".toggle"),
input = document.querySelector("input");

toggle.addEventListener("click", () =>{
    if(input.type ==="password"){
        input.type = "text";
        toggle.classList.replace("uil-eye-slash", "uil-eye");
    }else{
        input.type = "password";
    }
})