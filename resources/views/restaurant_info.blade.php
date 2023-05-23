<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="js/Restaurant_info.js"></script>
    <link rel="stylesheet" href="css/Restaurant_info.css">
    <title>restaurant info</title>
</head>

<body>
    <header>
        @if (Route::has('login'))
        <div id="header">
            @auth
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
            @if(auth()->check())
            <a href="http://127.0.0.1:8000/dashboard"><img src="images/restaurantlogo2.jpeg" alt="logo" /></a>
            @else
            <a href="http://127.0.0.1:8000"><img src="images/restaurantlogo2.jpeg" alt="logo" /></a>
            @endif
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
        <div id="grand_image">
            <img src="images/R4.jpg" alt="main Restaurant image">
        </div>
        <h1 id="ourMenu">our Menu</h1>
        <!-- <div id="background">
            <img src="images/back8.jpeg" alt="back8">
        </div> -->
        <div id="grand_div">
            <div id="image_part">
                <img src="images/back5.jpg" alt="image">
                <img src="images/jus2.jpg" alt="jus" id="jus">
            </div>
            @foreach($menus as $menu)
            <?php $br++; ?>
            <a href="{{route('infoplat')}}?menu_id={{$menu->id}}">
                <div class="menu">
                    <div class="div_img">
                        <img src="{{$menu->main_image}}" alt="image">
                    </div>
                    <div class="description">
                        <p class="platter">platter: {{$menu->plat}}</p>
                        <p class="price">price: {{$menu->price}} DH</p>
                        <p class="Description">description: {{$menu->description}}</p>
                    </div>
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