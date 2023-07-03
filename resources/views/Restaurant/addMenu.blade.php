<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/addMenu.css">
    <script src="../js/addMenu.js"></script>
    <title>add menu</title>
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
        <div class="main">
            <form action="{{route('Restaurant.addMenu')}}" method="post" enctype="multipart/form-data">
                @csrf
                <label for="main_image">Choose image:</label><br>
                <input type="file" name="main_image" class="main_image">
        </div>
        <div class="menu-edit">
            <h3>menu informations</h3>
            <label for="menu">Name of the Menu:</label><br>
            <input type="text" name="menu"><br>

            <label for="description">Menu description:</label><br>
            <textarea name="description" rows="8"></textarea><br>

            <label for="price">Price of the menu:</label><br>
            <input type="number" name="price"><br>

            @if($restaurant->coins==true)
            <label for="priceCoins">Price by coins:</label><br>
            <input type="number" name="priceCoins"><br>

            <label for="earned">points earned:</label><br>
            <input type="number" name="earned" placeholder="how many points will the customer earn"><br>
            @endif

        </div>

        <div class="add-images">
            <h3>add new images</h3>
            <input type="file" name="images[]" multiple><br>
            <button type="submit" class="add">add</button>
            </form>
            @if (session('message'))
            <div class='success-message'>
                {{ session('message') }}
            </div>
            @endif
        </div>
    </main>
</body>

</html>