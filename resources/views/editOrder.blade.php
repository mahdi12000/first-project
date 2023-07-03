<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/editOrder.css">
    <script src="js/editOrder.js"></script>
    <title>edit my Order</title>
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
        <div id="div">
            <form action="{{route('order.edit')}}?order_id={{$order_id}}" method="post">
                @csrf
                <label for="city">city</label>
                <input type="text" id="city" name="city" value="{{$order->city}}">
                <label for="neighborhood">neighborhood</label>
                <input type="text" id="neighborhood" name="neighborhood" value="{{$order->neighborhood}}">
                <label for="building">building</label>
                <input type="text" id="building" name="building" value="{{$order->building}}">
                <label for="city">apartment</label>
                <input type="text" id="apartment" name="apartment" value="{{$order->apartment}}">
                <button type="submit">save</button>
            </form>
            @if(session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="error-message">
                {{ session('error') }}
            </div>
            @endif
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