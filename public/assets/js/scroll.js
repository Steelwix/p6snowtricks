var scrollButton = document.getElementsByClassName('scroll-button');
var arrow = document.getElementsByClassName('bi-arrow-up');
console.log(arrow);
window.addEventListener('scroll', () => {
    console.log(window.scrollY);
    if (window.scrollY >= 2100) {

        arrow[0].style.visibility = 'visible';
        scrollButton[0].style.visibility = 'visible';

    }
    else {
        arrow[0].style.visibility = 'hidden';
        scrollButton[0].style.visibility = 'hidden';
    }
});