/*animation show*/

    const observerMain = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {

                if(entry.target.classList.contains('show')){

                    entry.target.style.animation = "show 1.3s 0.3s ease forwards"
                }
            }
        });
    });

    const hiddenElements = document.querySelectorAll('.show');

    hiddenElements.forEach((elements) => {
        observerMain.observe(elements);

    });

/*link from nav*/

    const links = document.querySelectorAll('.nav_link');

    links.forEach((element)=> {
        if(element.href===window.location.href){
            element.classList.add('active_link');
        }
    });

    let open=true;

    function openBurger(){
        const menuBurger = document.querySelector('.header_container');
        const boutonBurger = document.querySelector('.burger')
        const overlay = document.querySelector('.overlay');

        if (open){
            menuBurger.classList.add('open');
            boutonBurger.classList.add('active');
            overlay.classList.add('open');

            open=false;
        }else{
            menuBurger.classList.remove('open');
            boutonBurger.classList.remove('active');
            overlay.classList.remove('open');

            open=true;
        }
    }

/*Gestion flashbag*/

    let flash = document.querySelector('.flash_success');

    if (flash){

        flash.style.animation = "animationFlash 5s cubic-bezier(.88,.12,.31,.86)"

        setTimeout(()=>{
            flash.remove()
        },5500);
    }


