<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/registration.css">
    <script src="../js/registration.js"></script>
    <title>register Restaurant</title>
</head>

<body>
    <div id="register">
        <form action="{{route('registerRestaurant')}}" method="post">
            @csrf
            <label for="name" id="name">name</label><br>
            <input type="text" id="Name" name="name"><br>

            @if(session('message'))
            <p class="error-message">{{ session('message') }}</p>
            @endif
            <label for="email" id="email">email</label><br>
            <input type="email" id="Email" name="email"><br>

            <label for="password" id="password">password</label><br>
            <input type="password" id="Password" name="password"><br>

            <label for="Confirmpassword" id="confirmpassword">confirm password</label><br>
            <input type="password" id="Confirmpassword" name="password"><br>

            <label for="Number">number phone</label><br>
            <input type="text" id="Number" name="numberphone"><br>

            <label for="Openning" id="openning">openning time</label><br>
            <input type="time" id="openning" name="openning_time"><br>

            <label for="Closing" id="closing">closing time</label><br>
            <input type="time" id="Closing" name="closing_time"><br>

            <label for="Description" id="description">description</label><br>
            <input type="text" id="Description" name="description"><br>

            <label for="Country" id="country">country</label><br>
            <input type="text" id="Country" name="country"><br>

            <label for="Currency">Currency:</label><br>
            <input type="text" name="currency" list="suggestions" id="Currency"><br>
            <datalist id="suggestions">
                <option value="USD"></option>
                <option value="EUR"></option>
                <option value="GBP"></option>
                <option value="CAD"></option>
                <option value="JPY"></option>
                <option value="AUD"></option>
                <option value="CHF"></option>
                <option value="CNY"></option>
                <option value="INR"></option>
                <option value="RUB"></option>
                <option value="BRL"></option>
                <option value="SEK"></option>
                <option value="NZD"></option>
                <option value="KRW"></option>
                <option value="ZAR"></option>
                <option value="NOK"></option>
                <option value="MXN"></option>
                <option value="TRY"></option>
                <option value="PLN"></option>
                <option value="SGD"></option>
                <option value="HKD"></option>
                <option value="DKK"></option>
                <option value="HUF"></option>
                <option value="THB"></option>
                <option value="IDR"></option>
            </datalist>

            <label for="City" id="city">city</label><br>
            <input type="text" id="City" name="city"><br>

            <label for="Neighborhood" id="neighborhood">neighborhood</label><br>
            <input type="text" id="Neighborhood" name="neighborhood"><br>

            <label for="Other" id="other">other</label><br>
            <input type="text" id="Other" name="other" placeholder="other adresse specifications(not obligatory)"><br>

            <label>do you accept coins</label><br>
            <label for="Coins1">yes</label>
            <input type="radio" id="Coins1" value="yes" name="coins">
            <label for="Coins2">no</label>
            <input type="radio" name="coins" id="Coins2" value="no">

            <button type="submit" id="submit">register</button>
            <a href="{{route('Restaurant.login_form')}}">already registred?</a>
        </form>
    </div>
</body>

</html>