<?php
include('koneksi.php');

$datacovid = mysqli_query($koneksi, "SELECT * FROM covid LIMIT 10");
$negara = [];
$jumlah_kasus = [];
$jumlah_kematian = [];
$jumlah_sembuh = [];
$active_cases = [];
$total_tests = [];

while ($row = mysqli_fetch_array($datacovid)) {
    $negara[] = $row['negara'];

    $query = mysqli_query($koneksi, "SELECT kasus, kematian, disembuhkan, `kasus aktif`, `total test` FROM covid WHERE id_negara=" . $row['id_negara']);
    $row = $query->fetch_array();

    $jumlah_kasus[] = $row['kasus'];
    $jumlah_kematian[] = $row['kematian'];
    $jumlah_sembuh[] = $row['disembuhkan'];
    $active_cases[] = $row['kasus aktif'];
    $total_tests[] = $row['total test'];
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
            type: 'pie',
            data: {
                labels: <?php echo json_encode($negara); ?>,
                datasets: [
                    {
                        label: 'Kasus',
                        data: <?php echo json_encode($jumlah_kasus); ?>,
                        backgroundColor: ['pink', 'black', 'yellow', 'red', 'blue', 'brown', 'green', 'gray', 'purple', 'orange'],
                        borderColor: 'rgba(139, 69, 19, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Kematian',
                        data: <?php echo json_encode($jumlah_kematian); ?>,
                        backgroundColor: ['pink', 'black', 'yellow', 'red', 'blue', 'brown', 'green', 'gray', 'purple', 'orange'],
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Disembuhkan',
                        data: <?php echo json_encode($jumlah_sembuh); ?>,
                        backgroundColor: ['pink', 'black', 'yellow', 'red', 'blue', 'brown', 'green', 'gray', 'purple', 'orange'],
                        borderColor: 'rgba(255, 206, 86, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Kasus aktif',
                        data: <?php echo json_encode($active_cases); ?>,
                        backgroundColor: ['pink', 'black', 'yellow', 'red', 'blue', 'brown', 'green', 'gray', 'purple', 'orange'],
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Total Tests',
                        data: <?php echo json_encode($total_tests); ?>,
                        backgroundColor: ['pink', 'black', 'yellow', 'red', 'blue', 'brown', 'green', 'gray', 'purple', 'orange'],
                        borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 1
                    }
                ]
            }
        });
    </script>
</body>
</html>
