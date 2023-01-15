let drop = document.getElementsByClassName("drop");
let menu = document.querySelector(".menu")
let sidebar = document.querySelector(".sidebar")

menu.onclick = () =>{
    sidebar.classList.toggle('active')
}

for(i = 0; i < drop.length; i++){
    drop[i].addEventListener('click', function(){
        this.parentNode.classList.toggle('active')
        let content = this.nextElementSibling
        if(content.style.display === 'block'){
            content.style.display = 'none'
        }else{
            content.style.display = 'block'
        }
    })
}