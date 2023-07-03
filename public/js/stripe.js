addEventListener('load', function () {
    // Création de l'élément de carte Stripe
    var stripe = Stripe('pk_test_51NBFneI6sqbUQFo6Yn16m22w5Q0gGwtGk1B3MbJpYvv3Z3DiapuUSUPHimx7l3C3k7wPUmnGOSZEtrcrO5Q5WWKm00BwHywRfX');
    var elements = stripe.elements();
    var cardElement = elements.create('card');

    cardElement.mount('#card-element');

    // Gestion de la soumission du formulaire
    var form = document.getElementById('payment-form');
    form.addEventListener('submit', function (event) {
        event.preventDefault();

        stripe.createToken(cardElement).then(function (result) {
            if (result.error) {
                // Gestion des erreurs de validation de la carte
                var errorElement = document.getElementById('card-errors');
                errorElement.textContent = result.error.message;
            } else {
                // Envoi du token de paiement au serveur
                var tokenInput = document.createElement('input');
                tokenInput.setAttribute('type', 'hidden');
                tokenInput.setAttribute('name', 'stripeToken');
                tokenInput.setAttribute('value', result.token.id);
                form.appendChild(tokenInput);

                // Soumission du formulaire
                form.submit();
            }
        });
    });

// from here
    const account = document.querySelector('#account img');
    const profil = document.querySelector('#profil');
    const masquer = document.querySelector('#masquer');
    const footer = document.querySelector('footer');
    const main = document.querySelector('main');
    const header = document.querySelector('header');
    account.addEventListener('click', function () {
        profil.style.display = "inline-block";
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

    // header.addEventListener('click',function(){
    //     profil.style.display = "none";
    // });
});