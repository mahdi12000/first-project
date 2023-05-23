<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    @if(session('bool'))
    <h1>La variable bool est vraie.</h1><br>
    @else
    <h1>La variable bool est fausse.</h1><br>
    @endif

    <form action="{{route('Restaurant.login')}}" method="get">
        <label for="email">email</label><br>
        <input type="email" name="email"><br>
        <label for="password">password</label><br>
        <input type="text" name="password"><br>
        <button type="submit">login</button>
    </form>
</body>

</html>