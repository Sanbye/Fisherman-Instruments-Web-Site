const textSections = document.querySelectorAll('.text_section');

textSections.forEach((section) => {

    let imgSection = document.querySelector('.text_section .main_img');

    if(imgSection){
        let imgHeight = imgSection.offsetHeight;
        section.style.minHeight = `${imgHeight}px`;
    }

});
