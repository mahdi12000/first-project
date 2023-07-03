window.addEventListener('DOMContentLoaded', function () {
    var counter = 0;
    const owner_button = document.querySelector('.owner-button');
    const logout = document.querySelector('.logout');
    owner_button.addEventListener('click', function () {
        counter++;
        if (counter % 2 == 0) {
            logout.style.display = 'none';
        }
        else {
            logout.style.display = 'inline-block';
        }
    });
    /*-------------------------histogramme-------------------------------------*/
    // Données de l'historique des chiffres d'affaires par jour
    var data = {
        labels: ['day 1', 'day 2', 'day 3', 'day 4', 'day 5', 'day 6', 'day 7'],
        datasets: [{
            label: 'daily turnover for the last 7 days (USD)',
            data: [500, 700, 900, 1200, 800, 600, 1000],
            backgroundColor: 'rgba(75, 192, 192, 0.5)', // Couleur de remplissage des barres
            borderColor: 'rgba(75, 192, 192, 1)', // Couleur de la bordure des barres
            borderWidth: 1 // Largeur de la bordure des barres
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
                        text: 'days'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'turnover'
                    }
                }
            }
        }
    };

    // Création de l'histogramme
    var myChart = new Chart(document.getElementById('myChart'), config);
    /*----------------------------courbe--------------------------------------*/
    // Récupérer l'élément canvas
    const ordersChartCanvas = document.getElementById('orders');

    // Récupérer les données du backend (par exemple, à l'aide d'une requête Ajax)
    const ordersData = {
        labels: ['day 1', 'day 2', 'day 3', 'day 4', 'day 5', 'day 6', 'day 7'],
        datasets: [
            {
                label: 'daily orders',
                data: [10, 8, 15, 12, 6, 9, 11],
                backgroundColor: 'rgba(0, 123, 255, 0.2)', // Couleur de fond de la courbe
                borderColor: 'rgba(0, 123, 255, 1)', // Couleur de la ligne de la courbe
                borderWidth: 1, // Épaisseur de la ligne de la courbe
                pointRadius: 3, // Taille des points sur la courbe
                pointBackgroundColor: 'rgba(0, 123, 255, 1)', // Couleur de fond des points sur la courbe
                pointBorderColor: 'rgba(0, 0, 0, 0)', // Couleur de bordure des points sur la courbe
                pointHoverRadius: 5, // Taille des points lors du survol sur la courbe
                pointHoverBackgroundColor: 'rgba(0, 123, 255, 1)', // Couleur de fond des points lors du survol sur la courbe
                pointHoverBorderColor: 'rgba(0, 0, 0, 0)', // Couleur de bordure des points lors du survol sur la courbe
            }
        ]
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
                        text: 'days' // Titre de l'axe des abscisses
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
    const menusData = [
        { label: "pizza", value: 50 },
        { label: "tacos", value: 30 },
        { label: "humburgur", value: 20 },
        { label: "salade", value: 40 }
    ];
    // Récupérer le canvas et son contexte
    const canvas = document.getElementById("diagramme_camembert");
    const context = canvas.getContext("2d");

    // Créer le diagramme en camembert
    new Chart(context, {
        type: "pie",
        data: {
            labels: menusData.map((menu) => menu.label),
            datasets: [
                {
                    data: menusData.map((menu) => menu.value),
                    backgroundColor: ["yellow", "blue", "green", "red"],
                },
            ],
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
    var labels = dailyReservations.map(function (item) {
        return item.date;
    });

    // Extraire les données (nombre de réservations quotidiennes)
    var data = dailyReservations.map(function (item) {
        return item.dailyReservations;
    });

    // Données de l'historique des chiffres d'affaires par jour
    var chartData = {
        labels: labels,
        datasets: [{
            label: 'Daily Reservations for last 7 days',
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
                        text: 'Days'
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