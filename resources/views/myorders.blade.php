<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/myorders.css">
    <script src="js/myorders.js"></script>
    <title>my orders</title>
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

            <a href="{{route('registration')}}" id="register">Register My Restaurant</a>
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
        <table class="styled-table">
            <tr>
                <th>Restaurant</th>
                <th>menu</th>
                <th>city</th>
                <th>neighborhood</th>
                <th>building</th>
                <th>apartment</th>
                <th>date</th>
                <th>total</th>
                <th>total by coins</th>
                <th>livred</th>
                <th>actions</th>
            </tr>
            @foreach($myorders as $myorder)
            <tr>
                <td>{{$myorder->name}}</td>
                <td>{{$myorder->plat}}</td>
                <td>{{$myorder->city}}</td>
                <td>{{$myorder->neighborhood}}</td>
                <td>{{$myorder->building}}</td>
                <td>{{$myorder->apartment}}</td>
                <td>{{$myorder->date}}</td>
                <td>{{$myorder->total}} {{$myorder->currency}}</td>
                <td>{{$myorder->total_by_coins}} coin</td>
                <td>@if($myorder->livred==1)livred @else not livred @endif</td>
                <td>
                    <form action="{{ route('order.delete')}}?order_id={{$myorder->id}}" method="POST" class="inline-form">
                        @csrf
                        <button type="submit" class="btn-delete">Delete</button>
                    </form>
                    <a href="{{ route('order.editPage')}}?order_id={{$myorder->id}}" class="btn-edit">Edit</a>
                </td>
            </tr>
            @endforeach
        </table>
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