<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/MyRestaurant.css">
    <script src="../js/MyRestaurant.js"></script>
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
        <div class="Restaurant-image">
            <img src="{{asset($restaurant->main_image)}}" alt="image">
            <form action="{{route('Restaurant.main_image')}}" enctype="multipart/form-data" method="post">
                @csrf
                <input type="file" name="image" class="fileInput" style="display: none;">
            </form>
        </div>
        <div class="informations-div">
            <form action="{{route('Restaurant.update')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="img">
                    <img src="{{asset($restaurant->profile)}}" alt="img">
                    <input type="file" name="owner_image" required>
                </div>

                <label for="owner">owner</label>
                <input type="text" name="owner" value="{{$restaurant->owner}}" required>

                <label for="restaurant_name">Restaurant Name</label>
                <input type="text" name="restaurant_name" value="{{$restaurant->name}}" id="restaurant_name" required>

                <label for="email">Email</label>
                <input type="email" name="email" value="{{$restaurant->email}}" id="email" required>

                <label for="password">Password</label>
                <input type="password" name="password" class="password" required>

                <label for="confirm_password">Confirm Password</label>
                <input type="password" name="confirm_password" class="confirm_password" required>

                <label for="number_phone">Number Phone</label>
                <input type="number" name="number_phone" value="{{$restaurant->numberPhone}}" id="number_phone" required>

                <label for="presentation">Restaurant Presentation</label>
                <input type="text" name="presentation" value="{{$restaurant->small_Presentation}}" id="presentation" required>

                <label for="opening_time">Opening Time</label>
                <input type="time" name="opening_time" value="{{$restaurant->timeOpen}}" id="opening_time" required>

                <label for="closing_time">Closing Time</label>
                <input type="time" name="closing_time" value="{{$restaurant->timeClose}}" id="closing_time" required>

                <label for="country">Country</label>
                <input type="text" name="country" value="{{$restaurant->country}}" id="country" required>

                <label for="city">City</label>
                <input type="text" name="city" value="{{$restaurant->city}}" id="city" required>

                <label for="neighborhood">Neighborhood</label>
                <input type="text" name="neighborhood" value="{{$restaurant->neighborhood}}" id="neighborhood" required>

                <label for="Currency">Currency:</label><br>
                <input type="text" name="currency" list="suggestions" id="Currency" value="{{$restaurant->currency}}" required><br>
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

                <div style="display: inline-block;">
                    <label>I accept coins:</label>
                    <label for="Coins1" id="yes" >yes</label>
                    <input type="radio" id="Coins1" value="yes" name="coins" @if($restaurant->coins==true)checked @endif>
                    <label for="Coins2" id="no" >no</label>
                    <input type="radio" name="coins" id="Coins2" value="no" @if($restaurant->coins==false)checked @endif>
                </div>


                <label for="other">Other</label>
                <input type="text" name="other" value="{{$restaurant->other}}" id="other">

                @if(session('message'))
                <p class="message {{ session('message') === 'updated successfully.' ? 'success' : (session('message') === 'The password must be at least 8 characters.' ? 'error' : 'another-case') }}">{{ session('message') }}</p>
                @endif

                <button type="submit" class="submit">Update</button>
            </form>
        </div>
    </main>
</body>

</html>