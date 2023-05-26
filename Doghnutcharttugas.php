<?php
include('koneksi.php');

$datacovid = mysqli_query($koneksi, "SELECT * FROM covid LIMIT 10");
$negara = [];
$jumlah_kasus = [];
$jumlah_kematian = [];
$jumlah_sembuh = [];
$active_cases = [];
$total_tests = [];

$warna_latar_belakang = [
    'rgba(139, 69, 19, 0.2)', // India (coklat)
    'rgba(54, 162, 235, 0.2)', // Japan (biru)
    'rgba(0, 128, 0, 0.2)', // S. Korea (hijau)
    'rgba(255, 206, 86, 0.2)', // Turkey (kuning)
    'rgba(255, 192, 203, 0.2)', // Vietnam (pink)
    'rgba(255, 165, 0, 0.2)', // Taiwan (oren)
    'rgba(128, 128, 128, 0.2)', // Iran (abu-abu)
    'rgba(255, 0, 0, 0.2)', // Indonesia (merah)
    'rgba(128, 0, 128, 0.2)', // Malaysia (ungu)
    'rgba(0, 0, 0, 0.2)' // Israel (hitam)
];

$warna_batas = [
    'rgba(139, 69, 19, 1)',
    'rgba(54, 162, 235, 1)',
    'rgba(0, 128, 0, 1)',
    'rgba(255, 206, 86, 1)',
    'rgba(255, 192, 203, 1)',
    'rgba(255, 165, 0, 1)',
    'rgba(128, 128, 128, 1)',
    'rgba(255, 0, 0, 1)',
    'rgba(128, 0, 128, 1)',
    'rgba(0, 0, 0, 1)'
];

$index_warna = 0;

while ($row = mysqli_fetch_array($datacovid)) {
    $negara[] = $row['negara'];

    $query = mysqli_query($koneksi, "SELECT kasus, kematian, disembuhkan, `kasus aktif`, `total test` FROM covid WHERE id_negara=" . $row['id_negara']);
    $row = $query->fetch_array();

    $jumlah_kasus[] = $row['kasus'];
    $jumlah_kematian[] = $row['kematian'];
    $jumlah_sembuh[] = $row['disembuhkan'];
    $active_cases[] = $row['kasus aktif'];
    $total_tests[] = $row['total test'];

    $index_warna++;
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Membuat Grafik Menggunakan Chart JS</title>
    <link href="https://cdn.jsdelivr.net/npm/chart.js" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<body>
    <div style="width: 800px; height: 400px;">
        <canvas id="myChart"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctx = document.getElementById("myChart").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: <?php echo json_encode($negara); ?>,
                datasets: [
                    {
                        label: 'Kasus',
                        data: <?php echo json_encode($jumlah_kasus); ?>,
                        backgroundColor: <?php echo json_encode($warna_latar_belakang); ?>,
                        borderColor: <?php echo json_encode($warna_batas); ?>,
                        borderWidth: 1
                    }
                ]
            }
        });
    </script>
</body>
</html>
