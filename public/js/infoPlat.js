addEventListener('load', function () {
    const account = document.querySelector('#account img');
    const profil = document.querySelector('#profil');
    const masquer = document.querySelector('#masquer');
    const footer = document.querySelector('footer');
    const main = document.querySelector('main');
    const header = document.querySelector('header');
    account.addEventListener('click', function () {
        profil.style.display = "inline-block";
        // alert(test);
        //  alert(hours);
        // profil.style="position:fixed"
        // main.classList.add('blur');
        // footer.classList.add('blur');
        // header.classList.add('blur');
    });

    masquer.addEventListener('click', function () {
        profil.style.display = "none";
    });

    main.addEventListener('click', function () {
        profil.style.display = "none";
    });

    footer.addEventListener('click', function () {
        profil.style.display = "none";
    });

    document.getElementById('reservationForm').addEventListener('submit', function (event) {
        var selectedDate = new Date(document.getElementById('date').value);
        var currentDate = new Date();
        var selectedTime = document.getElementById('time').value;
        var places = document.getElementById('places').value;
        // we verifie null values here
        var field1 = document.getElementById('places').value.trim();
        var field2 = document.getElementById('date').value.trim();
        var field3 = document.getElementById('time').value.trim();

        if (field1 == '' && field2 == '' && field3 == '') {
            alert('enter data!!');
            event.preventDefault();
            return;
        }
        //selected date
        var year = selectedDate.getFullYear();
        var month = selectedDate.getMonth() + 1;
        var day = selectedDate.getDate();
        //current date
        var cuurrentyear = currentDate.getFullYear();
        var currentmonth = currentDate.getMonth() + 1;
        var currentday = currentDate.getDate();
        if (year < cuurrentyear) {
            alert("The chosen 1 date must be greater than or equal to the current date.");
            event.preventDefault(); // Cancel form submission
            return;
        }
        else if (month < currentmonth && year == cuurrentyear) {
            alert("The chosen 2 date must be greater than or equal to the current date.");
            event.preventDefault(); // Cancel form submission
            return;
        }
        else if (day < currentday && currentmonth == month) {
            alert("The chosen 3 date must be greater than or equal to the current date.");
            event.preventDefault(); // Cancel form submission
            return;
        }

        if (places <= 0) {
            alert('invalid number of places');
            event.preventDefault();  //Cancel form submission
            return;
        }

        if (selectedTime.getHours() < currentDate.getHours() && day == currentday && month == currentmonth && year != cuurrentyear) {
            alert('invalid time 1');
            event.preventDefault();  //Cancel form submission
            return;
        }
        else if (selectedDate.getHours() == currentDate.getHours() && day == currentday && month == currentmonth && year == cuurrentyear) {
            if (selectedDate.getMinutes() < currentDate.getMinutes()) {
                alert('invalid time 2');
                event.preventDefault();  //Cancel form submission
                return;
            }
        }


        if (selectedDate.getTime() === currentDate.getTime()) {
            var currentTime = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

            if (selectedTime.localeCompare(currentTime) < 0) {
                alert("The chosen time must be greater than or equal to the current time.");
                event.preventDefault(); // Cancel form submission
                return;
            }
        }
        const modifie_btn = document.querySelectorAll('.modifie');
        const comments = document.querySelectorAll('.comments');
        modifie_btn.forEach((button) => {
            button.addEventListener('click', function () {
                alert('hello mahdi');
                var review_id = this.parentNode.getAttribute('review_id');
                var modifie_id = document.querySelector(`div[modifie_id="${review_id}"]`);
                // alert(review_id);
                alert(modifie_id);
            });
        });

    });
});