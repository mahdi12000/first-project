<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/RestaurantDashboard.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    <!-- <script src="../js/RestaurantDashboard.js"></script> -->
    <title>Restaurant dashboard</title>
</head>

<body>
    <script>
        window.addEventListener('DOMContentLoaded', function() {
            var counter = 0;
            const owner_button = document.querySelector('.owner-button');
            const logout = document.querySelector('.logout');
            const sidebar_button = document.querySelector('.sidebar-button');

            owner_button.addEventListener('click', function() {
                counter++;
                if (counter % 2 == 0) {
                    logout.style.display = 'none';
                } else {
                    logout.style.display = 'inline-block';
                }
            });

            // sidebar_button.addEventListener('click',function(){
            //     widow.location.href='{{route("Restaurant.orders")}}';
            // });
            /*-------------------------histogramme-------------------------------------*/
            
            //extraire les donnees json
            var dailyEarningsJson = JSON.parse('{!! $dailyEarningsJson !!}');

            //extraire labels(dates)
            var labels1=dailyEarningsJson.map(function(item){
                return item.date;
            });
            // console.log(labels1);

            //extraire values(earnings)
            var data1=dailyEarningsJson.map(function(item){
                return item.earnings;
            });

            // Données de l'historique des chiffres d'affaires par jour
            var data = {
                labels: labels1,
                datasets: [{
                    label: 'daily turnover for the last 7 days',
                    data: data1,
                    backgroundColor: 'rgba(75, 192, 192, 0.5)', // Couleur de remplissage des barres
                    borderColor: 'rgba(75, 192, 192, 1)', // Couleur de la bordure des barres
                    borderWidth: 1
                }]
            };

            // Configuration de l'histogramme
            var config = {
                type: 'bar',
                data: data,
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: ''
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'daily turnover'
                            }
                        }
                    }
                }
            };

            // Création de l'histogramme
            var myChart = new Chart(document.getElementById('myChart'), config);
            /*----------------------------courbe--------------------------------------*/
            //extraire les donnees Json
            var dailyOrders = JSON.parse('{!!$dailyOrdersJson!!}');
            //extraire labels
            var dailyOrders_labels = dailyOrders.map(function(item) {
                return item.date;
            });
            //extraire date
            var dailyOrders_data = dailyOrders.map(function(item) {
                return item.dailyOrders;
            });
            // Récupérer l'élément canvas
            const ordersChartCanvas = document.getElementById('orders');

            // Récupérer les données du backend (par exemple, à l'aide d'une requête Ajax)
            const ordersData = {
                labels: dailyOrders_labels,
                datasets: [{
                    label: 'daily orders',
                    data: dailyOrders_data,
                    backgroundColor: 'rgba(0, 123, 255, 0.2)', // Couleur de fond de la courbe
                    borderColor: 'rgba(0, 123, 255, 1)', // Couleur de la ligne de la courbe
                    borderWidth: 1, // Épaisseur de la ligne de la courbe
                    pointRadius: 3, // Taille des points sur la courbe
                    pointBackgroundColor: 'rgba(0, 123, 255, 1)', // Couleur de fond des points sur la courbe
                    pointBorderColor: 'rgba(0, 0, 0, 0)', // Couleur de bordure des points sur la courbe
                    pointHoverRadius: 5, // Taille des points lors du survol sur la courbe
                    pointHoverBackgroundColor: 'rgba(0, 123, 255, 1)', // Couleur de fond des points lors du survol sur la courbe
                    pointHoverBorderColor: 'rgba(0, 0, 0, 0)', // Couleur de bordure des points lors du survol sur la courbe
                }]
            };

            // Créer le graphique
            const ordersChart = new Chart(ordersChartCanvas, {
                type: 'line', // Utiliser un graphique de type ligne pour une courbe
                data: ordersData,
                options: {
                    responsive: true, // Rendre le graphique responsive
                    maintainAspectRatio: false, // Permettre au graphique de dépasser la taille de son conteneur
                    scales: {
                        x: {
                            display: true,
                            title: {
                                display: true,
                                text: '' // Titre de l'axe des abscisses
                            }
                        },
                        y: {
                            display: true,
                            title: {
                                display: true,
                                text: 'daily orders' // Titre de l'axe des ordonnées
                            }
                        }
                    }
                }
            });
            /*--------------------------camembert-------------------------------*/
             //extraire labels
             var lab1=JSON.parse('{!!$mostOrderdJson!!}');
            //  console.log(lab1);

            const menusData = lab1;
            // Récupérer le canvas et son contexte
            const canvas = document.getElementById("diagramme_camembert");
            const context = canvas.getContext("2d");

            // Créer le diagramme en camembert
            new Chart(context, {
                type: "pie",
                data: {
                    labels: menusData.map((menu) => menu.label),
                    datasets: [{
                        data: menusData.map((menu) => menu.value),
                        backgroundColor: ["yellow", "blue", "green", "red"],
                    }, ],
                },
                options: {
                    tooltips: {
                        callbacks: {
                            label: (tooltipItem, data) => {
                                const dataset = data.datasets[tooltipItem.datasetIndex];
                                const total = dataset.data.reduce((acc, value) => acc + value, 0);
                                const value = dataset.data[tooltipItem.index];
                                const percentage = ((value / total) * 100).toFixed(2);
                                return `${data.labels[tooltipItem.index]}: ${value} (${percentage}%)`;
                            },
                        },
                    },
                },
            });
            /*-----------------------reservations histogramme--------------------*/
            // Récupérer les données JSON
            var dailyReservations = JSON.parse('{!! $dailyReservationsJson !!}');

            // Extraire les labels (dates)
            var labels = dailyReservations.map(function(item) {
                return item.date;
            });

            // Extraire les données (nombre de réservations quotidiennes)
            var data = dailyReservations.map(function(item) {
                return item.dailyReservations;
            });

            // Données de l'historique des chiffres d'affaires par jour
            var chartData = {
                labels: labels,
                datasets: [{
                    label: 'Daily Reservations',
                    data: data,
                    backgroundColor: 'rgba(75, 192, 192, 0.5)', // Couleur de remplissage des barres
                    borderColor: 'rgba(75, 192, 192, 1)', // Couleur de la bordure des barres
                    borderWidth: 1 // Largeur de la bordure des barres
                }]
            };

            // Configuration de l'histogramme
            var chartConfig = {
                type: 'bar',
                data: chartData,
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: ''
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Reservations'
                            }
                        }
                    }
                }
            };

            // Création de l'histogramme
            var myChart = new Chart(document.getElementById('reservations'), chartConfig);

        });
    </script>

    <header>
        <h2 class="site-name" onclick="window.location.href='#'">Findrestaurant</h2>
        <div>
            <button class="owner-button">
                <img class="owner-image" src="{{asset($restaurant->profile)}}" alt="Owner Image">
                <span class="owner-name">{{$restaurant->owner}}</span>
                <span class="online-dot"></span>
            </button>
        </div>
    </header>

    <div class="logout" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <p>Log out</p>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>

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
        <a href="{{ route('Restaurant.log_out') }}">
            <div class="button-container">
                <button class="sidebar-button">Logout</button>
            </div>
        </a>
    </div>
    <h1 class="dashboard">Dashboard</h1>
    <div class="total_earnings">
        <h2>{{$total_earnings}} {{$currency->currency}}</h2>
        <p> Total earnings</p>
    </div>
    <div class="total_orders">
        <h2>{{$total_orders}}</h2>
        <p>Total orders</p>
    </div>
    <div class="total_reservations">
        <h2>{{$total_reservations}}</h2>
        <p>Total reservations</p>
    </div>
    <div class="total_menus">
        <h2>{{$total_menu}}</h2>
        <p>Total menus</p>
    </div>
    <div class="total_comments">
        <h2>{{ $total_feedbacks}}</h2>
        <p>Total Feedbacks</p>
    </div>
    <div class="histogramme">
        <canvas id="myChart"></canvas>
    </div>
    <div class="courbe">
        <canvas id="orders"></canvas>
    </div>
    <div class="div_camembert">
        <canvas id="diagramme_camembert"></canvas>
    </div>
    <div class="div_reservations">
        <canvas id="reservations"></canvas>
    </div>
    <div class="comments">
        @if($randomFeebacks->count()==2)
        <h2 class="title">customer feedbacks</h2>
        <p class="SeeAll">See all</p>
        <div class="custommer_comment">
            <img src="{{asset($randomFeebacks[1]->pictureLink)}}" alt="profile" class="img">
            <P class="name">{{$randomFeebacks[1]->name}}</P>
            <p class="comment">{{$randomFeebacks[1]->review}}</p>
        </div>

        <div class="custommer_comment">
            <img src="{{asset($randomFeebacks[0]->pictureLink)}}" alt="profile" class="img">
            <p class="name">{{$randomFeebacks[0]->name}}</p>
            <p class="comment">{{$randomFeebacks[0]->review}}</p>
        </div>
        @else
        <h2>there is no comments</h2>
        @endif
    </div>
</body>

</html>