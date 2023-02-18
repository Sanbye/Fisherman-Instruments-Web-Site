function newSection(){

    const sectionForm = document.querySelector('.new_section');
    const ajouterBouton = document.querySelector('#ajouterButton');

    ajouterBouton.style.display = 'none';
    sectionForm.classList.add('showForm');
}

function annulerNewSection(){
    const sectionForm = document.querySelector('.new_section');
    const ajouterBouton = document.querySelector('#ajouterButton');

    ajouterBouton.style.display = "initial";
    sectionForm.classList.remove('showForm');

}
