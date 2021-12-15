const contentContainer = document.getElementById("Content");
const firstContentChild = document.getElementById("content-1th-child");
const errorMessage = document.getElementById("warning-message");
const errorMessageText = document.getElementById("message");

//Removing content
contentContainer.removeChild(firstContentChild);
contentContainer.style.marginTop = "0";

let url = new URL(window.location);
let error_to_show = parseInt(url.searchParams.get("error"));

if(error_to_show > 0){
    errorMessage.classList.remove("hidden");
}

if(error_to_show === 1){
    errorMessageText.innerText = "Er is een fout opgetreden met het verzender van uw gegevens"
}
else if(error_to_show === 2){
    errorMessageText.innerText = "Het lijkt er op dat u nog niet alle gegevens heeft ingevuld, probeer het opnieuw";
}
else if(error_to_show === 3){
    errorMessageText.innerText = "Het lijkt er op dat de twee wachtwoorden niet overeenkomen, probeer het opnieuw";
}
else if(error_to_show === 4){
    errorMessageText.innerText = "Uw wachtwoord is te kort, zorg dat het wachtwoord langer is dan 5 tekens";
}