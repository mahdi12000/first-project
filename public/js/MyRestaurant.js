window.addEventListener('DOMContentLoaded', function () {
    /*display file input of main image */
    var main_image = document.querySelector('.Restaurant-image');
    var fileInput = document.querySelector('.fileInput');
    main_image.addEventListener('click', function () {
        fileInput.click();
    });

    fileInput.addEventListener('change', function () {
        var form = this.closest('form');
        form.submit();
    });
    /*verify password lenght and identification */
    var password = document.querySelector('input[name="password"]');
    var confirmPassword = document.querySelector('input[name="confirm_password"]');
    var submit = document.querySelector('.submit');

    submit.addEventListener('click', function (event) {
        var password_lenght = password.value.length;
        if (password.value !== confirmPassword.value) {
            alert('Passwords do not match. Please make sure both passwords are identical.');
            event.preventDefault();
        }
        else if (password_lenght < 8) {
            alert('The password must be at least 8 characters.');
            event.preventDefault();
        }

    });


});