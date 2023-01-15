var buttons = document.querySelectorAll("[data-carousel-button]")
var waktu = 5000 //5 detik

buttons.forEach(buttons => {
    const slides = buttons.closest("[data-carousel]").querySelector('[data-slides]')
    buttons.addEventListener("click", () =>{
        const offset = buttons.dataset.carouselButton === "sesudah" ? 1 : -1

        const activeSlide = slides.querySelector("[data-active]")
        let newIndex = [...slides.children].indexOf(activeSlide) + offset
        if(newIndex < 0) newIndex = slides.children.length - 1
        if(newIndex >= slides.children.length) newIndex = 0

        slides.children[newIndex].dataset.active = true
        delete activeSlide.dataset.active

    })
    if(slides.children.length <= 1){
        buttons.style.display = "none";
    }
})

setInterval(function(){
    const offset = 1
    const slides = document.querySelector('[data-slides]')

    const activeSlide = slides.querySelector("[data-active]")
    let newIndex = [...slides.children].indexOf(activeSlide) + offset
    if(newIndex < 0) newIndex = slides.children.length - 1
    if(newIndex >= slides.children.length) newIndex = 0

    slides.children[newIndex].dataset.active = true
    if(slides.children.length > 1){
        delete activeSlide.dataset.active
    }
}, waktu)