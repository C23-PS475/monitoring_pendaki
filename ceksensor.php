<?php

$konek = mysqli_connect("localhost", "root", "", "monitoring_pendaki");
$sql = mysqli_query($konek, "SELECT * FROM sensor ORDER BY id DESC LIMIT 1");
$data = mysqli_fetch_array($sql);
$suhu = $data["suhu"];
$kelembapan = $data["kelembapan"];
$tekanan_udara = $data["tekanan_udara"];
$ketinggian = $data["ketinggian"];
$lang = $data["lang"];
$lat = $data["lat"];
$status = $data["status"];

// Tambahkan logika untuk mengubah status menjadi teks dengan warna yang sesuai
if ($status == 1) {
    $statusText = '<span class="status-badge status-on">ON</span>';
} else {
    $statusText = '<span class="status-badge status-off">OFF</span>';
}

echo '<span id="suhu">' . $suhu . '</span>';
echo '<span id="kelembapan">' . $kelembapan . '</span>';
echo '<span id="tekanan_udara">' . $tekanan_udara . '</span>';
echo '<span id="ketinggian">' . $ketinggian . '</span>';
echo '<span id="lang">' . $lang . '</span>';
echo '<span id="lat">' . $lat . '</span>';
echo '<span id="status">' . $statusText . '</span>';
