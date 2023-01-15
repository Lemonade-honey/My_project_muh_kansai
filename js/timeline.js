// count
let events = document.querySelectorAll(".agenda").length
let target = document.getElementById("event")


// display none
let event = document.querySelector(".timeline-container")
let no_event = document.querySelector(".no-agenda")

if(events <= 0){
    no_event.style.display = 'flex'
    event.style.display = 'none'
    target.innerHTML = ""
}else{
    no_event.style.display = 'none'
    event.style.display = 'flex'
    target.innerHTML = "there are " + events + " events"
}