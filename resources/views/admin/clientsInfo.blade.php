<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="asset(../css/reservation.css)">
    <script src="../js/tables.js"></script>
    <title>admin dashboard</title>
    <style>
        /* header style */
        header {
            display: flex;
            justify-content: space-between;
            background-color: white;
            position: relative;
            bottom: 2mm;
            align-items: center;
            padding: 20px;
            height: 20px;
            width: 34.8cm;
        }

        body {
            background-color: #f1f1f1;
        }

        .site-name {
            font-weight: bold;
            cursor: pointer;
        }

        .owner-button {
            display: flex;
            align-items: center;
            background-color: white;
            border-radius: 2mm;
            border: 0.5mm solid orange;
            cursor: pointer;
        }

        .owner-image {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            margin-right: 5px;
        }

        .owner-name {
            font-weight: bold;
        }

        .online-dot {
            position: relative;
            width: 10px;
            height: 10px;
            right: 1.5cm;
            top: 3mm;
            background: rgb(44, 224, 44);
            border-radius: 50%;
            margin-left: 5px;
        }

        .logout {
            position: relative;
            display: none;
            width: 145px;
            height: 40px;
            border-radius: 2mm;
            border: 0.5mm solid orange;
            background-color: white;
            left: 25.3cm;
            bottom: 4mm;
            cursor: pointer;
        }

        .logout:hover {
            background-color: orange;
        }

        .logout p {
            cursor: pointer;
            padding-left: 10mm;
            padding-bottom: 5mm;
            font-weight: bold;
        }

        /* style of vertical nav*/
        .sidebar {
            width: 200px;
            height: 14cm;
            background: white;
            padding: 20px;
            margin-top: 0px;
            float: left;
        }

        .button-container {
            /* border: 1mm solid red; */
            height: 40px;
        }

        .button-container img {
            width: 25px;
            height: 25px;
            position: relative;
            bottom: 43px;
            left: 90%;
        }

        .profile-image {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: inline-block;
            margin-bottom: 10px;
            margin-left: 30px;
        }

        .profile-name {
            font-weight: bold;
            margin-bottom: 10px;
            margin-left: 45px;
        }

        .sidebar-button {
            width: 180px;
            height: 40px;
            background: #fff;
            border-radius: 2.5mm;
            border: none;
            margin-bottom: 10px;
            padding-right: 100%;
            transition: background 0.3s ease;
        }

        .sidebar-button:hover {
            background-color: orange;
            border-radius: 2.5mm;
        }

        /*orders style*/
        main {
            /* border: 0.5mm solid red; */
            position: relative;
            left: 6.5cm;
            width: 26cm;
            height: auto;
        }

        .styled-table {
            /* top: 3cm; */
            position: absolute;
            width: 25cm;
            border-collapse: collapse;
        }

        .styled-table thead th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .styled-table th,
        .styled-table td {
            padding: 8px;
            border: 1px solid #ddd;
        }

        .styled-table tbody tr:nth-child(even) {
            background-color: #ece6e6;
        }

        .btn-group {
            display: flex;
            gap: 5px;
        }

        a {
            text-decoration: none;
            color: black;
        }

        .no-reservations {
            position: relative;
            top: 5cm;
            left: 1cm;
        }

        .block {
            background-color: red;
            width: 2cm;
            height: 0.7cm;
            color: white;
            cursor: pointer;
        }

        .consulte {
            background-color: green;
            width: 2cm;
            height: 0.7cm;
            color: white;
            cursor: pointer;
        }
    </style>
</head>


<body>

    <header>
        <a href="{{route('Restaurant.dashboard')}}">
            <h2 class="site-name">admin dashboard</h2>
        </a>
        <div>
            <button class="owner-button">
                <img class="owner-image" src="{{asset($admin->pictureLink)}}" alt="Owner Image">
                <span class="owner-name">{{$admin->name}}</span>
                <span class="online-dot"></span>
            </button>
        </div>
    </header>

    <div class="sidebar">
        <div class="profile-image">
            <img class="profile-image" src="{{asset($admin->pictureLink)}}" alt="Profile Image">
        </div>
        <p class="profile-name">{{$admin->name}}</p>
        <a href="{{route('dashboard')}}">
            <div class="button-container">
                <button class="sidebar-button">restaurants_info</button>
                <img src="../images/dashboard5.jpg" alt="image">
            </div>
        </a>
        <a href="{{route('admin.clients')}}">
            <div class="button-container">
                <button class="sidebar-button">clients_info</button>
                <img src="../images/dashboard5.jpg" alt="image">
            </div>
        </a>
        <a href="{{route('admin.connectedR')}}">
            <div class="button-container">
                <button class="sidebar-button">connected_Restaurants</button>
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
        <table class="styled-table">
            <tr>
                <th>id</th>
                <th>name</th>
                <th>reservations</th>
                <th>commandes</th>
                <th>reviews</th>
                <th>blocked</th>
                <th>actions</th>
            </tr>
            @foreach($clients as $client)
            <tr>
                <td>{{$client->id}}</td>
                <td>{{$client->name}}</td>
                <td>{{$client->commandes}}</td>
                <td>{{$client->reservations}}</td>
                <td>{{$client->reviews}}</td>
                <td>{{$client->blocked}}</td>
                <td>
                    <form action="{{route('admin.blockC',['idC'=>$client->id])}}" method="post">
                        @csrf
                        <button type="submit" class="block">@if($client->blocked==true) unblock @else block @endif</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
    </main>
</body>

</html>