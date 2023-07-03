<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/profile.css">
    <script src="js/profile.js"></script>
    <title>platter informations</title>
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

        <a href="{{ route('myBookings') }}">
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
        <div class="profile-div">
            <h3>Profile Information</h3>
            <p>Update your account's profile information and email address.</p>
        </div>
        <div class="profile-data">
            <form action="{{route('updateProfile')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div>
                    <img src="{{$userinfo->pictureLink}}" alt="photo" id="previewImage">
                </div><br>
                <input type="file" name="image" id="imageInput" required><br>

                <label for="name"> Name</label><br>
                <input type="text" name="name" id="name" class="input" value="{{$userinfo->name}}" required><br>

                <label for="email">Email</label><br>
                <input type="email" name="email" id="email" value="{{$userinfo->email}}" class="input" required><br>

                <label for="country">Country</label><br>
                <input type="text" name="country" id="country" value="{{$userinfo->country}}" class="input" required><br>

                <label for="city">city</label><br>
                <input type="text" name="city" id="city" value="{{$userinfo->city}}" class="input" required><br>

                <label for="neighborhood">Neighborhood</label><br>
                <input type="text" name="neighborhood" id="neighborhood" value="{{$userinfo->neighborhood}}" class="input" required><br>

                <label for="building">Building</label><br>
                <input type="text" name="building" id="building" value="{{$userinfo->building}}" class="input" required><br>

                <label for="apartment">Apartment</label><br>
                <input type="text" name="apartment" id="apartment" value="{{$userinfo->apartment}}" class="input" required><br>

                <label for="other">Other Specific</label><br>
                <input type="text" name="other" id="other" value="{{$userinfo->other_specif}}" class="input"><br>
                <button type="submit">Update</button>
            </form>
        </div>
        <div class="profile-div" id="password-div">
            <h3>Update Password</h3>
            <p>Ensure your account is using a long, random password to stay secure.</p>
        </div>
        <div class="profile-data" id="update-password">
            <form action="{{route('updatePassword')}}" method="post">
                @csrf
                <label for="current-password">Current Password</label><br>
                <input type="password" name="current_password" id="current-password" class="input" required><br>

                <label for="new-password">New Password</label><br>
                <input type="password" name="new_password" id="new-password" class="input" required><br>

                <label for="confirm-password">Confirm Password</label><br>
                <input type="password" name="confirm_password" id="confirm-password" class="input" required><br>
                <button type="submit"> save</button>
                @if(session('message'))
                <p class="message {{ session('message') === 'updated successfully.' ? 'success' : 'error'  }}">{{ session('message') }}</p>
                @endif
            </form>
        </div>
         <div id="myPoints-div" class="profile-div">
            <h3>here you can show your coins</h3>
        </div> 
        <div id="myPoints" class="profile-data">
            <h3>the number of coins you have is:{{$userinfo->points}}</h3>
        </div> 
        <div class="profile-div" id="delete-div">
            <h3>Delete Account</h3>
            <p>Permanently delete your account.</p>
        </div>
        <div class="profile-data" id="delete">
            <p>
                Once your account is deleted, all of its resources and
                data will be permanently deleted. Before deleting your
                account, please download any data or information that
                you wish to retain.
            </p>
            <button type="button" id="delete-Button1">Delete Account</button>
            @if(isset($message))
            <p class="error">{{ $message}}</p>
            @endif
        </div>
        <div class="delete-account">
            <h3>Delete Account</h3>
            <p>
                Are you sure you want to delete your account? Once your
                account is deleted, all of its resources and data will be
                permanently deleted. Please enter your password to confirm
                you would like to permanently delete your account.
            </p>
            <form action="{{route('delete_account')}}" method="post" class="form">
                @csrf
                <input type="password" name="password_confirmation" id="password_confirmation" class="input" placeholder="password"><br>
                <button type="button" id="cancel">cancel</button>
                <button type="button" id="delete-Button2">Delete Account</button>
            </form>
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