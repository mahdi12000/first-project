window.addEventListener('DOMContentLoaded', function () {
    // var quantityInput = document.getElementById('quantity');
    // var cityInput = document.getElementById('City');
    // var neighborhoodInput = document.getElementById('Neighborhood');
    // var buildingInput = document.getElementById('Building');
    // var apartmentInput = document.getElementById('Apartment');
    // var otherInput = document.getElementById('Other');

    // var hiddenQuantityInput = document.getElementById('hidden-quantity');
    // var hiddenCityInput = document.getElementById('hidden-City');
    // var hiddenNeighborhoodInput = document.getElementById('hidden-Neighborhood');
    // var hiddenBuildingInput = document.getElementById('hidden-Building');
    // var hiddenApartmentInput = document.getElementById('hidden-Apartment');
    // var hiddenOtherInput = document.getElementById('hidden-Other');

    var inputs = document.querySelectorAll('input');

    const modifie_btn = document.querySelectorAll('.modifie');
    const comments = document.querySelectorAll('.comments');
    modifie_btn.forEach((button) => {
        button.addEventListener('click', function () {
            var review_id = this.parentNode.getAttribute('review_id');
            var modifie_id = document.querySelector(`div[modifie_id="${review_id}"]`);
            modifie_id.style.display = 'block';
            var cancel_id = modifie_id.querySelector('button.cancelModifie');
            cancel_id.addEventListener('click', function () {
                modifie_id.style.display = 'none';
            });
        });
    });

    const account = document.querySelector('#account img');
    const profil = document.querySelector('#profil');
    const masquer = document.querySelector('#masquer');
    const footer = document.querySelector('footer');
    const main = document.querySelector('main');
    const header = document.querySelector('header');
    account.addEventListener('click', function () {
        profil.style.display = "inline-block";
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
    });
    var button = document.querySelector('#pay-coins');
    button.addEventListener('click', function (event) {
        var quantityInput = document.getElementById('quantity');
        var cityInput = document.getElementById('City');
        var neighborhoodInput = document.getElementById('Neighborhood');
        var buildingInput = document.getElementById('Building');
        var apartmentInput = document.getElementById('Apartment');
        var otherInput = document.getElementById('Other');

        var hiddenQuantityInput = document.getElementById('hidden-quantity');
        var hiddenCityInput = document.getElementById('hidden-City');
        var hiddenNeighborhoodInput = document.getElementById('hidden-Neighborhood');
        var hiddenBuildingInput = document.getElementById('hidden-Building');
        var hiddenApartmentInput = document.getElementById('hidden-Apartment');
        var hiddenOtherInput = document.getElementById('hidden-Other');

        hiddenQuantityInput.value = quantityInput.value;
        hiddenCityInput.value = cityInput.value;
        hiddenNeighborhoodInput.value = neighborhoodInput.value;
        hiddenBuildingInput.value = buildingInput.value;
        hiddenApartmentInput.value = apartmentInput.value;
        hiddenOtherInput.value = otherInput.value;

        //-----------------------------------------------------------
        var quantityInput = document.getElementById('quantity');
        var quantity = quantityInput.value;

        if (quantity <= 0) {
            alert('invalid quantity');
            event.preventDefault();
            return;
        } else {
            var formulaire = document.querySelector('#hiddenForm');
            formulaire.submit();
        }
    });

    var buttonreserve = document.querySelector('#buttonreserve');
    var form1=document.querySelector('#formulaire');
    buttonreserve.addEventListener('click', function (event) {
        var quantityInput = document.getElementById('quantity');
        var quantity = quantityInput.value;

        if (quantity <= 0) {
            alert('invalid quantity');
            event.preventDefault();
            return;
        }
        else{
            form1.submit();
        }
    });
});