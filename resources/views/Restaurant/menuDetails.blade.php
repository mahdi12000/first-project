<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/menuDetails.css">
    <script src="../js/menuDetails.js"></script>
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
        <div class="menu-details">
            <h2>menu:{{$menu->plat}}</h2>
            <p> <span class="Description">description:</span> {{$menu->description}}</p>
            <p><span class="Price">price:</span> {{$menu->price}}{{$menu->currency}}</p>
        </div>

        <div class="menu-images">
            <div class="main">
                <img src="{{asset($menu->main_image)}}" alt="main">
                <div class="edit-main">
                    <button type="button" class="Modifie-main">modifie</button><br>
                    <button type="button" class="delete-main">delete</button><br>
                    <button type="button" class="cancel-main">cancel</button><br>
                </div>
                <div class="deleteOption">
                    <h3>delete it?</h3>
                    <form action="{{route('Restaurant.deleteMain',['menu_id'=>$menu->id])}}" method="post">
                        @csrf
                        <button type="submit" class="deleteMainBtn">delete</button>
                    </form>
                    <button type="button" class="cancelMainBtn">cancel</button>
                </div>
                <div class="modifieMain">
                    <form action="{{route('Restaurant.modifieMain',['menu_id'=>$menu->id])}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <label for="main_image">Choose another image:</label><br>
                        <input type="file" name="main_image">
                        <button type="submit" class="modifie">Modify</button>
                        <button type="button" class="cancelModifie">Cancel</button>
                    </form>
                </div>
            </div>
            <h3>Other images</h3>
            <div class="images-container">
                @foreach($images as $image)
                <div class="delete" image_id="{{$image->id}}">
                    <h3>Delete this image?</h3>
                    <form action="{{route('Restaurant.delete',['image_id'=>$image->id])}}" method="post">
                        @csrf
                        <button type="submit" class="deletBtn" image_id="{{$image->id}}">delete</button>
                    </form>
                    <button type="button" class="cancelBtn" image_id="{{$image->id}}">cancel</button>
                </div>
                <img src="{{ asset($image->link) }}" alt="Image" image_id="{{$image->id}}" class="img">
                @endforeach
            </div>
        </div>
        <div class="menu-edit">
            <h3>Modifie menu informations</h3>
            <form action="{{route('Restaurant.update', ['menu_id' => $menu->id])}}" method="POST">
                @csrf
                @method('PUT')
                <label for="menu">Name of the Menu:</label><br>
                <input type="text" name="menu" value="{{ $menu->plat }}"><br>

                <label for="description">Menu description:</label><br>
                <textarea name="description" rows="8">{{ $menu->description }}</textarea><br>

                <label for="price">Menu price:</label><br>
                <input type="number" name="price" value="{{ $menu->price }}"><br>

                @if($restaurant->coins==true)
                <label for="priceCoins">Price by coins:</label><br>
                <input type="number" name="priceCoins" value="{{$menu->priceCoins}}"><br>

                <label for="earned">points earned:</label><br>
                <input type="number" name="earned" value="{{$menu->pointsEarned}}" placeholder="how many points will the customer earn"><br>
                @endif

                <button type="submit">Modifie</button>
                @if (session('message'))
                <div class="payment-message {{ session('message') === 'Payment failed' ? 'error-message' : 'success-message' }}">
                    {{ session('message') }}
                </div>
                @endif
            </form>
        </div>

        <div class="add-images">
            <h3>add new images</h3>
            <form class="form" action="{{ route('Restaurant.addImages',['menu_id' => $menu->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="images[]" multiple class="files"><br>
                <button type="submit" class="add">add</button>
            </form>
        </div>
    </main>
</body>

</html>