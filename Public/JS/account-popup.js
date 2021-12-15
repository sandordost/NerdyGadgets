const accountButton = document.getElementById("account-container");
const winkelmandButton = document.getElementById("mijn-winkelmand");
const accountPopup = document.getElementById("account-popup")
const loginOrRegisterScreen = document.getElementById("register-login-popup");
const loginScreen = document.getElementById("login-popup");
const gotoLoginButton = document.getElementById("goto-login-button");
const loginReturnButton = document.getElementById("login-return-button");
const logoutButton = document.getElementById("logout-button");

let accountPopupOpen = false;
let loginPopupOpen = false;

winkelmandButton.addEventListener('click', function (e){
    e.stopPropagation();
})

accountButton.addEventListener('click', function(){
   accountPopupOpen = !accountPopupOpen;
   OpenPopup(accountPopupOpen);

});

gotoLoginButton.addEventListener('click', function(){
    loginPopupOpen = !loginPopupOpen;
    showLogin(loginPopupOpen);
});

loginReturnButton.addEventListener('click', function(){
    loginPopupOpen = !loginPopupOpen;
    showLogin(loginPopupOpen);
});



function OpenPopup(isOpen){
    if(isOpen){
        accountPopup.classList.remove("hidden");
    }
    else{
        accountPopup.classList.add("hidden");
    }
}

function showLogin(isOpen){
    if(isOpen){
        loginOrRegisterScreen.classList.add("hidden");
        loginScreen.classList.remove("hidden");
    }
    else{
        loginOrRegisterScreen.classList.remove("hidden");
        loginScreen.classList.add("hidden");
    }
}