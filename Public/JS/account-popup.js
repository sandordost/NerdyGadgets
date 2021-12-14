const accountButton = document.getElementById("account-container");
const winkelmandButton = document.getElementById("mijn-winkelmand");
const accountPopup = document.getElementById("account-popup")

let accountPopupOpen = false;

winkelmandButton.addEventListener('click', function (e){
    e.stopPropagation();
})

accountButton.addEventListener('click', function(){
   accountPopupOpen = !accountPopupOpen;
   OpenPopup(accountPopupOpen);

});

function OpenPopup(isOpen){
    if(isOpen){
        accountPopup.classList.remove("hidden");
    }
    else{
        accountPopup.classList.add("hidden");
    }
}