let registerBtn = document.getElementById('register');
let container = document.getElementById('container');
let loginbTN = document.getElementById('Login');

registerBtn.addEventListener('click', () =>{
    container.classList.add("active");
});

loginbTN.addEventListener('click', () =>{
    container.classList.remove("active");
});