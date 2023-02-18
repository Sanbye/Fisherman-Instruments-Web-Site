/*aperçu des instruments*/

const apercu = document.querySelectorAll('.link_aperçu_instrument .aperçu');
const InstrumentsLink = document.getElementsByClassName('link_aperçu_instrument');

for (i = 0; i < apercu.length; i++) {

    const src = apercu[i].src;
    const img = apercu[i];
    const link = InstrumentsLink[i];

    img.src = src;
    img.classList.add('aperçuInNav');
    link.href = `#card${i + 1}`;

    link.setAttribute("onclick", 'disableObserver()')

}


const observerInstruments = new IntersectionObserver((entries) => {
    entries.forEach((entry) =>{

        let url = window.location.href;
        let links = document.querySelectorAll('.link_aperçu_instrument');

        links.forEach((element) => {

            let imgSelected =element.firstElementChild;

            if (element.href===url) {
                imgSelected.classList.add('inview');
            }else{
                imgSelected.classList.remove('inview');
            }
        });

        if(entry.isIntersecting){

            let id = entry.target.getAttribute('id');

            window.location.replace("#"+id);

        }
    },{threshold: 0.1});
});

const cards = document.querySelectorAll('.card');

cards.forEach((elements) => {
    observerInstruments.observe(elements);
});

function showText(id){

    let card = document.querySelector(`#card${id}`);
    let text = document.querySelector(`#text${id}`);
    let bouton = document.querySelector(`#container${id} .enSavoirPlus`);

    bouton.classList.toggle('active');

    if(window.matchMedia("(min-width: 600px)").matches){

        if(bouton.classList.contains('active')){
            card.parentNode.style.width = "70%";
            card.parentNode.style.left = "5%";
            text.style.visibility = "visible";
            text.style.left = "7%";
            bouton.innerHTML="Retour";


        }else{
            card.parentNode.style.width = "80%";
            card.parentNode.style.left = "10%";
            text.style.visibility = "hidden";
            text.style.left = "10%";
            bouton.innerHTML="En savoir plus";


        }

    }else{
        if(bouton.classList.contains('active')){
            card.parentNode.style.width = "20%";
            card.parentNode.style.left = "-45%";
            text.style.visibility = "visible";
            text.style.width = "80vw";
            text.style.left = "0%";
            bouton.style.transform= "translate(70vw,-18vh)"
            bouton.style.transition = "ease 1s"
            bouton.innerHTML="Retour";


        }else{
            card.parentNode.style.width = "80%";
            card.parentNode.style.left = "10%";
            text.style.visibility = "hidden";
            text.style.left = "10%";
            bouton.style.transform= "translate(0,0)"
            bouton.style.transition = "ease 2.5s"
            bouton.innerHTML="En savoir plus";


        }
    }


};

/*correction du "bug" Observer*/

function disableObserver(){
    cards.forEach((elements) => {
        observerInstruments.unobserve(elements);
    });

    setTimeout(()=>
            cards.forEach((elements) => {
                observerInstruments.observe(elements);
            }),
        600);
}

/* fix comptabilité firefox*/

document.querySelector("body").style.position = "fixed";