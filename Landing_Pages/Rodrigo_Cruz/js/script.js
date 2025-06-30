

var targetDate = new Date("May 31, 2025 23:59:59").getTime();


var countdownFunction = setInterval(function () {


    var now = new Date().getTime();


    var timeLeft = targetDate - now;


    var days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
    var hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);


    document.getElementById("countdown").innerHTML = days + " : " + hours + " : "
        + minutes + " : " + seconds + "  ";


    if (timeLeft < 0) {
        clearInterval(countdownFunction);
        document.getElementById("countdown").innerHTML = "EXPIROU";
    }
}, 1000);



document.addEventListener("DOMContentLoaded", () => {
    let index = 0;
    const carousel = document.querySelector('.carousel');
    const totalImages = document.querySelectorAll('.carousel img').length;
    const textoElements = document.querySelectorAll('.texto1 h2');

    textoElements[0].classList.add('highlight');

    function changeImage() {

        if (index === 0) {
            textoElements[0].classList.remove('highlight');
        }
        
        index = (index + 1) % totalImages;
        carousel.style.transform = `translateX(${-index * 100}%)`;
        highlightText(index);
    }

    function highlightText(activeIndex) {
        textoElements.forEach((el, i) => {
            if (i === activeIndex) {
                el.classList.add('highlight');
            } else {
                el.classList.remove('highlight');
            }
        });
    }

    setInterval(changeImage, 3000);
});


window.addEventListener("load", function() {
    document.body.classList.add("carregado");
});