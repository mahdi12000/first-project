<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/infoPlat.css">
    <script src="js/infoPlat.js"></script>
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
            <img src="{{$menu->main_image}}" alt="main Restaurant image">
        </div>
        <div id="blockimage">
            <img src="{{$main_menu->main_image}}" alt="principale" id="principale">
            @foreach($imagesMenu as $imagesMenu)
            <?php $id++ ?>
            <img src="{{$imagesMenu->link}}" alt="image{{$id}}" id="img{{$id}}">
            @endforeach
        </div>
        <h3 id="Description">Description</h3>
        <div class="description">
            <p>
                Notre pizza "La Royale" est un véritable délice pour les amateurs de viande. Cette pizza savoureuse est garnie de sauce tomate maison, de mozzarella fondante, de pepperoni, de saucisse italienne, de jambon cuit, de champignons frais, de poivrons verts et rouges, et d'oignons rouges pour une saveur explosive. La croûte est croustillante à l'extérieur et moelleuse à l'intérieur, et est légèrement saupoudrée d'origan pour ajouter une touche d'arôme supplémentaire. Chaque bouchée de cette pizza est un mélange parfait de textures et de saveurs, qui ravira vos papilles gustatives. Commandez dès maintenant pour une expérience culinaire inoubliable !
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Omnis unde fugiat neque commodi, repellendus harum necessitatibus eveniet, assumenda molestiae nemo, rem ullam quasi sapiente iste placeat
            </p>
        </div>
        <div id="table">
            <div id="reservation">
                <h2 id="h2">Make a reservation</h2>
            </div>
            <form action="{{route('confirm')}}?id_menu={{$main_menu->id}}" method="post" id="reservationForm">
                @csrf
                <label for="places" id="numberpaleces">number of places</label><br>
                <input type="number" id="places" name="places">
                <label for="date" id="Date">date</label>
                <input type="date" id="date" name="date">
                <label for="time" id="Time">time</label>
                <input type="time" id="time" name="time">
                <button type="submit" id="buttonBook">Book a Table</button>
            </form>
        </div>
        <div id="Order">
            <form action="" method="post">
                @csrf
                <div id="order">
                    <h2 id="makeorder">Make an Order</h2>
                </div>
                <label for="quantity" id="Quantity">Quantity</label><br>
                <input type="number" id="quantity" name="quantity">
                <label for="card" id="Card">card number</label>
                <input type="text" name="card" id="card">
                <button type="submit" id="buttonreserve">Pay</button>
            </form>
        </div>
        @auth
        <form action="{{route('comment')}}" method="post">
            @csrf
            <div id="mycomment">
                <div id="myimage">
                    <img src="{{$userinfo->pictureLink}}" alt="myimage">
                </div>
                <input type="hidden" name="menu_id" value="{{ $menu_id }}">
                <div id="comment-form">
                    <textarea name="comment" id="comment-input" placeholder="add comment"></textarea>
                    <button type="submit" id="comment-btn">comment</button>
                </div>
            </div>
        </form>
        @endauth
        @foreach($reviews as $review)
        <div class="modifieDiv" modifie_id="{{$review->review_id}}">
            <form action="{{route('modifie')}}" method="post">
                @csrf
                <textarea name="newComment" id="newComment">{{$review->review}}</textarea>
                <input type="hidden" name="comment_id" value="{{$review->review_id}}">
                <button class="save" type="submit">save</button>
            </form>
        </div>

        <div class='comments' review_id="{{$review->review_id}}">
            <div class='imageprofil'>
                <img src="{{$review->pictureLink}}" alt='profil'>
            </div>
            <span class='fullname'>{{$review->name}}</span>
            <span class='datecomment'>{{$review->date}} </span>
            <span class='note'>{{$review->note}}/10</span>
            <p class="avis"> {{$review->review}}</p>
            @auth
            @if($userinfo->id==$review->user_id)
            <button type="button" class="modifie">modifie</button>
            <form action="{{route('delete')}}" method="post">
                @csrf
                <input type="hidden" name="comment_id" value="{{$review->review_id}}">
                <button type="submit" class="delete">delete</button>
            </form>
            @endif
            @endauth
        </div>
        @endforeach
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