window.addEventListener('load', function () {
    var password = document.getElementById('Password');
    var confirmPassword = document.getElementById('ConfirmPassword');

    document.querySelector('form').addEventListener('submit', function (event) {
        var password = document.getElementById('Password').value;
        var confirmPassword = document.getElementById('Confirmpassword').value;

        if (password !== confirmPassword) {
            event.preventDefault();
            alert('Passwords do not match. Please make sure both passwords are identical.');
        }
        else 
        {
            var inputs = document.querySelectorAll('form input');

            for (var i = 0; i < inputs.length; i++) {
                if (inputs[i].value.trim() === '' && inputs[i].id !== 'Other') {
                    alert('Please fill in all fields.');
                    event.preventDefault();
                    return;
                }
            }
        }
    });
});