<?php

$konek = mysqli_connect("localhost", "root", "", "monitoring_pendaki");

$sql_ID = mysqli_query($konek, "SELECT MAX(ID) FROM sensor");

$data_ID = mysqli_fetch_array($sql_ID);

$ID_akhir = $data_ID['MAX(ID)'];
$ID_awal =  $ID_akhir - 6;

$tanggal = mysqli_query($konek, "SELECT DATE_FORMAT(tanggal, '%H:%i:%s') AS waktu from sensor WHERE ID>='$ID_awal' and ID<='$ID_akhir' ORDER BY ID ASC");

$tekanan_udara = mysqli_query($konek, "SELECT tekanan_udara from sensor WHERE ID>='$ID_awal' and ID<='$ID_akhir' ORDER BY ID ASC");


?>

<div class="card-body">
    <canvas id="mychart3"></canvas>
    <script type="text/javascript">
        var canvas2 = document.getElementById('mychart3');
        var data2 = {
            labels: [
                <?php
                while ($data_tanggal = mysqli_fetch_array($tanggal)) {
                    echo '"' . $data_tanggal['waktu'] . '",';
                }
                ?>
            ],
            datasets: [{
                label: "tekanan_udara",
                fill: true,
                backgroundColor: "#b9aff6",
                borderColor: "#7B68EE",
                lineTension: 0.5,
                pointRadius: 5,
                data: [
                    <?php
                    while ($data_tekanan_udara = mysqli_fetch_array($tekanan_udara)) {
                        echo $data_tekanan_udara['tekanan_udara'] . ',';
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