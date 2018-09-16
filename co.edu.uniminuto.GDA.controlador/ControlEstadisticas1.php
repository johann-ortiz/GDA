<?php

session_start();

$conexion = mysqli_connect("localhost", "root", "", "gda");
mysqli_set_charset($conexion, "utf8");

$query = $conexion->query("SELECT DISTINCT continenteUsuario FROM indicegda;");
$continentes = array();

while ($row = $query->fetch_assoc()) {
    $continentes[] = $row['continenteUsuario'];
}

$query2 = $conexion->query("SELECT AVG(valorIndiceGDA) AS promedio FROM indicegda GROUP BY continenteUsuario;");
$promedioGDA = array();

while ($row = $query2->fetch_assoc()) {
    $promedioGDA[] = $row['promedio'];
}

echo '<canvas id="myChart" width="400" height="400"></canvas>
<script>
var ctx = document.getElementById("myChart").getContext("2d");
var myChart = new Chart(ctx, {
    type: "bar",
    data: {
        labels: ' . json_encode($continentes) . ',
        datasets: [{
            data: ' . json_encode($promedioGDA) . ',
            backgroundColor: [
                "rgba(255, 99, 132, 0.2)",
                "rgba(54, 162, 235, 0.2)",
                "rgba(255, 206, 86, 0.2)",
                "rgba(75, 192, 192, 0.2)",
                "rgba(153, 102, 255, 0.2)",
                "rgba(255, 159, 64, 0.2)"
            ],
            borderColor: [
                "rgba(255,99,132,1)",
                "rgba(54, 162, 235, 1)",
                "rgba(255, 206, 86, 1)",
                "rgba(75, 192, 192, 1)",
                "rgba(153, 102, 255, 1)",
                "rgba(255, 159, 64, 1)"
            ],
            borderWidth: 1
        }]
    },
    options: {
        legend: { display: false },
        title: { 
           display: true,
           text: "Indice GDA promedio por Continente:" },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
</script>';
