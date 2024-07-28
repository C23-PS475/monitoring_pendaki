<?php

$konek = mysqli_connect("localhost", "root", "", "monitoring_pendaki");

$sql_ID = mysqli_query($konek, "SELECT MAX(ID) FROM sensor");

$data_ID = mysqli_fetch_array($sql_ID);

$ID_akhir = $data_ID['MAX(ID)'];
$ID_awal =  $ID_akhir - 6;

$tanggal = mysqli_query($konek, "SELECT DATE_FORMAT(tanggal, '%H:%i:%s') AS waktu from sensor WHERE ID>='$ID_awal' and ID<='$ID_akhir' ORDER BY ID ASC");

$ketinggian = mysqli_query($konek, "SELECT ketinggian from sensor WHERE ID>='$ID_awal' and ID<='$ID_akhir' ORDER BY ID ASC");


?>

<div class="card-body">
    <canvas id="mychart4"></canvas>
    <script type="text/javascript">
        var canvas2 = document.getElementById('mychart4');
        var data2 = {
            labels: [
                <?php
                while ($data_tanggal = mysqli_fetch_array($tanggal)) {
                    echo '"' . $data_tanggal['waktu'] . '",';
                }
                ?>
            ],
            datasets: [{
                label: "ketinggian",
                fill: true,
                backgroundColor: "#e18b8b",
                borderColor: "#A52A2A",
                lineTension: 0.5,
                pointRadius: 5,
                data: [
                    <?php
                    while ($data_ketinggian = mysqli_fetch_array($ketinggian)) {
                        echo $data_ketinggian['ketinggian'] . ',';
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