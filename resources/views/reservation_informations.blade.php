<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/reservationinformation.css">
    <script src="js/reservationinformation.js"></script>
    <title>you reservation</title>
</head>

<body>
    <header>
        @if (Route::has('login'))
        <div id="header">
            @auth <!-- if the user is authentified -->
            <div id="account">
                <img src="{{$userinfo->pictureLink}}" alt="picture">
                <p>{{$userinfo->name}}</p>
            </div>
            @else
            <a href="{{ route('login') }}"><button value="log in" id="login">Log in</button></a>
            @if (Route::has('register'))
            <a href="{{ route('register') }}"><button value="sign up" id="sign">sign up</button></a>
            @endif
            @endauth
            @endif

            <a href="https://www.google.com/" id="register">Register My Restaurant</a>
            <a href="http://127.0.0.1:8000/dashboard"><img src="images/restaurantlogo2.jpeg" alt="logo" /></a>
        </div>
    </header>
    <!-- start here -->
    @auth
    <div id="profil">
        <button id="masquer">x</button>
        <div id="imgprofil">
            <img src="{{$userinfo->pictureLink}}" alt="profil">
        </div>
        <h3 id="username">{{$userinfo->name}}</h3>

        <a href="{{ route('profile') }}">
            <div id="infodiv">
                <img src="images/account.jpeg" alt="image">
                <p>My personnal informations</p>
            </div>
        </a>

        <a href="{{route('myBookings')}}">
            <div id="bookings">
                <img src="images/book.jpeg" alt="image">
                <p>My bookings</p>
            </div>
        </a>

        <a href="{{route('my reviews')}}">
            <div id="reviews">
                <img src="images/message.jpeg" alt="image">
                <p>My reviews</p>
            </div>
        </a>

        <a href="{{route('myOrders')}}">
            <div id="orders">
                <img src="images/orders2.jpeg" alt="image">
                <p>My orders</p>
            </div>
        </a>

        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <div id="log_out">
                <img src="images/logout1.jpeg" alt="image">
                <p>Log out</p>
            </div>
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>

    </div>
    @endauth
    <!-- end here -->
    <main>
        @if($disponible==true)
        <h1 id="successfully">reserved successfully</h1>br
        <h1 id="informations">your reservation informations:</h1><br>
        <div id="fiche">
            <h2 id="welcome">welcome to {{$Restaurant_info->name}} Restaurant</h2>
            <p id="label1">Restaurant: {{$Restaurant_info->name}}</p><br>
            <p id="label2">platter: {{$menu_info->plat}}</p>
            <p id="label3">time: {{$time}}</p><br>
            <p id="label4">date: {{$date}}</p><br>
            <p id="label5">guests: {{$nbrPlace}}</p>
            <p id="label6">price: {{$menu_info->price}} DH</p>
            <!-- <button type="button" id="home"> back to home</button> -->
        </div>
        @else
        <div id="erreur">
            <h2 id="impossible">the reservation at this time is <span>not available </span>try another time</h2>
            <a href="{{route('infoplat')}}?menu_id={{$menu_info->id}}">try another time</a>
        </div>
        @endif
    </main>
    <footer>
        <a href="#">
            <h3>about us</h3>
        </a>
        <a href="#">
            <h3>contact us</h3>
        </a>
        <h3>@2023 FindRestaurant.com All rights Reserved</h3>
    </footer>
</body>

</html>