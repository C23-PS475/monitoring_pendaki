<?php

$konek = mysqli_connect("localhost", "root", "", "monitoring_pendaki");

$suhu = $_GET["suhu"];
$kelembapan = $_GET["kelembapan"];
$tekanan_udara = $_GET["tekanan_udara"];
$ketinggian = $_GET["ketinggian"];
$lang = $_GET["lang"];
$lat = $_GET["lat"];
$status = $_GET["status"];

mysqli_query($konek, "ALTER TABLE sensor AUTO_INCREMENT=1");
mysqli_query($konek, "INSERT INTO sensor(suhu, kelembapan, tekanan_udara,ketinggian,lang,lat, status)VALUES('$suhu', '$kelembapan', '$tekanan_udara','$ketinggian','$lang','$lat', '$status')");
