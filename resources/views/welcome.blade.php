<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/accueil.css">
    <script src="js/home.js"></script>
    <title>accueil</title>
</head>

<body>
    <header>
        @if (Route::has('login'))
        <div id="header">
            @auth <!-- if the user is authentified -->
            <div id="account">
                <img src="{{$userinfo[0]->pictureLink}}" alt="picture">
                <p>{{$userinfo[0]->name}}</p>
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
            <img src="{{$userinfo[0]->pictureLink}}" alt="profil">
        </div>
        <h3 id="username">{{$userinfo[0]->name}}</h3>

        <a href="#">
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

        <a href="{{ route('logout') }}">
            <div id="log_out">
                <img src="images/logout1.jpeg" alt="image">
                <a href="#">
                    <p>Log out</p>
                </a>
            </div>
        </a>
    </div>
    @endauth
    <!-- end here -->
    <main>
        <h1>Savor every bite, live every moment</h1>
        <div id="recherche">
            @csrf
            <form action="RestaurantsController.php" method="post">
                @csrf
                <h2>Search All Retarauts</h2>
                <label for="what">what</label><br>
                <div id="container1">
                    <div><img src="images/fourchette.jpeg" alt="icone" id="icone1">/</div>
                    <input type="text" id="what" name="food" placeholder="pizza, ice creme "><br>
                </div>
                <label for="where">where</label><br>
                <div id="container2">
                    <div><img src="images/localisation.jpeg" alt="icone2" id="icone2"></div>
                    <input type="text" id="where" name="place" placeholder="paris, Roma"><br>
                </div>
                <button value="search" id="search" type="submit">SEARCH</button>
            </form>
        </div>
        <h1 id="some">some Restaurants</h1>
        @foreach($somerestaurants as $restaurants)
        <?php $id++; ?>
        <div id="R{{$id}}">
            <a href="restaurants.php?id_restaurant={{$restaurants->id}}"><img src="{{$restaurants->linkImage}}" alt="R1">
                <h3>{{$restaurants->name}} Restaurant</h3>
                <p class="para">
                    {{$restaurants->small_Presentation}}
                </p>
            </a>
        </div>
        @endforeach
        <h1 id="suggetion">restaurants chosen for you</h1>
        @foreach($chosenforyou as $restaurants)
        <?php $id++ ?>
        <div id="R{{$id}}">
            <a href="restaurants.php?id_restaurant={{$restaurants->id}}"> <img src="{{$restaurants->linkImage}}" alt="R4">
                <h3>{{$restaurants->name}}</h3>
            </a>
            <p class="para">
                {{$restaurants->small_Presentation}}
            </p>
        </div>
        @endforeach
        <!-- <div id="R5">
            <a href="restaurants.php?id_restaurant='1'"> <img src="images/R5.jpg" alt="R4">
                <h3>best Restaurant</h3>
            </a>
            <p class="para">
                A cozy and rustic restaurant with a charming atmosphere.
            </p>
        </div>
        <div id="R6">
            <a href="restaurants.php?id_restaurant='1'"> <img src="images/R6.jpg" alt="R4">
                <h3>new Restaurant</h3>
            </a>
            <p class="para">
                A cozy, family-friendly restaurant serving up delicious, homemade Italian cuisine.
            </p>
            <div></div>
        </div> -->
        <h1 id="getcoins">where can I get coins</h1>
        @foreach($getCoins as $restaurants)
        <?php $id++ ?>
        <div id="R{{$id}}">
            <a href="restaurants.php?id_restaurant={{$restaurants->id}}"><img src="{{$restaurants->linkImage}}" alt="R4">
                <h3>{{$restaurants->name}}</h3>
            </a>
            <p class="para">
                {{$restaurants->small_Presentation}}
            </p>
        </div>
        @endforeach
        <!-- <div id="R8">
            <a href="restaurants.php?id_restaurant='1'"> <img src="images/R6.jpg" alt="R4">
                <h3>new Restaurant</h3>
            </a>
            <p class="para">
                A cozy, family-friendly restaurant serving up delicious, homemade Italian cuisine.
            </p>
        </div>

        <div id="R9">
            <a href="restaurants.php?id_restaurant='1'"> <img src="images/R6.jpg" alt="R4">
                <h3>new Restaurant</h3>
            </a>
            <p class="para">
                A cozy, family-friendly restaurant serving up delicious, homemade Italian cuisine.
            </p>
        </div> -->
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