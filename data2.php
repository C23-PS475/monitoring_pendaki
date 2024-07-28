<?php

$konek = mysqli_connect("localhost", "root", "", "monitoring_pendaki");

$sql_ID = mysqli_query($konek, "SELECT MAX(ID) FROM sensor");

$data_ID = mysqli_fetch_array($sql_ID);

$ID_akhir = $data_ID['MAX(ID)'];
$ID_awal =  $ID_akhir - 6;

$tanggal = mysqli_query($konek, "SELECT DATE_FORMAT(tanggal, '%H:%i:%s') AS waktu from sensor WHERE ID>='$ID_awal' and ID<='$ID_akhir' ORDER BY ID ASC");

$kelembapan = mysqli_query($konek, "SELECT kelembapan from sensor WHERE ID>='$ID_awal' and ID<='$ID_akhir' ORDER BY ID ASC");


?>

<div class="card-body">
    <canvas id="mychart2"></canvas>
    <script type="text/javascript">
        var canvas2 = document.getElementById('mychart2');
        var data2 = {
            labels: [
                <?php
                while ($data_tanggal = mysqli_fetch_array($tanggal)) {
                    echo '"' . $data_tanggal['waktu'] . '",';
                }
                ?>
            ],
            datasets: [{
                label: "Kelembapan",
                fill: true,
                backgroundColor: "#ffc176",
                borderColor: "#FF8C00",
                lineTension: 0.5,
                pointRadius: 5,
                data: [
                    <?php
                    while ($data_kelembapan = mysqli_fetch_array($kelembapan)) {
                        echo $data_kelembapan['kelembapan'] . ',';
                    }
                    ?>
                ]
            }]

        };

        var options2 = {
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Waktu' // Label untuk sumbu x
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Nilai' // Label untuk sumbu y
                    }
                }
            },
            showLines: true,
            animation: {
                duration: 5
            }
        };

        var myLineChart2 = new Chart(canvas2, {
            type: 'line',
            data: data2,
            options: options2
        });
    </script>
</div>