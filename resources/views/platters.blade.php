<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/platters.css">
    <script src="js/platters.js"></script>
    <title>Restaurants</title>
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
            <a href="http://127.0.0.1:8000/welcome"><img src="images/restaurantlogo2.jpeg" alt="logo" /></a>
        </div>
    </header>

    <!-- start here -->
    @auth
    <div id="profil">
        <button id="masquer">x</button>
        <div id="imgprofil">
            <img src="{{$userinfo->pictureLink}}" alt="profil">
        </div>
        <div id="Username">
            <h3 id="username">{{$userinfo->name}}</h3>
        </div>
        <a href="{{ route('profile.show') }}">
            <div id="infodiv">
                <img src="images/account.jpeg" alt="image">
                <p>My personnal informations</p>
            </div>
        </a>

        <a href="#">
            <div id="bookings">
                <img src="images/book.jpeg" alt="image">
                <p>My bookings</p>
            </div>
        </a>

        <a href="#">
            <div id="reviews">
                <img src="images/message.jpeg" alt="image">
                <p>My reviews</p>
            </div>
        </a>

        <a href="#">
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
        <div id="offers">
            @foreach($platters as $platter)
            @if($platter->coins==1)
            <?php $answer = 'accepted' ?>
            @else
            <?php $answer = 'not accepted' ?>
            @endif
            <a href="{{route('infoplat')}}?menu_id={{$platter->id}}">
                <div class="offre">
                    <div id="imageR">
                        <img class="imageR" src="{{$platter->main_image}}" alt="platter">
                    </div>
                    <h2 class="Restaurant">{{$platter->name}}</h2>
                    <p class="adress">{{$platter->city}}</p>
                    <p class="price">price:{{$platter->price}}</p>
                    <p class="coins">coins: {{$answer}}</p>
                    <p class="open">opening time: {{$platter->timeOpen}}</p>
                    <p class="close">closing time: {{$platter->timeClose}}</p>
                </div>
            </a>
            @endforeach
        </div>
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