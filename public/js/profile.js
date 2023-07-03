window.addEventListener('DOMContentLoaded', function () {
    var cancel_button = document.getElementById('cancel');
    var delete_div = document.querySelector('.delete-account');
    var delete_button1 = document.querySelector('#delete-Button1');
    var delete_button2 = document.querySelector('#delete-Button2');
    var password_confirmation = document.querySelector('#password_confirmation');
    var form = document.querySelector('.form');
    delete_button1.addEventListener('click', function () {
        delete_div.style.display = 'block';
    });

    cancel_button.addEventListener('click', function () {
        delete_div.style.display = 'none';
    });

    delete_button2.addEventListener('click', function (e) {
        var length = password_confirmation.value.length;
        if (length == 0) {
            alert('please enter your password');
        }
        else if (length < 8) {
            alert('The password must be at least 8 characters.');
        }
        else {
            form.submit();
        }
    });

    // delete_button2.addEventListener('click', function (e) {
    //     var xhr = new XMLHttpRequest();
    //     xhr.open('post', '/Delete_Account', true);
    //     xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
    //     xhr.onload = function () {
    //         alert(xhr.status);
    //         if (xhr.status >= 200 && xhr.status < 300 && xhr.readyState == 4) {
    //             // var reponse = JSON.parse(xhr.responseText);
    //             // alert(response.data);
    //             alert('nice');
    //         }
    //         else alert('erreur dans la requete');
    //     }
    //     xhr.send();
    // });

    /*delete_button2.addEventListener('click', function (e) {
        var password_confirmation = document.getElementById('password_confirmation').value;
        fetch('/Delete_Account', {
            method: 'get',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ password_confirmation: password_confirmation })
        })
            .then(response => {
                if (response.ok) {
                    return response.json();
                } else {
                    throw new Error('Erreur dans la requête');
                }
            })
            .then(data => {
                alert(data.data);
            })
            .catch(error => {
                alert(error.message);
            });
    });*/

    // ---------------------------profil div----------------------------------
    var counter = 0;
    const profil = document.querySelector('#profil');
    const account = document.querySelector('#account img');
    const masquer = document.querySelector('#masquer');
    account.addEventListener('click', function () {
        profil.style.display = "inline-block";
        // main.classList.add('blur');
        // footer.classList.add('blur');
        // header.classList.add('blur');
    });

    masquer.addEventListener('click', function () {
        profil.style.display = "none";
    });
});