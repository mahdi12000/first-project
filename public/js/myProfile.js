addEventListener('load',function(){
    const account=document.querySelector('#account img');
    const profil=document.querySelector('#profil');
    const masquer=document.querySelector('#masquer');
    const footer=document.querySelector('footer');
    const main=document.querySelector('main');
    const header=document.querySelector('header');
    account.addEventListener('click',function(){
        profil.style.display = "inline-block";
        // main.classList.add('blur');
        // footer.classList.add('blur');
        // header.classList.add('blur');
    });

    masquer.addEventListener('click',function(){
        profil.style.display = "none";
    });

    main.addEventListener('click',function(){
        profil.style.display = "none";
    });

    footer.addEventListener('click',function(){
        profil.style.display = "none";
    });

    // header.addEventListener('click',function(){
    //     profil.style.display = "none";
    // });
});