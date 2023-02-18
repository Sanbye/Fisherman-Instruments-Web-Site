$(document).ready(function(){
    $('.slider').slick({
        dots: true,

    });
});

function resize(imageId){
    let img = document.getElementById(imageId);
    let imgClone = img.cloneNode(true);
    imgClone.setAttribute('onclick','');

    let resizedImg = document.createElement('div');
    resizedImg.classList.add("img_overlay");
    resizedImg.style.display= 'flex';
    resizedImg.style.justifyContent = 'center';
    resizedImg.style.alignItems = 'center';
    resizedImg.setAttribute('onclick',`(() => { $(".img_overlay").remove(); })()`);
    resizedImg.appendChild(imgClone);

    document.body.appendChild(resizedImg);
}