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
    const menu = document.querySelectorAll('td');
    menu.forEach((td) => {
        td.addEventListener('click', function () {
            var menu = td.getAttribute('menu');
            // alert('la valeur de menu est:',menu);
        });
    });

    var form=document.querySelector('.form');
    form.addEventListener('submit', function (event) {
        var inputFiles = document.querySelector('.files').files;
        if (inputFiles.length === 0) {
            event.preventDefault(); 
            alert("Please select at least one file.");
        }
    });

    var images = document.querySelectorAll('img');

    images.forEach((img) => {
        img.addEventListener('click', function () {
            var image_id = img.getAttribute('image_id');
            var deletbtn = document.querySelector('.deletBtn[image_id="' + image_id + '"]');
            var cancelBtn = document.querySelector('.cancelBtn[image_id="' + image_id + '"]');
            var divDelete = document.querySelector('.delete[image_id="' + image_id + '"]');
            divDelete.style.display = 'block';

            cancelBtn.addEventListener('click', function () {
                // alert(divDelete);
                divDelete.style.display = 'none';
            });
        });
    });

    var main_image = document.querySelector('.main img');
    var options = document.querySelector('.edit-main');
    var cancelBtn = document.querySelector('.cancel-main');
    // this.alert(cancelBtn);
    var main_counter = 0;
    //part of the options
    main_image.addEventListener('click', function () {
        main_counter++;
        if (main_counter % 2 == 0) {
            options.style.display = 'none';
        }
        else {
            options.style.display = 'block';
        }
    });
    //part of cancel button
    cancelBtn.addEventListener('click', function () {
        options.style.display = 'none';
        main_counter++;
    });
    //modifie button
    var modifieBtn = document.querySelector('.Modifie-main');
    var modifieDiv = document.querySelector('.modifieMain');
    modifieBtn.addEventListener('click', function () {
        modifieDiv.style.display = 'block';
    });

    var cancelModifie = document.querySelector('.cancelModifie');
    cancelModifie.addEventListener('click', function () {
        modifieDiv.style.display = 'none';
    });

    var deleteBtn = document.querySelector('.delete-main');
    var deletediv = document.querySelector('.deleteOption');
    var canceldelete=document.querySelector('.cancelMainBtn');
    var deleteCounter = 0;
    deleteBtn.addEventListener('click', function () {
        deletediv.style.display="block";
    });
    canceldelete.addEventListener('click',function(){
        deletediv.style.display="none";
    });
});
