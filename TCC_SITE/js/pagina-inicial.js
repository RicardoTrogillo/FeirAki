const changeImg = document.getElementById('imgAltera');

changeImg.onclick = function () {

    if (changeImg.src.endsWith('heart.png')) {
        changeImg.src = '../images/heart_color.png';
    } else {
        changeImg.src = '../images/heart.png';
    }
};

const img = document.querySelector('.mensagem img');

img.addEventListener('click', () => {
    img.style.animation = 'Grow 0.5s ease forwards'; 
    
    setTimeout(() => {
        img.style.animation = '';
    }, 500);
});

