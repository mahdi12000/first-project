<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/orders.css">
    <script src="../js/orders.js"></script>
    <title>orders</title>
</head>

<body>
    <header>
        <a href="{{route('Restaurant.dashboard')}}">
            <h2 class="site-name">Findrestaurant</h2>
        </a>
        <div>
            <button class="owner-button">
                <img class="owner-image" src="{{asset($restaurant->profile)}}" alt="Owner Image">
                <span class="owner-name">{{$restaurant->owner}}</span>
                <span class="online-dot"></span>
            </button>
        </div>
    </header>

    <div class="logout" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <p>Log out</p>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
    <div class="sidebar">
        <div class="profile-image">
            <img class="profile-image" src="{{asset($restaurant->profile)}}" alt="Profile Image">
        </div>
        <p class="profile-name">{{$restaurant->owner}}</p>
        <a href="{{route('Restaurant.dashboard')}}">
            <div class="button-container">
                <button class="sidebar-button">Dashboard</button>
                <img src="../images/dashboard5.jpg" alt="image">
            </div>
        </a>
        <a href="{{route('Restaurant.orders')}}">
            <div class="button-container">
                <button class="sidebar-button">Orders</button>
                <img src="../images/dashboard5.jpg" alt="image">
            </div>
        </a>
        <a href="{{route('Restaurant.reservations')}}">
            <div class="button-container">
                <button class="sidebar-button">Reservations</button>
                <img src="../images/dashboard5.jpg" alt="image">
            </div>
        </a>
        <a href="{{route('Restaurant.menus')}}">
            <div class="button-container">
                <button class="sidebar-button">Menus</button>
                <img src="../images/dashboard5.jpg" alt="image">
            </div>
        </a>
        <a href="{{route('Restaurant.feedbacks')}}">
            <div class="button-container">
                <button class="sidebar-button">Feedbacks</button>
                <img src="../images/dashboard5.jpg" alt="image">
            </div>
        </a>
        <a href="{{route('Restaurant.discounts')}}">
            <div class="button-container">
                <button class="sidebar-button">Discounts</button>
                <img src="../images/dashboard5.jpg" alt="image">
            </div>
        </a>
        <a href="{{route('Restaurant.MyRestaurant')}}">
            <div class="button-container">
                <button class="sidebar-button">MyRestaurant</button>
                <img src="../images/dashboard5.jpg" alt="image">
            </div>
        </a>
        <a href="{{route('Restaurant.newMenu')}}">
            <div class="button-container">
                <button class="sidebar-button">addMenu</button>
                <img src="../images/dashboard5.jpg" alt="image">
            </div>
        </a>
        <a href="{{route('Restaurant.tables')}}">
            <div class="button-container">
                <button class="sidebar-button">Restaurant tables</button>
                <img src="../images/dashboard5.jpg" alt="image">
            </div>
        </a>
        <div class="button-container" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <button class="sidebar-button">Logout</button>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>
    <main>
        @if(!$orders->isEmpty())
        <table class="styled-table">
            <tr>
                <th>client</th>
                <th>menu</th>
                <th>quantity</th>
                <th>city</th>
                <th>neighborhood</th>
                <th>building</th>
                <th>apartment</th>
                <th>date</th>
                <th>time</th>
                <th>total</th>
                <th>livred</th>
            </tr>
            @foreach($orders as $order)
            <tr>
                <td>{{$order->user}}</td>
                <td>{{$order->plat}}</td>
                <td>{{$order->quantity}}</td>
                <td>{{$order->city}}</td>
                <td>{{$order->neighborhood}}</td>
                <td>{{$order->building}}</td>
                <td>{{$order->apartment}}</td>
                <td>{{$order->date}}</td>
                <td>{{$order->time}}</td>
                <td>{{$order->total}} {{$order->currency}}</td>
                <td>@if($order->livred==1)livred @else not livred @endif</td>
            </tr>
            @endforeach
        </table>
        @else
        <h3 style="color: blue;" class="no-reservations">There are no reservations so far </h3>
        @endif
    </main>
</body>

</html>