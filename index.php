<?php
// Mulai session
session_start();

// Periksa apakah session 'username' sudah diset
if (!isset($_SESSION['username'])) {
    // Jika tidak, redirect pengguna ke halaman login
    header("Location: login.php");
    exit(); // Pastikan keluar dari skrip
}

// Lakukan koneksi ke database MySQL
$servername = "localhost";
$username = "root"; // Ganti dengan username MySQL Anda
$password = ""; // Ganti dengan password MySQL Anda
$dbname = "monitoring_pendaki";

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Monitoring Pendaki</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.css" rel="stylesheet">
    <link rel="stylesheet" href="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="assets/js/mdb.min.js"></script>
    <script type="text/javascript" src="jquery-latest.js"></script>
    <script type="text/javascript" src="js/jquery.min.js"></script>

</head>

<style type="text/css">
    .status-badge {
        font-size: 1.5em;
        border-radius: 5px;
        color: #fff;
        text-align: center;
        display: inline-block;
        width: 100px;
        /* Sesuaikan lebar badge sesuai kebutuhan */
        margin-top: 45px;
        margin-bottom: 45px;
        /* Atur margin jika diperlukan */
    }

    .card-body text-center {
        height: 10em;
    }

    .status-on {
        background-color: #dc3545;
        /* Warna hijau untuk status ON */
    }

    .status-off {
        background-color: #28a745;
        /* Warna merah untuk status OFF */
    }

    div.testArea {
        display: inline-block;
        width: 12em;
        height: 10em;
        position: relative;
        box-sizing: border-box;
    }

    div.testName {
        position: absolute;
        top: -0.3em;
        left: 35%;
        width: auto;
        font-size: 1.4em;
        z-index: 9;
        white-space: nowrap;
    }

    div.testName1 {
        position: absolute;
        top: -0.3em;
        left: 20%;
        width: auto;
        font-size: 1.4em;
        z-index: 9;
        white-space: nowrap;
    }

    div.testName2 {
        position: absolute;
        top: -0.3em;
        left: 10%;
        width: auto;
        font-size: 1.4em;
        z-index: 9;
        white-space: nowrap;
    }

    div.testName3 {
        position: absolute;
        top: -0.3em;
        left: 20%;
        width: auto;
        font-size: 1.4em;
        z-index: 9;
        white-space: nowrap;
    }

    div.meterText {
        position: absolute;
        bottom: 1.2em;
        width: auto;
        font-size: 2.3em;
        z-index: 9;
        color: black;
        left: 30%;
        white-space: nowrap;
    }

    div.meterText:empty:before {
        content: "";
    }

    div.unit {
        position: absolute;
        bottom: 0.8em;
        left: 40%;
        width: auto;
        z-index: 9;
        white-space: nowrap;
    }

    div.nilai {
        position: absolute;
        bottom: 0.1em;
        left: 12%;
        width: auto;
        z-index: 9;
        white-space: nowrap;
    }

    div.nilai2 {
        position: absolute;
        bottom: 0.1em;
        left: 75%;
        width: auto;
        z-index: 9;
        white-space: nowrap;
    }

    div.testArea canvas {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
    }

    div.testGroup {
        display: inline-block;
    }

    @media all and (max-width:65em) {
        body {
            font-size: 1.5vw;
        }

        div.testName {
            top: -0.3em;
            left: 35%;
        }

        div.testName1 {
            top: -0.3em;
            left: 30%;
        }

        div.testName2 {
            top: -0.3em;
            left: 30%;
        }

        div.testName3 {
            top: -0.3em;
            left: 25%;
        }
    }

    @media all and (max-width:40em) {
        body {
            font-size: 0.8em;
        }

        div.testGroup {
            display: block;
            margin: 0 auto;
        }
    }
</style>
<script type="text/javascript">
    $(document).ready(function() {
        setInterval(function() {
            $("#suhu").load('ceksensor.php #suhu');
            $("#kelembapan").load('ceksensor.php #kelembapan');
            $("#tekanan_udara").load('ceksensor.php #tekanan_udara');
            $("#ketinggian").load('ceksensor.php #ketinggian');
            $("#lang").load('ceksensor.php #lang');
            $("#lat").load('ceksensor.php #lat');
            $("#grafik").load('data.php');
            $("#grafik2").load('data2.php');
            $("#grafik3").load('data3.php');
            $("#grafik4").load('data4.php');
            $("#status").load('ceksensor.php #status', function(responseText) {
                var statusBadge = $(responseText).find('.status-badge').text().trim(); // Ekstrak teks dari elemen dengan kelas status-badge

                // Periksa status yang diterima
                if (statusBadge === 'ON') {
                    $('#status').removeClass('status-off').addClass('status-on').text('TIDAK AMAN');
                } else if (statusBadge === 'OFF') {
                    $('#status').removeClass('status-on').addClass('status-off').text('AMAN');
                } else {
                    // Jika status tidak dikenali
                    console.log('Status tidak dikenali: ' + statusBadge);
                }
            });

            // Update lokasi peta
            var lang = parseFloat($("#lang").text());
            var lat = parseFloat($("#lat").text());
            if (!isNaN(lang) && !isNaN(lat)) {
                marker.setLatLng([lat, lang]);
                map.setView([lat, lang], 13);
            }
        }, 1000);
    });



    function I(id) {
        return document.getElementById(id);
    }
    var meterColor = "#E0E0E0";
    var suhuColor = "#778899",
        kelembapanColor = "#FF8C00",
        tekananColor = "#7B68EE",
        ketinggianColor = "#A52A2A"
    var progColor = "#EEEEEE";
    var parameters = { //custom test parameters. See doc.md for a complete list
        time_mq: 10, //download test lasts 10 seconds
        time_wl: 10, //upload test lasts 10 seconds
        time_ql: 10,
        time_kt: 10, //download test lasts 10 seconds
        count_ping: 50, //ping+jitter test does 20 pings
        getIp_ispInfo: false //will only get IP address without ISP info
    };

    //CODE FOR GAUGES
    function drawMeter(c, amount, maxAmount, bk, fg, prog) {
        var ctx = c.getContext("2d");
        var dp = window.devicePixelRatio || 1;
        var cw = c.clientWidth * dp,
            ch = c.clientHeight * dp;
        var sizScale = ch * 0.0055;
        if (c.width == cw && c.height == ch) {
            ctx.clearRect(0, 0, cw, ch);
        } else {
            c.width = cw;
            c.height = ch;
        }

        // Hitung persentase dari amount terhadap maksimum
        var percentage = amount / maxAmount;

        // Gambar busur berdasarkan persentase
        ctx.beginPath();
        ctx.strokeStyle = bk;
        ctx.lineWidth = 16 * sizScale;
        ctx.arc(c.width / 2, c.height - 58 * sizScale, c.height / 1.8 - ctx.lineWidth, -Math.PI * 1.1, Math.PI * 0.1);
        ctx.stroke();
        ctx.beginPath();
        ctx.strokeStyle = fg;
        ctx.lineWidth = 16 * sizScale;
        ctx.arc(c.width / 2, c.height - 58 * sizScale, c.height / 1.8 - ctx.lineWidth, -Math.PI * 1.1, percentage * Math.PI * 1.2 - Math.PI * 1.1);
        ctx.stroke();
        if (typeof prog !== "undefined") {
            ctx.fillStyle = prog;
            ctx.fillRect(c.width * 0.3, c.height - 16 * sizScale, c.width * 0.4 * percentage, 4 * sizScale);
        }
    }

    function updateUI(forced) {
        // Ambil nilai dlText dari elemen #dlText
        var suhuValue = parseFloat($('#suhu').text());
        var kelembapanValue = parseFloat($('#kelembapan').text());
        var tekanan_udaraValue = parseFloat($('#tekanan_udara').text());
        var ketinggianValue = parseFloat($('#ketinggian').text());

        // Tentukan warna meter berdasarkan nilai dlText
        var suhuMeterColor;
        if (suhuValue >= 0 && suhuValue <= 500) {
            suhuMeterColor = suhuColor;
        } else {
            suhuMeterColor = progColor;
        }

        var kelembapanMeterColor;
        if (kelembapanValue >= 0 && kelembapanValue <= 500) {
            kelembapanMeterColor = kelembapanColor;
        } else {
            kelembapanMeterColor = progColor;
        }

        var tekananMeterColor;
        if (tekanan_udaraValue >= 0 && tekanan_udaraValue <= 500) {
            tekananMeterColor = tekananColor;
        } else {
            tekananMeterColor = progColor;
        }

        var ketinggianMeterColor;
        if (ketinggianValue >= 0 && ketinggianValue <= 500) {
            ketinggianMeterColor = ketinggianColor;
        } else {
            ketinggianMeterColor = progColor;
        }


        // Update teks dlText
        $('#suhu').text(suhuValue);
        $('#kelembapan').text(kelembapanValue);
        $('#tekanan_udara').text(tekanan_udaraValue);
        $('#ketinggian').text(ketinggianValue);


        // Menggambar meter dengan warna yang sesuai
        drawMeter(I("suhuMeter"), suhuValue, 500, meterColor, suhuMeterColor);
        drawMeter(I("kelembapanMeter"), kelembapanValue, 500, meterColor, kelembapanMeterColor);
        drawMeter(I("tekananMeter"), tekanan_udaraValue, 500, meterColor, tekananMeterColor);
        drawMeter(I("ketinggianMeter"), ketinggianValue, 500, meterColor, ketinggianMeterColor);
    }

    //update the UI every frame
    window.requestAnimationFrame = window.requestAnimationFrame || window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame || window.msRequestAnimationFrame || (function(callback, element) {
        setTimeout(callback, 1000 / 60);
    });

    function frame() {
        requestAnimationFrame(frame);
        updateUI();
    }
    frame(); //start frame loop
</script>


<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav sidebar sidebar-dark accordion" style="background-color: 	 #2a87a5" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <img src="img/logo.png" alt="Jamur" width="50" height="50">
                </div>
                <div class="sidebar-brand-text mx-3">Monitoring Pendaki<sup>JTD</sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <li class="nav-item">
                <a class="nav-link" href="tables.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Report</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    <?php echo $_SESSION['username']; ?>
                                </span>
                                <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="login.php" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Keluar
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Content Row -->
                    <div class="row">

                        <div class="col-xl-10 col-lg-5">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h5 class="m-0 font-weight-bold" style="color:  #2a87a5">Monitoring</h5>
                                    <div class="dropdown no-arrow">
                                    </div>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body ">
                                    <div class="testGroup">
                                        <div class="testArea">
                                            <div class="testName">Suhu</div>
                                            <canvas id="suhuMeter" class="meter"></canvas>
                                            <div id="suhu" class="meterText"></div>
                                            <h4>
                                                <div class="unit">°C</div>
                                            </h4>
                                            <h5>
                                                <div class="nilai">0</div>
                                            </h5>
                                            <h5>
                                                <div class="nilai2">500</div>
                                                <h5>
                                        </div>
                                        <div class="testArea">
                                            <div class="testName1">Kelembapan</div>
                                            <canvas id="kelembapanMeter" class="meter"></canvas>
                                            <div id="kelembapan" class="meterText"></div>
                                            <h4>
                                                <div class="unit">RH</div>
                                            </h4>
                                            <h5>
                                                <div class="nilai">0</div>
                                            </h5>
                                            <h5>
                                                <div class="nilai2">500</div>
                                                <h5>
                                        </div>
                                        <div class="testArea">
                                            <div class="testName2">Tekanan Udara</div>
                                            <canvas id="tekananMeter" class="meter"></canvas>
                                            <div id="tekanan_udara" class="meterText"></div>
                                            <h4>
                                                <div class="unit">hPa</div>
                                            </h4>
                                            <h5>
                                                <div class="nilai">0</div>
                                            </h5>
                                            <h5>
                                                <div class="nilai2">500</div>
                                                <h5>
                                        </div>
                                        <div class="testArea">
                                            <div class="testName3">Ketinggian</div>
                                            <canvas id="ketinggianMeter" class="meter"></canvas>
                                            <div id="ketinggian" class="meterText"></div>
                                            <h4>
                                                <div class="unit">mdpl</div>
                                            </h4>
                                            <h5>
                                                <div class="nilai">0</div>
                                            </h5>
                                            <h5>
                                                <div class="nilai2">500</div>
                                                <h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-5">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h5 class="m-0 font-weight-bold" style="color:  #2a87a5">Status</h5>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body text-center">
                                    <div id="status" class="status-badge"></div>
                                </div>
                            </div>
                        </div>

                    </div>


                    <!-- Content Row -->

                    <div class="row">

                        <!-- Area Chart -->
                        <div class="col-xl-6 col-lg-2">
                            <div class="card shadow mb-3">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h5 class="m-0 font-weight-bold" style="color:  #2a87a5">Grafik Suhu</h5>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div id="grafik">
                                    </div>

                                </div>
                            </div>
                        </div>


                        <!-- Area Chart -->
                        <div class="col-xl-6 col-lg-3">
                            <div class="card shadow mb-3">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h5 class="m-0 font-weight-bold" style="color:  #2a87a5">Grafik Kelembapan</h5>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div id="grafik2">
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <!-- Area Chart -->
                        <div class="col-xl-6 col-lg-2">
                            <div class="card shadow mb-3">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h5 class="m-0 font-weight-bold" style="color:  #2a87a5">Grafik Tekanan Udara</h5>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div id="grafik3">
                                    </div>

                                </div>
                            </div>
                        </div>


                        <!-- Area Chart -->
                        <div class="col-xl-6 col-lg-3">
                            <div class="card shadow mb-3">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h5 class="m-0 font-weight-bold" style="color:  #2a87a5">Grafik Ketinggian</h5>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div id="grafik4">
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card shadow mb-3">
                        <!-- Card Header - Dropdown -->
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h5 class="m-0 font-weight-bold" style="color:  #2a87a5">Maps</h5>
                            <div id="lat">Latitude</div>
                            <div id="lang">Longitude</div>
                        </div>
                        <!-- Card Body -->
                        <div class="card-body">
                            <div id="map" style="height: 400px; width: 100%;">
                            </div>
                            <script>
                                var map = L.map('map').setView([51.505, -0.09], 13);

                                L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                                }).addTo(map);

                                var marker = L.marker([51.505, -0.09]).addTo(map);
                            </script>
                        </div>
                    </div>



                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class=" sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Dipersembahkan &copy; Politeknik Negeri Malang</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Anda akan keluar?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Pilih Keluar untuk meninggalkan halaman</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Kembali</button>
                    <a class="btn btn-primary" style="background-color: #2a87a5" href="login.php">Keluar</a>
                </div>
            </div>
        </div>
    </div>



    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>


</body>

</html>