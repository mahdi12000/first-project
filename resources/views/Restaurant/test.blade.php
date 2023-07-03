<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <main>
        <div class="menu-details">
            <h2>menu:{{$menu->plat}}</h2>
            <p>description:{{$menu->description}}</p>
            <p>{{$menu->price}}</p>
        </div>

        <div class="menu-images">
            <h3>Menu images</h3>
            <div class="images-container">
                @foreach($images as $image)
                <img src="{{ asset($image->link) }}" alt="Image">
                @endforeach
            </div>
        </div>

        <div class="menu-edit">
            <h3>Modifie menu informations</h3>
            <form action="{{route('Restaurant.update', ['menu_id' => $menu->id])}}" method="POST">
                @csrf
                @method('PUT')
                <label for="menu">Nom du Menu:</label><br>
                <input type="text" name="menu" value="{{ $menu->name }}"><br>

                <label for="description">Description du Menu:</label><br>
                <textarea name="description">{{ $menu->description }}</textarea><br>

                <label for="price">Prix du Menu:</label><br>
                <input type="number" name="price" value="{{ $menu->price }}"><br>

                <button type="submit">Modifier</button>
                @if (session('message'))
                <div class="payment-message {{ session('message') === 'Payment failed' ? 'error-message' : 'success-message' }}">
                    {{ session('message') }}
                </div>
                @endif
            </form>
        </div>

        <div class="add-images">
            <h3>Ajouter de nouvelles images</h3>
            <form action="{{ route('Restaurant.addImages',['menu_id' => $menu->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="images[]" multiple><br>
                <button type="submit">Ajouter</button>
            </form>
        </div>
    </main>
</body>

</html>