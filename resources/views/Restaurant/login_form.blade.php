<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/login_form.css">
    <script src="../js/login_form.js"></script>
    <title>login</title>
</head>

<body>
    @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    <form action="{{route('loginAccount')}}" method="post">
        @csrf
        <label for="email">email</label><br>
        <input type="email" name="email"><br>
        <label for="password">password</label><br>
        <input type="password" name="password"><br>
        <button type="submit">login</button>
    </form>
    <a href="{{route('registration')}}">register now</a>
    @if(session('bool') === false)
    <div class="error-message">
        invalid username or password.
    </div>
    @endif
</body>

</html>