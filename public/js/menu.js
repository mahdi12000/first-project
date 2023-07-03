window.addEventListener('DOMContentLoaded', function () {
    var counter = 0;
    const owner_button = document.querySelector('.owner-button');
    const logout = document.querySelector('.logout');
    owner_button.addEventListener('click', function () {
        counter++;
        if (counter % 2 == 0) {
            logout.style.display = 'none';
        }
        else {
            logout.style.display = 'inline-block';
        }
    }); 
    //manage clicks on menus
    const menu=document.querySelectorAll('td');
    menu.forEach((td)=>{
        td.addEventListener('click',function(){
            var menu=td.getAttribute('menu');
            // alert('la valeur de menu est:',menu);
        });
    });

});