(function ($) {
    "use strict";

    //Sales chart
    var ctx = document.getElementById("sales-chart");
    ctx.height = 100;
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ["10.00.00","10.00.30","10.01.00","10.01.30","10.02.00","10.02.30","10.03.00"],
            type: 'line',
            defaultFontFamily: 'Montserrat',
            datasets: [{
                label: "Amonia",
                data: [0, 10, 20, 10, 25, 15, 150],
                backgroundColor: 'transparent',
                borderColor: '#ee609c',
                borderWidth: 3,
                pointStyle: 'circle',
                pointRadius: 5,
                pointBorderColor: 'transparent',
                pointBackgroundColor: '#ee609c',

            }, {
                label: "Metana",
                data: [0, 30, 10, 60, 50, 63, 10],
                backgroundColor: 'transparent',
                borderColor: '#4d7cff',
                borderWidth: 3,
                pointStyle: 'triangle',
                pointRadius: 5,
                pointBorderColor: 'transparent',
                pointBackgroundColor: '#4d7cff',
            }]
        },
        options: {
            responsive: true,
            tooltips: {
                mode: 'index',
                titleFontSize: 12,
                titleFontColor: '#000',
                bodyFontColor: '#000',
                backgroundColor: '#fff',
                titleFontFamily: 'Montserrat',
                bodyFontFamily: 'Montserrat',
                cornerRadius: 3,
                intersect: false,
            },
            legend: {
                labels: {
                    usePointStyle: true,
                    fontFamily: 'Montserrat',
                },
            },
            scales: {
                xAxes: [{
                    display: true,
                    gridLines: {
                        display: false,
                        drawBorder: false
                    },
                    scaleLabel: {
                        display: false,
                        labelString: 'Waktu'
                    }
                }],
                yAxes: [{
                    display: true,
                    gridLines: {
                        display: false,
                        drawBorder: false
                    },
                    scaleLabel: {
                        display: true,
                        labelString: 'Value'
                    }
                }]
            },
            title: {
                display: false,
                text: 'Normal Legend'
            }
        }
    });
})(jQuery);