var media = document.getElementsByClassName('show-media');
console.log(media);


var w = window.innerWidth;
console.log(w);


if (w < 766) {
    media[0].style.visibility = 'visible';
}
else {
    media[0].style.visibility = 'hidden';
}


