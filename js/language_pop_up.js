let Btn = document.querySelector('.globe');
let loginForm = document.querySelector('.form-pop-up');
let formClose = document.querySelector('#form-close');

Btn.addEventListener('click', () =>{
    loginForm.classList.add('active');
} );

formClose.addEventListener('click', () =>{
    loginForm.classList.remove('active');
} );
