// When the user scrolls the page, execute myFunction
window.onscroll = function() {myFunction()};

// Get the header
const filter = document.getElementById("FilterFrame");
const infoRow = document.getElementById("info-row");

// Get the offset position of the navbar
let bodyRect = document.body.getBoundingClientRect(),
    elemRect = infoRow.getBoundingClientRect(),
    offset   = elemRect.bottom - bodyRect.top;

let sticky = offset;

// Add the sticky class to the header when you reach its scroll position. Remove "sticky" when you leave the scroll position
function myFunction() {
    if (window.pageYOffset > sticky) {
        filter.classList.add("sticky");
        console.log(sticky);
    } else {
        filter.classList.remove("sticky");
    }
}